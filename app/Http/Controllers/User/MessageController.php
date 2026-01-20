<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = auth()->user()
            ->messages()
            ->latest()
            ->paginate(10);

        return view('user.messages.index', compact('messages'));
    }

    public function create()
    {
        return view('user.messages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        auth()->user()->messages()->create($validated);

        return redirect()
            ->route('user.messages.index')
            ->with('success', 'Message envoyé avec succès');
    }

    public function show(Message $message)
    {
        // Vérifier que le message appartient à l'utilisateur
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.messages.show', compact('message'));
    }
}