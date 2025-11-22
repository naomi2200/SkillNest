<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->isStudent(), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'timezone' => ['nullable', 'string', 'max:255'],
            'notification_channel' => ['required', Rule::in(['email', 'push'])],
            'profile_level' => ['required', Rule::in(['principiante', 'intermedio', 'avanzado'])],
            'avatar' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_url && str_starts_with($user->avatar_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar_url));
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar_url'] = Storage::url($path);
        }

        $user->update($data);

        return back()->with('status', 'Perfil actualizado correctamente.');
    }
}
