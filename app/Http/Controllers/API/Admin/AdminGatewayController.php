<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gateway;

class AdminGatewayController extends Controller
{
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'charge' => 'required|max:255',
        ]);

        $gateway = new Gateway();
        $gateway->fill($request->all());
        $gateway->save();
        return response('Gateway create successfully');
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'charge' => 'required|max:255',
        ]);

        $gateway = Gateway::findOrFail($id);
        $gateway->fill($request->all());
        $gateway->save();
        return response('Gateway updated successfully');
    }

    public function delete($id) {
        $gateway = Gateway::find($id);
        $gateway->delete();
        return response([
            'status' => 'success',
            'message' => 'Gateway deleted successfully'
        ]);
    }

    public function edit($id) {
        $gateway = Gateway::findOrFail($id);
        return response($gateway);
    }

    public function index() {
        $gateway = Gateway::all();
        return response($gateway);
    }
}
