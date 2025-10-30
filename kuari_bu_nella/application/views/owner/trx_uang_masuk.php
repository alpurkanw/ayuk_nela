<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Link SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: #343a40;
            color: white;
            transition: all 0.3s;
            overflow-y: auto;
        }

        #sidebar.collapsed {
            margin-left: -250px;
        }

        #content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #495057;
            text-align: center;
        }

        .sidebar-menu .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: #495057;
        }

        .sidebar-menu .nav-link i {
            margin-right: 10px;
        }

        .sidebar-submenu .nav-link {
            padding-left: 40px;
            font-size: 0.9em;
        }

        .navbar-toggler {
            display: none;
        }

        @media (max-width: 767.98px) {
            #sidebar {
                position: fixed;
                height: 100vh;
                z-index: 1030;
                margin-left: -250px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }

            #sidebar.collapsed {
                margin-left: 0;
            }

            #content {
                width: 100%;
            }

            .navbar-toggler {
                display: block;
            }

            .overlay {
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

    <?php $this->load->view('owner/side_menu'); ?>

    <div id="content">

        <div class="container">
            <div class="card ">

                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-2">Input Transaksi Uang Masuk</h5>
                    <p class="card-text mb-4">Form untuk mencatat setiap Pemasukan dana keuangan.</p>
                </div>
                <div class="card-body">


                    <form action="<?= base_url('owner/financial/prosesUangMasuk'); ?>" method="post" id="formUangMasuk">
                        <div class="mb-3">
                            <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggalTransaksi" name="tanggalTransaksi" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenisPemasukan" class="form-label">Jenis Pengeluaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenisPemasukan" name="jenisPemasukan" required>
                                <option value="">Pilih Jenis Pengeluaran</option>
                                <!-- Looping untuk menampilkan data dari database -->
                                <?php if (!empty($accounts)) : ?>
                                    <?php foreach ($accounts as $account) : ?>
                                        <option value="<?= $account->no_account; ?>"><?= $account->description_account; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlahUangMasuk" class="form-label">Jumlah Uang Masuk (Rp) <span class="text-danger">*</span></label>
                            <!-- Atribut 'pattern' dihapus untuk menghindari konflik dengan skrip JS -->
                            <input type="text" class="form-control text-end" id="jumlahUangMasuk" name="jumlahUangMasuk" placeholder="Masukkan jumlah uang masuk" required inputmode="numeric">
                            <div class="form-text text-muted">Contoh: 150000 (tanpa titik atau koma)</div>
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Pembayaran dari Tn. Andi untuk pasir 5 kubik"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Simpan Uang Masuk</button>
                    </form>
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
            // $('#jenisPemasukan').select2({
            //     placeholder: "Pilih Jenis Pemasukan",
            //     allowClear: true,
            //     theme: "bootstrap-5" // Jika Anda menggunakan Bootstrap 5 dan ingin tampilan Select2 yang konsisten
            // });

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

            // Logika SweetAlert berdasarkan flashdata dari Controller
            <?php if ($this->session->flashdata('success_message')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '<?= $this->session->flashdata('success_message') ?>',
                    showConfirmButton: false,
                    timer: 1000
                });
            <?php endif; ?>

            <?php if ($this->session->flashdata('error_message')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '<?= $this->session->flashdata('error_message') ?>',
                    showConfirmButton: true
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>