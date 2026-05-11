<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,opticien,employe',
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,opticien,employe',
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        // Changer le mot de passe si renseigné
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::min(8)],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
{
    if ($user->id === auth()->id()) {
        return redirect()->route('admin.users.index')
                         ->with('error', 'Vous ne pouvez pas modifier votre propre statut.');
    }

    // Toggle — bascule l'état actuel
    $newStatus = !$user->is_active;
    $user->update(['is_active' => $newStatus]);

    $message = $newStatus ? 'Utilisateur activé avec succès.' : 'Utilisateur désactivé.';

    return redirect()->route('admin.users.index')
                     ->with('success', $message);
}
}
