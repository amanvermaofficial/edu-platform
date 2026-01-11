<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $student = Student::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'google_id' => $googleUser->id,
                    'name' => $googleUser->name,
                    'profile_picture' => $googleUser->avatar,
                ]
            );

            // ✅ Sanctum token create karo
            $token = $student->createToken('auth-token')->plainTextToken;

            // ✅ Token ke saath redirect karo
            $frontendUrl = config('app.frontend_url') . '/auth/success';
            return redirect($frontendUrl . '?token=' . $token);

        } catch (\Exception $e) {
            return redirect(config('app.frontend_url') . '/login?error=auth_failed');
        }
    }
}