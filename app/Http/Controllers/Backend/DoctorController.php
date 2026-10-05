<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);
        $search = $request->string('q')->trim()->toString();

        $doctors = Doctor::query()
            ->withCount('attendances')
            ->when($search !== '', fn (Builder $query): Builder => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('backend.doctors.index', compact('doctors', 'search'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create(): View
    {
        return view('backend.doctors.create');
    }

    /**
     * Store a newly created doctor.
     */
    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        $doctorData = $request->validated();
        $doctorData['is_active'] = $doctorData['is_active'] ?? true;
        Doctor::create($doctorData);

        return redirect()
            ->route('backend.doctors.index')
            ->with('success', 'Dokter berhasil ditambahkan ke master.');
    }

    /**
     * Show the form for editing a doctor.
     */
    public function edit(Doctor $doctor): View
    {
        return view('backend.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified doctor.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor): RedirectResponse
    {
        $doctor->update($request->validated());

        return redirect()
            ->route('backend.doctors.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Remove a doctor that has no attendance history.
     */
    public function destroy(Doctor $doctor): RedirectResponse
    {
        if ($doctor->attendances()->exists()) {
            return back()->with('error', 'Dokter yang sudah memiliki riwayat absensi tidak dapat dihapus. Nonaktifkan saja datanya.');
        }

        $doctor->delete();

        return redirect()
            ->route('backend.doctors.index')
            ->with('success', 'Dokter berhasil dihapus dari master.');
    }
}
