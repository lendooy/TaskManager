<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - TaskManager</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white font-sans text-slate-900 antialiased min-h-screen flex items-center justify-center p-4">

    <!-- Carte principale minimaliste style Canvas/Figma -->
    <div class="w-full max-w-sm flex flex-col items-center">
        
        <!-- En-tête : Avatar & Titre -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-black text-white flex items-center justify-center shadow-lg shadow-white-500/30 mb-3 border border-blue-400/20">
                <i data-lucide="user" class="w-8 h-8"></i>
            </div>
            <p class="text-xs text-slate-500 mt-1">Connectez-vous à votre espace</p>
        </div>

        <!-- Section Erreurs Blade -->
        @if ($errors->any())
            <div class="w-full bg-purple-950 text-purple-100 border border-purple-800 p-3.5 rounded-xl mb-5 text-xs shadow-sm">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire de Connexion -->
        <form method="POST" action="{{ route('login') }}" class="w-full space-y-4">
            @csrf

            <!-- Champ Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Adresse Email</label>
                <div class="relative flex items-center">
                    <i data-lucide="mail" class="w-4 h-4 absolute left-3.5 text-blue-500"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="nom@sdsi.com"
                           class="w-full pl-10 pr-4 py-2.5 bg-blue-50/50 text-slate-900 placeholder-slate-400 border border-blue-200 rounded-xl focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition-all text-sm font-medium">
                </div>
            </div>

            <!-- Champ Mot de passe -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Mot de passe</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-purple-900 transition font-medium">Oublié ?</a>
                    @endif
                </div>
                <div class="relative flex items-center">
                    <i data-lucide="lock" class="w-4 h-4 absolute left-3.5 text-blue-500"></i>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-2.5 bg-blue-50/50 text-slate-900 placeholder-slate-400 border border-blue-200 rounded-xl focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 transition-all text-sm font-medium">
                </div>
            </div>

            <!-- Case à cocher -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-blue-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <span class="ml-2 text-xs text-slate-600 group-hover:text-slate-900 transition font-medium">Se souvenir de moi</span>
                </label>
            </div>

            <!-- Bouton d'action principal avec dégradé Violet Foncé -->
            <button type="submit" 
                    class="w-full mt-2 py-3 px-4 rounded-xl bg-purple-950 hover:bg-purple-900 text-white font-semibold text-sm shadow-md shadow-purple-950/20 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group">
                <span>Se connecter</span>
                <i data-lucide="arrow-right" class="w-4 h-4 text-blue-300 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>

        <!-- Bas de carte / Inscription -->
        <p class="mt-6 text-xs text-slate-500 font-medium">
            Pas encore de compte ? appelez admin +25377595538
         </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>