<?php

namespace App\Services;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function __construct()
    {
    }

    public function checkAndSendEmail(string $email): void
    {
        if (User::where('email', $email)->exists()) {
            $resetPassword = new ResetPasswordMail();
            Mail::to($email)->send($resetPassword);
        }
    }
}
