<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice page.
     * Shown after register/login when email is not yet verified.
     */
    public function notice(Request $request): View|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('account.dashboard');
        }

        return view('shop.auth.verify-email', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Handle the email verification link click.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('account.dashboard')
                ->with('success', 'Email Anda sudah terverifikasi sebelumnya.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('account.dashboard')
            ->with('success', 'Email berhasil diverifikasi! Selamat datang di Klik.Cake. 🎂');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('account.dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi telah dikirim ulang ke email Anda. Silakan cek kotak masuk Gmail Anda.');
    }
}
