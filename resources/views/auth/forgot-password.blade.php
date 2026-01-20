@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Forgot your password?
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
      </p>
    </div>

    @if ($errors->any())
      <div class="rounded-md bg-red-50 p-4">
        <div class="flex">
          <div class="ml-3">
            <ul class="list-disc list-inside space-y-1">
              @foreach ($errors->all() as $error)
                <li class="text-sm text-red-700">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    @endif

    <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
        <input
          id="email"
          name="email"
          type="email"
          required
          value="{{ old('email') }}"
          class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
          placeholder="Email address"
        />
      </div>

      <div>
        <button
          type="submit"
          class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
        >
          Email Password Reset Link
        </button>
      </div>

      <div class="text-center">
        <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
          Back to login
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
