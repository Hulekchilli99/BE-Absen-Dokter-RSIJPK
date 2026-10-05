<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => [
                'required',
                'integer',
                Rule::exists('doctors', 'id')->where(fn ($query) => $query->where('is_active', true)),
            ],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'accuracy_meters' => ['nullable', 'numeric', 'min:0', 'max:100000'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Silakan pilih nama dokter.',
            'doctor_id.exists' => 'Dokter tidak ditemukan atau sedang tidak aktif.',
            'latitude.required' => 'Lokasi belum berhasil dibaca.',
            'longitude.required' => 'Lokasi belum berhasil dibaca.',
            'latitude.between' => 'Koordinat lokasi tidak valid.',
            'longitude.between' => 'Koordinat lokasi tidak valid.',
        ];
    }
}
