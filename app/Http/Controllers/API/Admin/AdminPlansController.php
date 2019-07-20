<?php

namespace App\Http\Controllers\API\Admin;

use App\Plan;
use App\Style;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPlansController extends Controller
{
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:2|max:255',
            'style_id' => 'required',
            'min' => 'required',
            'duration' => 'required',
            'percentage' => 'required',
        ]);

        $plan = new Plan();
        $plan->fill($request->all());
        $plan->save();
        return response('Plan create successfully');
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|min:2|max:255',
            'style_id' => 'required',
            'min' => 'required',
            'duration' => 'required',
            'percentage' => 'required',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->fill($request->all());
        $plan->save();
        return response('Plan updated successfully');
    }

    public function delete($id) {
        $plan = Plan::find($id);
        $plan->delete();
        return response([
            'status' => 'success',
            'message' => 'Plan deleted successfully'
        ]);
    }

    public function edit($id) {
        $plan = Plan::findOrFail($id);
        return response($plan);
    }

    public function index() {
        $plans = Plan::all();
        return response($plans);
    }

    public function styles() {
        $styles = Style::all();
        return response($styles);

    }
}
