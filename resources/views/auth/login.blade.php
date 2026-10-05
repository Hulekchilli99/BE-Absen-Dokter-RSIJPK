@extends('frontend.layout')

@section('title', 'Login Panel Admin')

@section('content')
    <div class="mx-auto w-full max-w-md">
        <div class="rounded-[2rem] bg-white p-2 shadow-2xl shadow-black/25 sm:p-3">
            <div class="rounded-[1.6rem] border border-slate-100 bg-slate-50/80 p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">Autentikasi Admin</p>
                        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Masuk ke Sistem</h1>
                        <p class="mt-1 text-sm text-slate-500">Masukkan No. Pegawai dan Password Anda.</p>
                    </div>
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-teal-700 shadow-xs">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                </div>

                @if (session('success'))
                    <div class="mt-6 flex gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="status">
                        <svg viewBox="0 0 24 24" class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="m5 12 4 4L19 6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                        <div class="flex gap-3">
                            <svg viewBox="0 0 24 24" class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01" stroke-linecap="round"/>
                            </svg>
                            <div class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form class="mt-6 space-y-4" action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div>
                        <label for="no_pegawai" class="mb-2 block text-sm font-semibold text-slate-800">Nomor Pegawai</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <input type="text"
                                   id="no_pegawai"
                                   name="no_pegawai"
                                   value="{{ old('no_pegawai') }}"
                                   required
                                   autofocus
                                   placeholder="Contoh: 123456"
                                   class="block w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 shadow-xs outline-none transition focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 @error('no_pegawai') border-rose-300 ring-2 ring-rose-500/10 @enderror">
                        </div>
                        @error('no_pegawai')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-800">Password</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   required
                                   placeholder="••••••••"
                                   class="block w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 shadow-xs outline-none transition focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 @error('password') border-rose-300 ring-2 ring-rose-500/10 @enderror">
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 text-xs font-medium text-slate-600">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="group mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-slate-950 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/20">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-none stroke-current" stroke-width="2" aria-hidden="true">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Masuk ke Panel Admin</span>
                    </button>

                    <div class="pt-2 text-center">
                        <a href="{{ route('frontend.attendance.create') }}" class="text-xs font-semibold text-slate-500 transition hover:text-teal-700">
                            &larr; Kembali ke Halaman Absensi
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
