<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function edit()
    {
        $permissions = Permission::all();
        $roles = Role::all();

        return view('roles', compact('roles', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'permissions' => 'nullable|array',
        ]);

        if ($request->filled('permissions')) {
            $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
            $role->permissions()->sync($permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('users.roles.index')
            ->with('success', 'Role updated successfully.');
    }
}
