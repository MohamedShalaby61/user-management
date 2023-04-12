<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['roles' => $this->userService->getAllRoles()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->userService->createUser($data);

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userService->getUser($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable',
        ]);


        $this->userService->updateUser($user->id, $data);

        if(!empty($data['role'])){
            $user->assignRole($data['role']);
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
