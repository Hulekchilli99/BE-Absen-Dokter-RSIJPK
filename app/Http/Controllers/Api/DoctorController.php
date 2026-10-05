<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Return doctors for the attendance form or administration screen.
     */
    public function index(Request $request): JsonResponse
    {
        $doctors = Doctor::query()
            ->when(! $request->boolean('include_inactive'), fn ($query) => $query->active())
            ->withCount('attendances')
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $doctors]);
    }

    /**
     * Create a doctor in the master data.
     */
    public function store(StoreDoctorRequest $request): JsonResponse
    {
        $doctor = Doctor::create([
            ...$request->validated(),
            'is_active' => $request->validated('is_active') ?? true,
        ]);

        return response()->json([
            'message' => 'Dokter berhasil ditambahkan.',
            'data' => $doctor,
        ], 201);
    }

    /**
     * Update a doctor in the master data.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor): JsonResponse
    {
        $doctor->update($request->validated());

        return response()->json([
            'message' => 'Data dokter berhasil diperbarui.',
            'data' => $doctor->fresh(),
        ]);
    }

    /**
     * Delete a doctor that has no attendance history.
     */
    public function destroy(Doctor $doctor): JsonResponse
    {
        if ($doctor->attendances()->exists()) {
            return response()->json([
                'message' => 'Dokter yang sudah memiliki riwayat absensi tidak dapat dihapus. Nonaktifkan datanya saja.',
            ], 422);
        }

        $doctor->delete();

        return response()->json(['message' => 'Dokter berhasil dihapus.']);
    }
}
