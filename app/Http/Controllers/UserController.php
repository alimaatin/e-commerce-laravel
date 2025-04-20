<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('admin/users/index', ['users' => $users]);
    }
    public function edit(User $user)
    {
        return Inertia::render('admin/users/edit', ['user' => $user]);
    }
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('admin.users');
    }
}
