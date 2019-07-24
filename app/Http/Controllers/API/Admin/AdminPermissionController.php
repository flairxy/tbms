<?php

namespace App\Http\Controllers\API\Admin;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPermissionController extends Controller
{
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'min:2|max:255'
        ])->validate();


        Permission::create([
            'slug' => $request->slug,
            'description' => $request->slug . 'permission',
        ]);
        return response('Permission created successfully');
    }

    public function delete($id) {

        Permission::findOrFail($id)->delete();
        return response('Permission created successfully');
    }
}
