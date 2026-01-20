<x-mail::message>
# Bienvenue! 👋

Nous sommes heureux de vous informer que votre compte a été **approuvé**!

Vous pouvez maintenant accéder à l'application **{{ config('app.name') }}**.

<x-mail::button :url="route('user.vehicles.index')">
Accéder à l'Application
</x-mail::button>

---

**Informations de connexion:**
- **Email:** {{ $user->email }}
- **URL:** {{ config('app.url') }}

Si vous n'êtes pas {{ $user->name }}, veuillez ignorer cet email.

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
