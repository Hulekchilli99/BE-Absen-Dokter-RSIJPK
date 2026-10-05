@csrf
@if ($method !== 'POST')
    @method($method)
@endif

<div>
    <label for="name" class="mb-2 block text-sm font-semibold text-slate-800">Nama dokter <span class="text-rose-500">*</span></label>
    <input id="name" type="text" name="name" value="{{ old('name', $doctor?->name) }}" required autofocus placeholder="Contoh: dr. Ahmad Fauzi, Sp.PD" class="block w-full rounded-xl border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10">
    @error('name')
        <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-teal-300">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $doctor?->is_active ?? true)) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-teal-700 focus:ring-teal-500">
    <span>
        <span class="block text-sm font-semibold text-slate-800">Aktifkan dokter</span>
        <span class="mt-1 block text-xs leading-5 text-slate-500">Dokter aktif akan tersedia pada pilihan form absensi.</span>
    </span>
</label>

<div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
    <a href="{{ route('backend.doctors.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">Batal</a>
    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700">
        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m5 12 4 4L19 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        {{ $submitLabel }}
    </button>
</div>
