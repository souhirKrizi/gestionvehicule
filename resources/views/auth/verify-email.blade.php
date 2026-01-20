@extends('layouts.app')

@section('title', 'Vérifier Email')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Vérifier votre email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Merci d'avoir créé un compte. Veuillez vérifier votre email.
            </p>
        </div>

        @if (session('status'))
            <div class="rounded-md bg-green-50 p-4">
                <div class="text-sm font-medium text-green-800">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="rounded-md bg-blue-50 p-4">
            <p class="text-sm text-blue-800">
                Un lien de vérification a été envoyé à votre adresse email. 
                Merci de cliquer sur le lien pour vérifier votre compte.
            </p>
        </div>

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Renvoyer l'email de vérification
            </button>
        </form>

        <div class="text-center">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
