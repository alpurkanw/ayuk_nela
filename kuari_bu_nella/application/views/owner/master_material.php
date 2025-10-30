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

    <?php $this->load->view('owner/side_menu'); ?>

    <div id="content">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">Manajemen Material</h3>
                <p class="card-text">Kelola daftar jenis material yang tersedia dan harga per ritase.</p>
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#materialModal" data-mode="add">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Material Baru
                </button>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Daftar Material</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Material</th>
                                <th>Harga per Ritase</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if (!empty($material_list)): ?>
                                <?php foreach ($material_list as $material): ?>
                                    <tr data-id="<?= $material['id_material']; ?>"
                                        data-nama="<?= $material['nama_material']; ?>"
                                        data-harga="<?= $material['harga_per_ritase']; ?>"
                                        data-status="<?= $material['status']; ?>">
                                        <td><?= $no++; ?></td>
                                        <td><?= $material['nama_material']; ?></td>
                                        <td>Rp <?= number_format($material['harga_per_ritase'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php
                                            $status_class = ($material['status'] == 'Aktif') ? 'bg-success' : 'bg-danger';
                                            ?>
                                            <span class="badge <?= $status_class; ?>"><?= $material['status']; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning me-1 edit-material-btn" data-bs-toggle="modal" data-bs-target="#materialModal" data-id="<?= $material['id_material']; ?>" data-mode="edit">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-material-btn" data-id="<?= $material['id_material']; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data material.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="materialModalLabel">Tambah Material Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="materialForm" action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="materialId" name="id_material">
                        <div class="mb-3">
                            <label for="namaMaterial" class="form-label">Nama Material</label>
                            <input type="text" class="form-control" id="namaMaterial" name="namaMaterial" placeholder="Contoh: Pasir, Batu Koral" required>
                        </div>
                        <div class="mb-3">
                            <label for="hargaPerRitase" class="form-label">Harga per Ritase</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="hargaPerRitase" name="hargaPerRitase" placeholder="Masukkan harga, cth: 150.000" required>
                                <input type="hidden" id="hargaPerRitaseRaw" name="hargaPerRitaseRaw">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="statusMaterial" class="form-label">Status</label>
                            <select class="form-select" id="statusMaterial" name="statusMaterial" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitMaterialBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // JavaScript untuk toggle sidebar di HP
        function toggleSidebar() {
            $('#sidebar').toggleClass('collapsed');
            $('.overlay').toggleClass('active'); // Aktifkan/nonaktifkan overlay
        }

        // Tutup sidebar saat item menu di klik di HP
        $('.sidebar-menu .nav-link').on('click', function() {
            if ($(window).width() < 768) {
                toggleSidebar();
            }
        });

        $(document).ready(function() {
            // --- Fungsi untuk Format Angka ---
            function formatRupiah(angka) {
                if (typeof angka === 'undefined' || angka === null || isNaN(angka)) {
                    return '';
                }
                var reverse = angka.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return ribuan;
            }

            function unformatRupiah(rupiah) {
                return parseInt(rupiah.replace(/[^0-9]/g, ''), 10);
            }

            // --- Handler untuk Input Harga ---
            $('#hargaPerRitase').on('keyup', function() {
                let inputVal = $(this).val();
                let unformattedVal = unformatRupiah(inputVal);
                $(this).val(formatRupiah(unformattedVal));
                $('#hargaPerRitaseRaw').val(unformattedVal); // Simpan nilai asli di hidden field
            });
            // alert();
            // --- Logic Modal Add/Edit Material ---
            $('#materialModal').on('show.bs.modal', function(event) {
                // alert(mode)
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode'); // 'add' atau 'edit'

                var modal = $(this);
                var modalLabel = modal.find('.modal-title');
                var form = modal.find('#materialForm');
                var materialIdInput = modal.find('#materialId');
                var namaMaterialInput = modal.find('#namaMaterial');
                var hargaPerRitaseInput = modal.find('#hargaPerRitase');
                var hargaPerRitaseRawInput = modal.find('#hargaPerRitaseRaw');
                var statusMaterialSelect = modal.find('#statusMaterial');
                var submitBtn = modal.find('#submitMaterialBtn');

                // Reset form sebelum mengisi
                form[0].reset();
                hargaPerRitaseInput.val('');
                hargaPerRitaseRawInput.val('');
                materialIdInput.val('');

                if (mode === 'add') {

                    modalLabel.text('Tambah Material Baru');
                    form.attr('action', '<?= base_url('owner/Material/add'); ?>'); // Sesuaikan URL untuk tambah
                    submitBtn.text('Simpan');
                } else if (mode === 'edit') {
                    modalLabel.text('Edit Material');
                    form.attr('action', '<?= base_url('owner/Material/update'); ?>'); // Sesuaikan URL untuk update

                    var materialId = button.data('id');
                    // Ambil data dari baris tabel terkait
                    var row = $('tr[data-id="' + materialId + '"]');
                    var nama = row.data('nama');
                    var harga = row.data('harga');
                    var status = row.data('status');

                    materialIdInput.val(materialId);
                    namaMaterialInput.val(nama);
                    hargaPerRitaseInput.val(formatRupiah(harga)); // Tampilkan harga terformat
                    hargaPerRitaseRawInput.val(harga); // Simpan harga asli
                    statusMaterialSelect.val(status);
                    submitBtn.text('Perbarui');
                }
            });

            // --- Logic Hapus Material ---
            $('.delete-material-btn').on('click', function() {
                var materialId = $(this).data('id');
                Swal.fire({ // Menggunakan SweetAlert2 untuk konfirmasi
                    title: 'Anda Yakin?',
                    text: "Data material ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect atau AJAX call untuk menghapus data
                        window.location.href = '<?= base_url('owner/Material/delete/'); ?>' + materialId;
                    }
                });
            });

            // --- SweetAlert2 untuk Notifikasi (Opsional, perlu librarynya) ---
            // Pastikan Anda sudah memuat SweetAlert2 JS jika ingin menggunakannya
            // <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">



            <?php if ($this->session->flashdata('pesan_sukses')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?= $this->session->flashdata('pesan_sukses'); ?>',
                    showConfirmButton: false,
                    timer: 2000
                });
            <?php endif; ?>

            <?php if ($this->session->flashdata('pesan_error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '<?= $this->session->flashdata('pesan_error'); ?>',
                    showConfirmButton: false,
                    timer: 20000
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>