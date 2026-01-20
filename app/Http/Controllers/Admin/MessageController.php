<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $message->update(['status' => 'read']);
        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, Message $message)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string'
        ]);

        $message->update([
            'admin_reply' => $validated['admin_reply'],
            'status' => 'replied'
        ]);

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Réponse envoyée avec succès');
    }
}