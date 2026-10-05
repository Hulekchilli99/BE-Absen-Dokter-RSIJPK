@extends('backend.layout')

@section('title', 'Rekap Absensi')

@section('content')
    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-medium text-teal-700">Laporan kehadiran</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Rekap Absensi</h1>
            <p class="mt-2 text-sm text-slate-500">Filter data absensi dan unduh laporan dalam format Excel.</p>
        </div>
        <a href="{{ route('backend.attendances.export', $filters) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 3v12M7 10l5 5 5-5M4 21h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Download Excel
        </a>
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <form action="{{ route('backend.attendances.index') }}" method="GET" class="grid gap-4 md:grid-cols-[1fr_1fr_1.4fr_auto] md:items-end">
            <div>
                <label for="date_from" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Dari tanggal</label>
                <input id="date_from" type="date" name="date_from" value="{{ $filters['date_from'] }}" class="block w-full rounded-xl border-slate-200 px-3.5 py-3 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10">
            </div>
            <div>
                <label for="date_to" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Sampai tanggal</label>
                <input id="date_to" type="date" name="date_to" value="{{ $filters['date_to'] }}" class="block w-full rounded-xl border-slate-200 px-3.5 py-3 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10">
            </div>
            <div>
                <label for="doctor_id" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Dokter</label>
                <select id="doctor_id" name="doctor_id" class="block w-full rounded-xl border-slate-200 bg-white px-3.5 py-3 text-sm text-slate-700 outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10">
                    <option value="">Semua dokter</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" @selected($filters['doctor_id'] === $doctor->id)>{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-teal-700">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5" stroke-linecap="round"/></svg>
                Terapkan
            </button>
        </form>
        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $errors->first() }}</div>
        @endif
    </div>

    <div class="mt-5 flex items-center justify-between rounded-2xl border border-teal-100 bg-teal-50 px-5 py-4 sm:px-6">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-teal-700 shadow-sm">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 19V5M4 19h16M8 16v-4M12 16V8M16 16v-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div><p class="text-xs font-semibold uppercase tracking-wide text-teal-700">Hasil filter</p><p class="mt-0.5 text-sm text-teal-950">{{ $filters['date_from'] }} sampai {{ $filters['date_to'] }}</p></div>
        </div>
        <p class="text-right text-2xl font-bold text-teal-900">{{ $totalAttendance }} <span class="text-xs font-semibold text-teal-700">data</span></p>
    </div>

    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        @if ($attendances->isEmpty())
            <div class="px-6 py-16 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"><svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16" stroke-linecap="round"/></svg></span>
                <p class="mt-4 font-semibold text-slate-700">Belum ada data pada periode ini</p>
                <p class="mt-1 text-sm text-slate-500">Coba ubah rentang tanggal atau filter dokter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[950px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Tanggal & waktu</th>
                            <th class="px-6 py-4">Dokter</th>
                            <th class="px-6 py-4">Jarak lokasi</th>
                            <th class="px-6 py-4">Akurasi GPS</th>
                            <th class="px-6 py-4">Koordinat</th>
                            <th class="px-6 py-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($attendances as $attendance)
                            <tr class="transition hover:bg-slate-50/70">
                                <td class="px-6 py-4"><span class="block font-semibold text-slate-800">{{ $attendance->attendance_date->translatedFormat('d M Y') }}</span><span class="mt-1 block text-xs text-slate-500">{{ $attendance->checked_in_at->format('H:i:s') }} WIB</span></td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $attendance->doctor->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ number_format((float) $attendance->distance_meters, 0, ',', '.') }} m</td>
                                <td class="px-6 py-4 text-slate-600">{{ $attendance->accuracy_meters !== null ? number_format((float) $attendance->accuracy_meters, 0, ',', '.') . ' m' : '-' }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $attendance->latitude }},<br>{{ $attendance->longitude }}</td>
                                <td class="px-6 py-4 text-right"><span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Valid</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($attendances->hasPages())
                <div class="border-t border-slate-100 px-5 py-4 sm:px-6">{{ $attendances->links() }}</div>
            @endif
        @endif
    </div>
@endsection
