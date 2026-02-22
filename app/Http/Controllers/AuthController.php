<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function login(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function forgotPassword(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function register(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function signIn(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        return $this->successMessage('Successfully logged in');
    }
}
