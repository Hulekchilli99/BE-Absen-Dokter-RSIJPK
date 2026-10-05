@extends('backend.layout')

@section('title', 'Edit Dokter')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-8">
            <a href="{{ route('backend.doctors.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-teal-700">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kembali ke master dokter
            </a>
            <p class="mt-6 text-sm font-medium text-teal-700">Master dokter</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Edit dokter</h1>
            <p class="mt-2 text-sm text-slate-500">Perbarui nama atau status dokter pada master data.</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <form action="{{ route('backend.doctors.update', $doctor) }}" method="POST" class="space-y-6">
                @include('backend.doctors._form', ['doctor' => $doctor, 'method' => 'PUT', 'submitLabel' => 'Simpan perubahan'])
            </form>
        </div>
    </div>
@endsection
