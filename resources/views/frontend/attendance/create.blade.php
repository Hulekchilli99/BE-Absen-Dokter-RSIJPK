@extends('frontend.layout')

@section('title', 'Absen Sekarang')

@section('content')
    <div class="grid w-full items-center gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-20">
        <section class="max-w-2xl text-white">
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-teal-300/20 bg-teal-300/10 px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-teal-200">
                <span class="h-2 w-2 rounded-full bg-teal-300 shadow-[0_0_12px] shadow-teal-300"></span>
                Sistem aktif
            </div>
            <h1 class="max-w-xl text-4xl font-bold leading-[1.08] tracking-tight sm:text-5xl lg:text-6xl">
                Absen cepat,<br>
                <span class="text-teal-300">tepat di lokasi.</span>
            </h1>
            <p class="mt-6 max-w-xl text-base leading-8 text-slate-300 sm:text-lg">
                Pilih nama dokter dari master data, izinkan akses lokasi, lalu kirim absensi Anda. Sistem akan memastikan posisi berada di area {{ $hospital['name'] }}.
            </p>

            <div class="mt-9 grid max-w-xl gap-3 sm:grid-cols-2">
                <div class="flex gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-teal-400/15 text-teal-300">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M12 21s7-6.1 7-12A7 7 0 0 0 5 9c0 5.9 7 12 7 12Z" stroke-linejoin="round"/>
                            <circle cx="12" cy="9" r="2.25"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-semibold text-white">Validasi lokasi</span>
                        <span class="mt-1 block text-xs leading-5 text-slate-400">GPS diverifikasi di server.</span>
                    </span>
                </div>
                <div class="flex gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-cyan-400/15 text-cyan-300">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="M7 3v4M17 3v4M4 9h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="m8 15 2.2 2.2L16 11.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-semibold text-white">Satu kali per hari</span>
                        <span class="mt-1 block text-xs leading-5 text-slate-400">Data tersimpan otomatis.</span>
                    </span>
                </div>
            </div>
        </section>

        <section class="w-full max-w-xl justify-self-end">
            <div class="rounded-[2rem] bg-white p-2 shadow-2xl shadow-black/25 sm:p-3">
                <div class="rounded-[1.6rem] border border-slate-100 bg-slate-50/80 p-6 sm:p-8">
                    <div class="flex items-start justify-between gap-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">Form absensi</p>
                            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Catat kehadiran</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-100 text-teal-700">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M12 3v18M3 12h18" stroke-linecap="round"/>
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

                    @if ($doctors->isEmpty())
                        <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                            Master dokter belum memiliki data aktif. Silakan tambahkan dokter melalui <a href="{{ route('backend.doctors.create') }}" class="font-semibold underline">Panel Admin</a>.
                        </div>
                    @else
                        <form id="attendance-form" class="mt-7 space-y-5" action="{{ route('frontend.attendance.store') }}" method="POST" data-hospital-latitude="{{ $hospital['latitude'] }}" data-hospital-longitude="{{ $hospital['longitude'] }}" data-hospital-radius="{{ $hospital['radius_meters'] }}">
                            @csrf
                            <div>
                                <label for="doctor_id" class="mb-2 block text-sm font-semibold text-slate-800">Nama dokter</label>
                                <select id="doctor_id" name="doctor_id" required class="block w-full rounded-xl border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10">
                                    <option value="">Pilih nama dokter</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                <div class="flex items-start gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-700">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path d="M12 21s7-6.1 7-12A7 7 0 0 0 5 9c0 5.9 7 12 7 12Z" stroke-linejoin="round"/>
                                            <circle cx="12" cy="9" r="2.25"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-slate-800">Lokasi absensi</p>
                                        <p class="mt-1 text-xs leading-5 text-slate-500">{{ $hospital['address'] }} · radius {{ number_format((float) $hospital['radius_meters'], 0, ',', '.') }} m</p>
                                        <p id="location-status" class="mt-3 text-xs font-medium text-slate-500">Lokasi akan diminta saat tombol absensi ditekan.</p>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                            <input type="hidden" id="accuracy_meters" name="accuracy_meters" value="{{ old('accuracy_meters') }}">

                            <button id="attendance-submit" type="submit" class="group flex w-full items-center justify-center gap-3 rounded-xl bg-slate-950 px-5 py-4 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/20 disabled:cursor-not-allowed disabled:opacity-60">
                                <span id="attendance-submit-icon" class="flex h-6 w-6 items-center justify-center rounded-lg bg-teal-400 text-slate-950 transition group-hover:bg-teal-300">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span id="attendance-submit-text">Ambil lokasi & simpan absensi</span>
                            </button>
                            <p class="text-center text-[11px] leading-5 text-slate-400">Dengan melanjutkan, browser akan meminta izin akses lokasi perangkat Anda.</p>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
