<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            /* Menggunakan flexbox untuk tata letak utama */
            min-height: 100vh;
            /* Pastikan body mengambil tinggi penuh viewport */
        }

        #sidebar {
            width: 250px;
            /* Lebar sidebar default */
            flex-shrink: 0;
            /* Jangan biarkan sidebar menyusut */
            background-color: #343a40;
            /* Warna gelap untuk sidebar */
            color: white;
            transition: all 0.3s;
            /* Transisi untuk efek buka/tutup */
            overflow-y: auto;
            /* Scroll jika konten sidebar terlalu panjang */
        }

        #sidebar.collapsed {
            margin-left: -250px;
            /* Sembunyikan sidebar ke kiri */
        }

        #content {
            flex-grow: 1;
            /* Konten utama mengambil sisa ruang */
            padding: 20px;
            background-color: #f8f9fa;
            /* Warna background konten */
            overflow-y: auto;
            /* Scroll jika konten utama terlalu panjang */
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #495057;
            text-align: center;
        }

        .sidebar-menu .nav-link {
            color: #adb5bd;
            /* Warna teks menu */
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: #495057;
            /* Warna hover/aktif */
        }

        .sidebar-menu .nav-link i {
            margin-right: 10px;
        }

        .sidebar-submenu .nav-link {
            padding-left: 40px;
            /* Indentasi submenu */
            font-size: 0.9em;
        }

        .navbar-toggler {
            display: none;
            /* Sembunyikan toggler di desktop */
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 767.98px) {
            #sidebar {
                position: fixed;
                /* Sidebar tetap di tempatnya */
                height: 100vh;
                z-index: 1030;
                /* Di atas konten */
                margin-left: -250px;
                /* Awalnya tersembunyi */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }

            #sidebar.collapsed {
                margin-left: 0;
                /* Tampilkan sidebar */
            }

            #content {
                width: 100%;
                /* Konten mengambil lebar penuh */
            }

            .navbar-toggler {
                display: block;
                /* Tampilkan toggler di HP */
            }

            .overlay {
                /* Overlay saat sidebar terbuka di HP */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1029;
                display: none;
            }

            .overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('admin/side_menu'); ?>

    <div id="content">

        <div class="container">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle-fill text-success mb-3" style="font-size: 4rem;"></i>
                    <h4 class="card-title text-success mb-2">Transaksi Berhasil Disimpan!</h4>
                    <p class="card-text text-muted mb-4">Data uang masuk Anda telah berhasil dicatat.</p>

                    <hr class="my-4">

                    <?php if (isset($transaksi_data)) : ?>
                        <div class="text-start mb-4">
                            <h6 class="fw-bold mb-3">Detail Transaksi:</h6>
                            <p class="mb-1"><strong>Tanggal:</strong> <?= htmlspecialchars($transaksi_data['tanggal_transaksi']); ?></p>
                            <p class="mb-1"><strong>Jenis Pemasukan:</strong> <?= htmlspecialchars($transaksi_data['jenis_pemasukan']); ?></p>
                            <p class="mb-1"><strong>Jumlah:</strong> Rp <?= number_format($transaksi_data['jumlah_uang_masuk'], 0, ',', '.'); ?></p>
                            <?php if (!empty($transaksi_data['keterangan'])) : ?>
                                <p class="mb-0"><strong>Keterangan:</strong> <?= nl2br(htmlspecialchars($transaksi_data['keterangan'])); ?></p>
                            <?php endif; ?>
                        </div>
                        <hr class="my-4">
                    <?php endif; ?>

                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/financial/uangMasuk'); ?>" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i> Input Transaksi Lain
                        </a>
                        <a href="<?= base_url('admin/laporan/uangMasuk'); ?>" class="btn btn-outline-info">
                            <i class="bi bi-journal-text me-2"></i> Lihat Laporan Uang Masuk
                        </a>
                        <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-speedometer me-2"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mengisi tanggal transaksi otomatis dengan tanggal hari ini
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            $('#tanggalTransaksi').val(formattedDate);

            // Inisialisasi Select2 untuk jenis pemasukan jika diperlukan
            // (Pastikan Anda sudah memuat library Select2 di layout utama Anda)
            $('#jenisPemasukan').select2({
                placeholder: "Pilih Jenis Pemasukan",
                allowClear: true,
                theme: "bootstrap-5" // Jika Anda menggunakan Bootstrap 5 dan ingin tampilan Select2 yang konsisten
            });

            // Format input jumlah uang masuk menjadi mata uang saat diketik dan saat kehilangan fokus
            $('#jumlahUangMasuk').on('keyup blur', function() {
                let value = $(this).val();
                // Hapus semua karakter non-digit kecuali tanda minus di awal
                value = value.replace(/[^0-9]/g, '');

                // Format sebagai mata uang (misal: 150.000)
                if (value) {
                    $(this).val(parseInt(value, 10).toLocaleString('id-ID'));
                } else {
                    $(this).val('');
                }
            });

            // Sebelum submit, ubah kembali format jumlah uang masuk ke angka murni
            $('#formUangMasuk').on('submit', function() {
                let jumlahUang = $('#jumlahUangMasuk').val();
                // Hapus titik atau koma pemisah ribuan sebelum submit
                jumlahUang = jumlahUang.replace(/\./g, ''); // Untuk format Indonesia (titik sebagai ribuan)
                jumlahUang = jumlahUang.replace(/,/g, ''); // Untuk format lain yang mungkin (koma sebagai ribuan)
                $('#jumlahUangMasuk').val(jumlahUang); // Set nilai tanpa format untuk dikirim ke server
            });
        });
    </script>
</body>

</html>