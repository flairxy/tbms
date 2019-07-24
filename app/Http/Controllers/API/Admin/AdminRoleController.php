<?php

namespace App\Http\Controllers\API\Admin;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
{
    public function fetchRoles()
    {
        $roles = Role::all();
        return response([
            'roles' => $roles
        ]);
    }

    public function fetchRole($id)
    {
        $role = Role::findOrFail($id);
        return response([
            'roles' => $role
        ]);
    }

    public function updateRole(Request $request)
    {
        $this->authorize('isSuperAdmin');
        $slugs = $request->permissions;
        $role = Role::findOrFail($request->role);
        $permissions = Permission::whereIn('slug', $slugs)->get();
        $role->permissions()->sync($permissions);
        return response(['role' => $role, 'permissions' => $permissions]);
    }

    public function createRole(Request $request)
    {

        $this->authorize('isSuperAdmin');
        foreach ($request->permissions as $permission) {
            $word = explode('-', $permission);
            Permission::firstOrCreate([
                'slug' => $permission,
                'description' => implode('s ', $word)
            ]);
        }
        $role_permissions = Permission::whereIn('slug', $request->permissions)->get();
        $role = Role::create([
            'slug' => $request->role,
            'description' => $request->role . ' role'
        ]);
        $role->permissions()->attach($role_permissions);
        return response([
            'role' => $role
        ]);
    }

    public function renameRole(Request $request, $id)
    {
        $this->authorize('isSuperAdmin');

        $role = Role::find($id);
        $role->slug = $request->slug;
        $role->description = $request->slug . ' role';
        $role->save();
        return response([
            'role' => $role
        ]);
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();
        return response('Role deleted successfully');
    }
}
