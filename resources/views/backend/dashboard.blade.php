@extends('backend.layout')

@section('title', 'Dashboard')

@section('content')
    @php
        $attendancePercentage = $activeDoctorCount > 0 ? min(100, round(($todayAttendanceCount / $activeDoctorCount) * 100)) : 0;
    @endphp

    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-medium text-teal-700">Ringkasan operasional</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Dashboard</h1>
            <p class="mt-2 text-sm text-slate-500">Pantau absensi dokter hari ini dan kelola data master.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('backend.attendances.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-teal-300 hover:text-teal-700">
                Lihat rekap
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <a href="{{ route('backend.doctors.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                Tambah dokter
            </a>
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-50 text-teal-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3"/><path d="M5 20a7 7 0 0 1 14 0" stroke-linecap="round"/></svg>
                </span>
                <span class="rounded-full bg-teal-50 px-2.5 py-1 text-[11px] font-bold text-teal-700">Aktif</span>
            </div>
            <p class="mt-5 text-sm text-slate-500">Dokter aktif</p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-950">{{ $activeDoctorCount }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16M8 14h.01M12 14h.01M16 14h.01" stroke-linecap="round"/></svg>
                </span>
                <span class="rounded-full bg-cyan-50 px-2.5 py-1 text-[11px] font-bold text-cyan-700">Hari ini</span>
            </div>
            <p class="mt-5 text-sm text-slate-500">Sudah absen</p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-950">{{ $todayAttendanceCount }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7v5l3.5 2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-700">{{ $attendancePercentage }}%</span>
            </div>
            <p class="mt-5 text-sm text-slate-500">Progres kehadiran</p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-950">{{ $attendancePercentage }}%</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-50 text-violet-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <span class="rounded-full bg-violet-50 px-2.5 py-1 text-[11px] font-bold text-violet-700">Semua</span>
            </div>
            <p class="mt-5 text-sm text-slate-500">Total riwayat absensi</p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-950">{{ $allAttendanceCount }}</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 sm:px-6">
                <div>
                    <h2 class="font-bold text-slate-950">Absensi hari ini</h2>
                    <p class="mt-1 text-xs text-slate-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <a href="{{ route('backend.attendances.index') }}" class="text-xs font-bold text-teal-700 hover:text-teal-800">Lihat semua</a>
            </div>
            @if ($recentAttendances->isEmpty())
                <div class="px-6 py-14 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16" stroke-linecap="round"/></svg>
                    </span>
                    <p class="mt-4 text-sm font-semibold text-slate-700">Belum ada absensi hari ini</p>
                    <p class="mt-1 text-xs text-slate-500">Data akan muncul setelah dokter melakukan absensi.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[560px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-6 py-3">Dokter</th>
                                <th class="px-6 py-3">Waktu</th>
                                <th class="px-6 py-3">Jarak GPS</th>
                                <th class="px-6 py-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($recentAttendances as $attendance)
                                <tr class="transition hover:bg-slate-50/70">
                                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $attendance->doctor->name }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $attendance->checked_in_at->format('H:i') }} WIB</td>
                                    <td class="px-6 py-4 text-slate-500">{{ number_format((float) $attendance->distance_meters, 0, ',', '.') }} m</td>
                                    <td class="px-6 py-4 text-right"><span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Valid</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="rounded-2xl bg-slate-950 p-6 text-white shadow-sm sm:p-7">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-400 text-slate-950">
                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 3 4 6v5c0 4.8 3.4 8.8 8 10 4.6-1.2 8-5.2 8-10V6l-8-3Z" stroke-linejoin="round"/><path d="m8.5 12 2.2 2.2 4.8-4.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h2 class="mt-6 text-xl font-bold">Validasi lokasi aktif</h2>
            <p class="mt-3 text-sm leading-7 text-slate-300">Setiap absensi menyimpan koordinat perangkat dan jarak dari titik rumah sakit. Pemeriksaan utama dilakukan di sisi server agar hasil rekap tetap dapat dipercaya.</p>
            <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-teal-300">Titik verifikasi</p>
                <p class="mt-2 text-sm font-semibold text-white">{{ config('attendance.hospital_name') }}</p>
                <p class="mt-1 text-xs leading-5 text-slate-400">{{ config('attendance.hospital_address') }}</p>
                <div class="mt-4 flex items-center justify-between border-t border-white/10 pt-4 text-xs"><span class="text-slate-400">Radius yang diizinkan</span><span class="font-bold text-teal-300">{{ number_format((float) config('attendance.radius_meters'), 0, ',', '.') }} meter</span></div>
            </div>
        </section>
    </div>
@endsection
