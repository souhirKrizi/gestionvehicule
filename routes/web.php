<?php
// routes/web.php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\VehicleController as AdminVehicle;
use App\Http\Controllers\Admin\MessageController as AdminMessage;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\User\VehicleController as UserVehicle;
use App\Http\Controllers\User\MessageController as UserMessage;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin() 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.vehicles.index');
    }
    return view('welcome');
});

// Routes Auth (Breeze)
require __DIR__.'/auth.php';

// Routes du profil (disponible pour tous les utilisateurs authentifiés)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Middleware pour vérifier l'approbation
Route::middleware(['auth', 'approved'])->group(function () {
    
    // Routes ADMIN
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->group(function () {
            
            Route::get('/dashboard', [AdminDashboard::class, 'index'])
                ->name('dashboard');
            
            // Gestion des véhicules
            Route::resource('vehicles', AdminVehicle::class);
            
            // Gestion des messages
            Route::get('/messages', [AdminMessage::class, 'index'])
                ->name('messages.index');
            Route::get('/messages/{message}', [AdminMessage::class, 'show'])
                ->name('messages.show');
            Route::post('/messages/{message}/reply', [AdminMessage::class, 'reply'])
                ->name('messages.reply');
            
            // Gestion des utilisateurs
            Route::get('/users', [AdminUser::class, 'index'])
                ->name('users.index');
            Route::post('/users/{user}/approve', [AdminUser::class, 'approve'])
                ->name('users.approve');
            Route::post('/users/{user}/reject', [AdminUser::class, 'reject'])
                ->name('users.reject');
            Route::delete('/users/{user}', [AdminUser::class, 'destroy'])
                ->name('users.destroy');
        });
    
    // Routes UTILISATEUR
    Route::prefix('user')
        ->name('user.')
        ->group(function () {
            
            // Consultation des véhicules
            Route::get('/vehicles', [UserVehicle::class, 'index'])
                ->name('vehicles.index');
            Route::get('/vehicles/{vehicle}', [UserVehicle::class, 'show'])
                ->name('vehicles.show');
            
            // Messages
            Route::resource('messages', UserMessage::class)
                ->only(['index', 'create', 'store', 'show']);
        });
});