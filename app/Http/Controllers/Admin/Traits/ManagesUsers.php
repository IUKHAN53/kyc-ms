<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

trait ManagesUsers
{
    /**
     * Store a new user with the given role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $role          The role to assign (e.g., 'user', 'supervisor').
     * @param  string  $storageFolder The folder name (on the public disk) where the profile image will be stored.
     * @param  array   $extraRules    Additional validation rules (e.g. for group_id, client_id).
     * @param  array   $extraData     Extra data to merge into the validated data (optional).
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUser(Request $request, $role, $storageFolder, array $extraRules = [], array $extraData = [])
    {
        $baseRules = [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $rules = array_merge($baseRules, $extraRules);
        $validatedData = $request->validate($rules);
        // If extra fields are validated, they are already part of $validatedData.
        $validatedData = array_merge($validatedData, $extraData);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store($storageFolder, 'public');
            $validatedData['profile_image'] = $path;
        }

        $validatedData['role'] = $role;
        $validatedData['password'] = Hash::make($validatedData['password']);

        \App\Models\User::create($validatedData);

        return redirect()->back()->with('success', ucfirst($role) . ' criado com sucesso.');
    }

    /**
     * Update an existing user with the given role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user          The user model instance.
     * @param  string $role           Expected role of the user.
     * @param  string $storageFolder  Folder name for storing profile images.
     * @param  array  $extraRules     Additional validation rules.
     * @param  array  $extraData      Extra data to merge (optional).
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, $user, $role, $storageFolder, array $extraRules = [], array $extraData = [])
    {
        $baseRules = [
            'name'          => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->filled('password')) {
            $baseRules['password'] = 'nullable|string|min:6|confirmed';
        }

        $rules = array_merge($baseRules, $extraRules);
        $validatedData = $request->validate($rules);
        $validatedData = array_merge($validatedData, $extraData);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store($storageFolder, 'public');
            $validatedData['profile_image'] = $path;
        } else {
            unset($validatedData['profile_image']);
        }

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->back()->with('success', ucfirst($role) . ' atualizado com sucesso.');
    }

    /**
     * Delete the given user if they have the expected role.
     *
     * @param  mixed  $user The user model instance.
     * @param  string $role Expected role.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyUser($user, $role)
    {
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return redirect()->back()->with('success', ucfirst($role) . ' removido com sucesso.');
    }
}
