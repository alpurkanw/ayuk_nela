<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Manajemen Sopir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">Manajemen Sopir</h3>
                <p class="card-text">Kelola daftar sopir, nomor plat kendaraan, dan informasi lainnya.</p>
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#sopirModal" data-mode="add">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Sopir Baru
                </button>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Daftar Sopir</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th>No. Plat Kendaraan</th>
                                <th>Keterangan Lain</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($sopir_list as $sopir): ?>
                                <tr data-id="<?= $sopir['id_sopir']; ?>"
                                    data-nama="<?= $sopir['nama_lengkap']; ?>"
                                    data-telp="<?= $sopir['no_telp']; ?>"
                                    data-alamat="<?= $sopir['alamat']; ?>"
                                    data-noplat="<?= $sopir['no_plat']; ?>"
                                    data-keterangan="<?= $sopir['keterangan_lain']; ?>">
                                    <td><?= $no++; ?></td>
                                    <td><?= $sopir['nama_lengkap']; ?></td>
                                    <td><?= $sopir['no_telp']; ?></td>
                                    <td><?= $sopir['alamat']; ?></td>
                                    <td><?= $sopir['no_plat']; ?></td>
                                    <td><?= $sopir['keterangan_lain']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning me-1 edit-sopir-btn" data-mode="edit" data-bs-toggle="modal" data-bs-target="#sopirModal" data-id="<?= $sopir['id_sopir']; ?>">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-sopir-btn" data-id="<?= $sopir['id_sopir']; ?>">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="sopirModal" tabindex="-1" aria-labelledby="sopirModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="sopirModalLabel">Tambah Sopir Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sopirForm" action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="sopirId" name="id_sopir">
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" placeholder="Masukkan nama lengkap sopir" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="nomorTelepon" name="nomorTelepon" placeholder="Contoh: 081234567890" pattern="[0-9]{10,15}" title="Masukkan nomor telepon yang valid (10-15 digit angka)" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap sopir" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="nomorPlat" class="form-label">Nomor Plat Kendaraan</label>
                            <input type="text" class="form-control" id="nomorPlat" name="nomorPlat" placeholder="Contoh: B 1234 ABC" required>
                        </div>
                        <div class="mb-3">
                            <label for="keteranganLain" class="form-label">Keterangan Lain</label>
                            <textarea class="form-control" id="keteranganLain" name="keteranganLain" rows="3" placeholder="Contoh: Sopir utama untuk truk engkel"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitSopirBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk toggle sidebar di HP
        function toggleSidebar() {
            $('#sidebar').toggleClass('collapsed');
            $('.overlay').toggleClass('active');
        }

        $('.sidebar-menu .nav-link').on('click', function() {
            if ($(window).width() < 768) {
                toggleSidebar();
            }
        });

        $(document).ready(function() {
            // --- Logic Modal Tambah/Edit Sopir ---
            $('#sopirModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var mode = button.data('mode');
                var modal = $(this);
                var modalLabel = modal.find('.modal-title');
                var form = modal.find('#sopirForm');

                // Reset form sebelum mengisi
                form[0].reset();
                modal.find('#sopirId').val('');
                // alert(mode)
                if (mode === 'add') {
                    modalLabel.text('Tambah Sopir Baru');
                    form.attr('action', '<?= base_url('owner/Sopir/add'); ?>');
                    modal.find('#submitSopirBtn').text('Simpan');
                    // Pastikan form di dalam modal terlihat
                    modal.find('.modal-body .spinner-border').hide();
                    modal.find('.modal-body > div').show();
                } else if (mode === 'edit') {
                    modalLabel.text('Edit Data Sopir');
                    form.attr('action', '<?= base_url('owner/Sopir/update'); ?>');
                    modal.find('#submitSopirBtn').text('Perbarui');

                    var sopirId = button.data('id');

                    // Tampilkan loading dan sembunyikan form sementara
                    modal.find('.modal-body > div').hide();
                    modal.find('.modal-body').prepend('<div class="text-center py-5 loading-spinner"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

                    // Mengambil data sopir dari server menggunakan AJAX
                    $.ajax({
                        url: '<?= base_url('owner/Sopir/getSopirById/'); ?>' + sopirId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Hapus loading spinner
                            modal.find('.loading-spinner').remove();
                            // Tampilkan kembali form dan isi datanya
                            modal.find('.modal-body > div').show();

                            modal.find('#sopirId').val(data.id_sopir);
                            modal.find('#namaLengkap').val(data.nama_lengkap);
                            modal.find('#nomorTelepon').val(data.no_telp);
                            modal.find('#alamat').val(data.alamat);
                            modal.find('#nomorPlat').val(data.no_plat);
                            modal.find('#keteranganLain').val(data.keterangan_lain);
                        },
                        error: function() {
                            modal.find('.loading-spinner').remove();
                            modal.find('.modal-body').html('<p class="text-danger">Gagal mengambil data sopir. Silakan coba lagi.</p>');
                        }
                    });
                }
            });

            // --- Logic Hapus Sopir ---
            $(document).on('click', '.delete-sopir-btn', function() {
                var sopirId = $(this).data('id');
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Data sopir ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('owner/Sopir/delete/'); ?>' + sopirId;
                    }
                });
            });

            // --- SweetAlert2 untuk Notifikasi (Opsional) ---
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
                    timer: 2000
                });
            <?php endif; ?>
        });
    </script>


</body>

</html>