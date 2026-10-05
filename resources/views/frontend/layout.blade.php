<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Absensi Dokter') · {{ config('app.name') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
        @endif
    </head>
    <body class="min-h-screen bg-slate-950 font-sans text-slate-900 antialiased">
        <div class="relative isolate min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_#115e59_0,_#0f172a_44%,_#020617_100%)]">
            <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-teal-400/15 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-48 -left-32 h-96 w-96 rounded-full bg-cyan-400/10 blur-3xl"></div>

            <header class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between px-5 py-6 sm:px-8 lg:px-10">
                <a href="{{ route('frontend.attendance.create') }}" class="flex items-center gap-3 text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-400 text-slate-950 shadow-lg shadow-teal-950/30">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                            <path d="M19 5.5A9.5 9.5 0 1 1 5.5 19" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-semibold tracking-wide text-teal-200">RSIJ Pondok Kopi</span>
                        <span class="block text-lg font-bold tracking-tight">Absensi Dokter</span>
                    </span>
                </a>
                <a href="{{ auth()->check() ? route('backend.dashboard') : route('login') }}" class="relative flex h-11 w-11 items-center justify-center rounded-2xl border border-white/15 bg-white/5 text-slate-200 shadow-md backdrop-blur-xs transition hover:border-teal-300/50 hover:bg-white/15 hover:text-white" title="{{ auth()->check() ? 'Panel Admin (' . auth()->user()->name . ')' : 'Login Panel Admin' }}" aria-label="{{ auth()->check() ? 'Panel Admin' : 'Login Panel Admin' }}">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    @auth
                        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-teal-400 ring-2 ring-slate-950"></span>
                    @endauth
                </a>
            </header>

            <main class="relative z-10 mx-auto flex w-full max-w-7xl items-center px-5 pb-12 pt-4 sm:px-8 lg:min-h-[calc(100vh-100px)] lg:px-10 lg:pb-20 lg:pt-0">
                @yield('content')
            </main>

            <footer class="relative z-10 mx-auto w-full max-w-7xl px-5 pb-7 text-xs text-slate-400 sm:px-8 lg:px-10">
                <div class="flex flex-col gap-1 border-t border-white/10 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <span>{{ config('attendance.hospital_name') }}</span>
                    <span>Absensi berbasis lokasi · Radius {{ number_format((float) config('attendance.radius_meters'), 0, ',', '.') }} meter</span>
                </div>
            </footer>
        </div>
    </body>
</html>
