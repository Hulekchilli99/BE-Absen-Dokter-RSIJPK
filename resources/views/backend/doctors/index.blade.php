@extends('backend.layout')

@section('title', 'Master Dokter')

@section('content')
    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-sm font-medium text-teal-700">Data referensi</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Master Dokter</h1>
            <p class="mt-2 text-sm text-slate-500">Kelola daftar dokter yang tersedia pada form absensi.</p>
        </div>
        <a href="{{ route('backend.doctors.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
            Tambah dokter
        </a>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h2 class="font-bold text-slate-950">Daftar dokter</h2>
                <p class="mt-1 text-xs text-slate-500">Dokter nonaktif tidak akan muncul pada form absensi.</p>
            </div>
            <form action="{{ route('backend.doctors.index') }}" method="GET" class="flex w-full max-w-sm gap-2">
                <label class="relative min-w-0 flex-1">
                    <span class="sr-only">Cari dokter</span>
                    <svg viewBox="0 0 24 24" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5" stroke-linecap="round"/></svg>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama dokter..." class="w-full rounded-xl border-slate-200 py-2.5 pl-9 pr-3 text-sm outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10">
                </label>
                <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-700 transition hover:border-teal-300 hover:text-teal-700">Cari</button>
            </form>
        </div>

        @if ($doctors->isEmpty())
            <div class="px-6 py-16 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3"/><path d="M5 20a7 7 0 0 1 14 0" stroke-linecap="round"/></svg>
                </span>
                <p class="mt-4 font-semibold text-slate-700">Belum ada data dokter</p>
                <p class="mt-1 text-sm text-slate-500">Tambahkan dokter pertama untuk mengaktifkan form absensi.</p>
                <a href="{{ route('backend.doctors.create') }}" class="mt-5 inline-flex rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-teal-800">Tambah dokter</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Nama dokter</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Total absensi</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($doctors as $doctor)
                            <tr class="transition hover:bg-slate-50/70">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-50 text-xs font-bold text-teal-700">{{ str($doctor->name)->substr(0, 1)->upper() }}</span>
                                        <span class="font-semibold text-slate-800">{{ $doctor->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($doctor->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Aktif</span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-500"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $doctor->attendances_count }} kali</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('backend.doctors.edit', $doctor) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-teal-300 hover:text-teal-700">Edit</a>
                                        @if ($doctor->attendances_count === 0)
                                            <form action="{{ route('backend.doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('Hapus dokter ini dari master?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-rose-100 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($doctors->hasPages())
                <div class="border-t border-slate-100 px-5 py-4 sm:px-6">{{ $doctors->links() }}</div>
            @endif
        @endif
    </div>
@endsection
