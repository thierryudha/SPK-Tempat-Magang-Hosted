<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Update data Google dan tandai sebagai verified jika belum
                $user->update([
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // Buat user baru (otomatis verified karena dari Google)
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user);

            // Redirect ke dashboard admin atau user
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Gagal login menggunakan Google: ' . $e->getMessage());
        }
    }
}
