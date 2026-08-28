<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskManager')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f8f9fa] font-sans text-slate-900 antialiased selection:bg-indigo-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="w-60 bg-[#1c122c] text-white flex flex-col justify-between p-3 border-r border-violet-950/40 shrink-0">
            <div>
                <!-- Brand / Logo -->
                <div class="flex items-center gap-2.5 px-3 py-3 mb-4">
                    <span class="text-sm font-semibold tracking-tight text-white">TaskManager</span>
                </div>

                <!-- Navigation Links filtrés par Rôle -->
                <nav class="space-y-0.5">
                    {{-- Dashboard : Accessible à Tous --}}
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-md transition text-xs">
                        <i data-lucide="layout-grid" class="w-4 h-4"></i>
                        <span>Dashboard</span>
                    </a>

                    {{-- Projets : Chef de projet uniquement --}}
                    @if(Auth::user()->isChefDeProjet())
                        <a href="{{ route('chef.projects.index') }}"
                            class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('chef.projects.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-md transition text-xs">
                            <i data-lucide="folder-kanban" class="w-4 h-4"></i>
                            <span>Projets</span>
                        </a>
                    @endif

                    {{-- Tâches & Timesheets : Développeur uniquement --}}
                    @if(Auth::user()->isDeveloppeur())
                        <a href="{{ route('dev.tasks.index') }}"
                            class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('dev.tasks.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-md transition text-xs">
                            <i data-lucide="check-square" class="w-4 h-4"></i>
                            <span>Mes Tâches</span>
                        </a>

                        <a href="{{ route('dev.timesheets.index') }}"
                            class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('dev.timesheets.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-md transition text-xs">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>Mes Saisies de temps</span>
                        </a>
                    @endif

                    {{-- Administration : Admin uniquement --}}
                    @if(Auth::user()->isAdmin())
                        <div class="pt-3 mt-3 border-t border-white/10">
                            <p class="px-3 mb-1 text-[10px] font-semibold uppercase tracking-wider text-slate-500">Administration</p>
                            
                            <a href="{{ route('admin.users.index') }}"
                                class="flex items-center gap-2.5 px-3 py-2 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-md transition text-xs">
                                <i data-lucide="users" class="w-4 h-4"></i>
                                <span>Utilisateurs</span>
                            </a>
                        </div>
                    @endif
                </nav>
            </div>

            <!-- Footer Sidebar (Profil utilisateur & Déconnexion) -->
            <div class="pt-3 border-t border-white/10 px-2 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-indigo-600 text-white font-semibold text-xs flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="text-[11px] leading-tight">
                        <p class="font-semibold text-white">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                        <p class="text-slate-400 text-[10px]">{{ Auth::user()->role->name ?? 'Sans rôle' }}</p>
                    </div>
                </div>

                <!-- Formulaire de déconnexion -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Se déconnecter"
                        class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-white/5 rounded transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto">
            <!-- Topbar -->
            <header class="h-14 bg-white border-b border-slate-200/80 px-8 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <h1 class="text-sm font-semibold text-slate-900">@yield('page_title', 'Gestion de Tâches')</h1>
                    @hasSection('page_subtitle')
                        <span class="text-slate-300">/</span>
                        <span class="text-xs text-slate-500 font-medium">@yield('page_subtitle')</span>
                    @endif
                </div>

                <div>
                    @yield('page_actions')
                </div>
            </header>

            <!-- Contenu dynamique -->
            <div class="p-8 max-w-7xl mx-auto space-y-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>