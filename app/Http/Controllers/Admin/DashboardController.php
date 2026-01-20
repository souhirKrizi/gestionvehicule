<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Message;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_vehicles' => Vehicle::count(),
            'operational' => Vehicle::where('status', 'operational')->count(),
            'broken' => Vehicle::where('status', 'broken')->count(),
            'maintenance' => Vehicle::where('status', 'maintenance')->count(),
            'unread_messages' => Message::unread()->count(),
            'pending_users' => User::where('status', 'pending')->count(),
        ];

        $recent_messages = Message::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_messages'));
    }
}
