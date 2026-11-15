document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert-auto-hide');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 500);
        }, 4000);
    });

    const inputTanggal = document.getElementById('tanggal');
    if (inputTanggal) {
        const today = new Date().toISOString().split('T')[0];
        inputTanggal.setAttribute('min', today);
    }

    const deleteButtons = document.querySelectorAll('.btn-hapus');
    deleteButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

    const paketOptions = document.querySelectorAll('.paket-option');
    const inputJumlah = document.getElementById('jumlah_orang');
    const estimasiBox = document.getElementById('estimasi-total');
    const estimasiNilai = document.getElementById('estimasi-nilai');

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function hitungEstimasi() {
        var paketDipilih = document.querySelector('.paket-option input[type="radio"]:checked');
        if (!paketDipilih) return;

        var harga = parseInt(paketDipilih.dataset.harga || 0);
        var jumlah = parseInt(inputJumlah ? inputJumlah.value : 0) || 0;

        if (harga > 0 && jumlah > 0) {
            estimasiNilai.textContent = formatRupiah(harga * jumlah) + ' (' + jumlah + ' orang × ' + formatRupiah(harga) + ')';
            estimasiBox.style.display = 'block';
        } else {
            estimasiBox.style.display = 'none';
        }
    }

    paketOptions.forEach(function (label) {
        label.addEventListener('click', function () {
            paketOptions.forEach(function (l) { l.classList.remove('selected'); });
            this.classList.add('selected');
            setTimeout(hitungEstimasi, 50);
        });
    });

    if (inputJumlah) {
        inputJumlah.addEventListener('input', hitungEstimasi);
    }
});
