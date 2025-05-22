<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index() 
    {
        return Inertia::render('dashboard/notifications', [
            'notifications' => auth()->user()->notifications,
        ]);
    }
}
