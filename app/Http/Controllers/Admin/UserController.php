<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserApprovedNotification;
use App\Notifications\UserRejectedNotification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        // Envoyer une notification à l'utilisateur
        $user->notify(new UserApprovedNotification());

        return redirect()
            ->back()
            ->with('success', 'Utilisateur approuvé et notification envoyée');
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        // Envoyer une notification à l'utilisateur
        $user->notify(new UserRejectedNotification());

        return redirect()
            ->back()
            ->with('success', 'Utilisateur rejeté et notification envoyée');
    }

    public function destroy(User $user)
    {
        $userName = $user->name;
        $user->delete();

        return redirect()
            ->back()
            ->with('success', "Utilisateur '{$userName}' supprimé avec succès");
    }
}