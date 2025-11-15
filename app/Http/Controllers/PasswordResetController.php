<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        Log::info('Password reset requested for: ' . $request->email);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Reset link sent to: ' . $request->email);
            return response()->json([
                'message' => 'Enlace de recuperación enviado a tu email'
            ]);
        }

        Log::error('Reset link failed for: ' . $request->email . ' - Status: ' . $status);
        return response()->json([
            'message' => 'No pudimos enviar el enlace de recuperación'
        ], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        Log::info('Password reset attempt for: ' . $request->email);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                Log::info('Password reset successful for: ' . $user->email);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Contraseña actualizada correctamente'
            ]);
        }

        Log::error('Password reset failed for: ' . $request->email . ' - Status: ' . $status);
        return response()->json([
            'message' => 'Error al actualizar la contraseña'
        ], 400);
    }

    public function showResetForm(Request $request)
    {
        return response()->json([
            'email' => $request->email,
            'token' => $request->token
        ]);
    }
}