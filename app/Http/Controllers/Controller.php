<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

abstract class Controller
{
    protected function successMessage(string $message, ?string $route = null, array $routeParams = []): RedirectResponse
    {
        $redirect = $route ? redirect()->route($route, $routeParams) : back();

        return $redirect->with('success', $message);
    }

    protected function errorMessage(string $message, ?string $route = null): RedirectResponse
    {
        $redirect = $route ? redirect()->route($route) : back();
        return $redirect->with('error', $message);
    }
}
