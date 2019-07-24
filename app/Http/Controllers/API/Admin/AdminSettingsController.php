<?php

namespace App\Http\Controllers\API\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminSettingsController extends Controller
{
    public function index() {
        $this->authorize('isSA');
        $settings = Setting::all();
        return response($settings);
    }

    public function create(Request $request) {

        $this->validate($request, [
            'value' => 'required|max:255',
            'name'=> 'required'
        ]);
        $this->authorize('isSuperAdmin');

        $ref = Setting::whereName($request->name)->first();
        if(!$ref) {
            $setting = new Setting();
            $setting->name = $request->name;
            $setting->value = $request->value;
            $setting->save();
            return response('Setting successfully');
        }
        return Setting::whereName($request->name)->update([
            'value' => $request->value
        ]);
    }

    public function rate() {
        $rate = Setting::whereName('BKY_EXCHANGE_RATE')->first();
        return response($rate->value);
    }

    public function delete($id) {
        $this->authorize('isSuperAdmin');

        $setting = Setting::find($id);
        $setting->delete();
        return response([
            'status' => 'success',
            'message' => 'Setting deleted successfully'
        ]);
    }
}
