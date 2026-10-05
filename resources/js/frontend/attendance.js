const attendanceForm = document.querySelector('#attendance-form');

if (attendanceForm) {
    const submitButton = attendanceForm.querySelector('#attendance-submit');
    const submitText = attendanceForm.querySelector('#attendance-submit-text');
    const locationStatus = attendanceForm.querySelector('#location-status');
    const latitudeInput = attendanceForm.querySelector('#latitude');
    const longitudeInput = attendanceForm.querySelector('#longitude');
    const accuracyInput = attendanceForm.querySelector('#accuracy_meters');

    const setStatus = (message, type = 'default') => {
        const colors = {
            default: 'text-slate-500',
            loading: 'text-teal-700',
            success: 'text-emerald-700',
            error: 'text-rose-600',
        };

        locationStatus.className = `mt-3 text-xs font-medium ${colors[type] ?? colors.default}`;
        locationStatus.textContent = message;
    };

    const setLoading = (isLoading) => {
        submitButton.disabled = isLoading;
        submitText.textContent = isLoading ? 'Membaca lokasi perangkat...' : 'Ambil lokasi & simpan absensi';
    };

    attendanceForm.addEventListener('submit', (event) => {
        if (attendanceForm.dataset.locationReady === 'true') {
            return;
        }

        event.preventDefault();

        if (!navigator.geolocation) {
            setStatus('Browser ini tidak mendukung pembacaan lokasi. Silakan gunakan Chrome, Safari, atau Edge terbaru.', 'error');
            return;
        }

        setLoading(true);
        setStatus('Mohon izinkan akses lokasi pada browser Anda.', 'loading');

        navigator.geolocation.getCurrentPosition(
            (position) => {
                latitudeInput.value = position.coords.latitude;
                longitudeInput.value = position.coords.longitude;
                accuracyInput.value = position.coords.accuracy ?? '';
                attendanceForm.dataset.locationReady = 'true';
                setStatus('Lokasi berhasil dibaca. Menyimpan absensi...', 'success');
                submitText.textContent = 'Menyimpan absensi...';
                attendanceForm.submit();
            },
            (error) => {
                const messages = {
                    1: 'Akses lokasi ditolak. Aktifkan izin lokasi untuk melanjutkan absensi.',
                    2: 'Lokasi belum tersedia. Pastikan GPS atau layanan lokasi perangkat aktif.',
                    3: 'Pembacaan lokasi terlalu lama. Coba lagi di area dengan sinyal GPS yang lebih baik.',
                };

                setLoading(false);
                setStatus(messages[error.code] ?? 'Lokasi tidak dapat dibaca. Silakan coba lagi.', 'error');
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0,
            },
        );
    });
}
