<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Panel Admin') · {{ config('app.name') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/backend.css', 'resources/js/backend.js'])
        @endif
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
        <div class="min-h-screen lg:flex">
            <aside class="hidden w-72 shrink-0 bg-slate-950 text-white lg:flex lg:flex-col">
                <div class="flex h-24 items-center gap-3 border-b border-white/10 px-7">
                    <img src="{{ asset('logo.jpg') }}" alt="Logo RSIJ" class="h-10 w-10 rounded-xl bg-white object-contain p-1 shadow-xs">
                    <span>
                        <span class="block text-xs font-semibold uppercase tracking-[0.16em] text-teal-300">RS Islam Jakarta Pondok Kopi</span>
                        <span class="mt-1 block text-base font-bold">Panel Admin</span>
                    </span>
                </div>
                <nav class="flex-1 space-y-1 px-4 py-7" aria-label="Navigasi utama">
                    <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Menu utama</p>
                    <a href="{{ route('backend.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition {{ request()->routeIs('backend.dashboard') ? 'bg-teal-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('backend.doctors.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition {{ request()->routeIs('backend.doctors.*') ? 'bg-teal-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3"/><path d="M5 20a7 7 0 0 1 14 0M19 8h3M20.5 6.5v3" stroke-linecap="round"/></svg>
                        Master Dokter
                    </a>
                    <a href="{{ route('backend.attendances.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition {{ request()->routeIs('backend.attendances.*') ? 'bg-teal-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01" stroke-linecap="round"/></svg>
                        Rekap Absensi
                    </a>
                </nav>
                <div class="space-y-1 border-t border-white/10 p-4">
                    <a href="{{ route('frontend.attendance.create') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/10 hover:text-white">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 10.5 12 3l9 7.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.5 9.5V21h13V9.5M9 21v-6h6v6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Buka Halaman Absen
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-rose-300 transition hover:bg-rose-500/10 hover:text-rose-200">
                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="flex h-20 items-center justify-between border-b border-slate-200 bg-white px-5 sm:px-8">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('logo.jpg') }}" alt="Logo RSIJ" class="h-10 w-10 rounded-xl bg-white object-contain p-1 shadow-xs lg:hidden">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-teal-700">Administrasi</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">Sistem Absensi Dokter</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden text-right sm:block">
                            <span class="block text-xs font-medium text-slate-400">Pegawai: {{ auth()->user()->no_pegawai ?? '-' }}</span>
                            <span class="block text-sm font-semibold text-slate-700">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        </span>
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-950 text-sm font-bold text-teal-300">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline">
                            @csrf
                            <button type="submit" title="Keluar dari sistem" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-rose-300 hover:bg-rose-50 hover:text-rose-600" aria-label="Keluar">
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </header>

                <div class="border-b border-slate-200 bg-white px-5 py-3 lg:hidden">
                    <nav class="flex items-center gap-2 overflow-x-auto" aria-label="Navigasi mobile">
                        <a href="{{ route('backend.dashboard') }}" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold {{ request()->routeIs('backend.dashboard') ? 'bg-teal-50 text-teal-700' : 'text-slate-500' }}">Dashboard</a>
                        <a href="{{ route('backend.doctors.index') }}" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold {{ request()->routeIs('backend.doctors.*') ? 'bg-teal-50 text-teal-700' : 'text-slate-500' }}">Master Dokter</a>
                        <a href="{{ route('backend.attendances.index') }}" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold {{ request()->routeIs('backend.attendances.*') ? 'bg-teal-50 text-teal-700' : 'text-slate-500' }}">Rekap Absensi</a>
                        <a href="{{ route('frontend.attendance.create') }}" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-slate-500">Halaman Absen</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline shrink-0">
                            @csrf
                            <button type="submit" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">Keluar</button>
                        </form>
                    </nav>
                </div>

                <main class="mx-auto w-full max-w-7xl px-5 py-8 sm:px-8 lg:px-10">
                    @if (session('success'))
                        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm font-medium text-emerald-800" role="status">
                            <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 12 4 4L19 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm font-medium text-rose-800" role="alert">
                            <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01" stroke-linecap="round"/></svg>
                            {{ session('error') }}
                        </div>
                    @endif
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
