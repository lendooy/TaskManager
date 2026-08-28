{{-- @extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="flex flex-col items-center space-y-6">
    
    <!-- En-tête avec Avatar et Titre -->
    <div class="flex flex-col items-center text-center space-y-2">
        <div class="w-20 h-20 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 shadow-sm">
            <i data-lucide="user" class="w-10 h-10 stroke-[1.5]"></i>
        </div>
        <h1 class="text-xl font-bold tracking-tight text-slate-900">Connexion</h1>
        <p class="text-xs text-slate-500">Entrez vos identifiants pour continuer</p>
    </div>

    <form action="{{ route('login.post') }}" method="POST" class="w-full space-y-4">
        @csrf

        <!-- Champ Email -->
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                Adresse email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nom@exemple.com"
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-md text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-slate-800 focus:outline-none transition">
            </div>
            @error('email')
                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Champ Mot de passe -->
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                Mot de passe
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-md text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-slate-800 focus:outline-none transition">
            </div>
            @error('password')
                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Option Se souvenir de moi -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                <span class="text-xs font-medium text-slate-600">Se souvenir de moi</span>
            </label>
        </div>

        <!-- Bouton de connexion -->
        <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white text-sm font-medium py-2.5 rounded-md transition flex items-center justify-center gap-2 shadow-sm">
            <span>Se connecter</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
    </form>

    <!-- Footer bas de page -->
    <p class="text-[11px] text-slate-400 font-medium pt-2">
        &copy; {{ date('Y') }} ProjEct IT
    </p>
</div>
@endsection --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - TaskManager</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Connexion TaskManager</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Adresse Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Se connecter
            </button>
        </form>
    </div>
</body>
</html>