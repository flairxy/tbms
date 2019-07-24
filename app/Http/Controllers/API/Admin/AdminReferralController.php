<?php

namespace App\Http\Controllers\API\Admin;

use App\Referral;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class AdminReferralController extends Controller
{
    public function create(Request $request) {
        $this->validate($request, [
            'amount' => 'required|min:2|max:255',
        ]);

        $this->authorize('isSuperAdmin');

        $ref = Setting::whereName('REFERRALS')->first();
        if(!$ref) {
            $setting = new Setting();
            $setting->name = 'REFERRALS';
            $setting->value = $request->amount;
            $setting->save();
            return response('Referral set successfully');
        }
        return Setting::whereName('REFERRALS')->update([
            'value' => $request->amount
        ]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'amount' => 'required|min:2|max:255',
        ]);

        $this->authorize('isSuperAdmin');

        $setting = Setting::findOrFail($id);
        $setting->value = $request->amount;
        $setting->save();
        return response('Referral updated successfully');
    }

    public function delete($id) {
        $this->authorize('isSuperAdmin');

        $referral = Setting::find($id);
        $referral->delete();
        return response([
            'status' => 'success',
            'message' => 'Referral deleted successfully'
        ]);
    }

    public function edit($id) {
        $this->authorize('isSuperAdmin');
        $referral = Setting::findOrFail($id);
        return response($referral);
    }

    public function index() {
        $referral = Setting::whereName('REFERRAL_BONUS')->first();
        return response($referral);
    }

    public function getUserReferrals($id) {
//        logged in user
//        get all the user_id where parent id is id

        $refs = Referral::whereParentId($id)->pluck('user_id');
        $users = User::whereIn('id', $refs)->get();


        return response($users);

    }
}
