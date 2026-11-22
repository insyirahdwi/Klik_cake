<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Show the "Lupa Password" form.
     */
    public function showForgot(): View
    {
        return view('shop.auth.forgot-password');
    }

    /**
     * Send a password reset link to the given email.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::ResetLinkSent) {
            return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek kotak masuk Gmail.');
        }

        return back()->withErrors([
            'email' => $status === Password::INVALID_USER
                ? 'Tidak ada akun yang terdaftar dengan email ini.'
                : 'Gagal mengirim link reset. Silakan coba lagi beberapa saat.',
        ])->onlyInput('email');
    }

    /**
     * Show the password reset form (accessed from email link).
     */
    public function showReset(Request $request, string $token): View
    {
        return view('shop.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'token.required'     => 'Token reset tidak valid.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal terdiri dari :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password'       => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PasswordReset) {
            return redirect()->route('login')
                ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
        }

        return back()->withErrors([
            'email' => $status === Password::INVALID_TOKEN
                ? 'Link reset password tidak valid atau sudah kadaluarsa. Silakan minta link baru.'
                : 'Gagal mereset password. Silakan coba lagi.',
        ])->onlyInput('email');
    }
}
