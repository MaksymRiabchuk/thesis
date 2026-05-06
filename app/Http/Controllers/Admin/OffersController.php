<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class OffersController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Offers/Index');
    }

    public function edit()
    {
        return Inertia::render('Admin/Offers/Edit');
    }
}
