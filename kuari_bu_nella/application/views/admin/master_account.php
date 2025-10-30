<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Manajemen Akun Keuangan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('admin/side_menu'); ?>

    <div id="content">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">Manajemen Account Keuangan</h3>
                <p class="card-text">Kelola daftar Account untuk transaksi pemasukan dan pengeluaran.</p>
                <button type="button" class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#akunModal" data-mode="add">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Akun Baru
                </button>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Daftar Account</h5>
                <div class="table-responsive">
                    <table class="table  table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>No. Acc</th>
                                <th>Deskripsi Acc</th>
                                <th>Kategori</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if (!empty($account_list)): ?>
                                <?php foreach ($account_list as $account): ?>
                                    <tr data-id="<?= $account['id_account']; ?>" data-noakun="<?= $account['no_account']; ?>"
                                        data-deskripsi="<?= $account['description_account']; ?>"
                                        data-kategori="<?= $account['category']; ?>">
                                        <td><?= $no++; ?></td>
                                        <td><?= $account['no_account']; ?></td>
                                        <td><?= $account['description_account']; ?></td>
                                        <td>
                                            <?php
                                            $badge_class = ($account['category'] == 'Pemasukan') ? 'bg-success' : 'bg-danger';
                                            ?>
                                            <span class="badge <?= $badge_class; ?>"><?= $account['category']; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning me-1 edit-btn" data-bs-toggle="modal" data-bs-target="#akunModal" data-mode="edit" data-id="<?= $account['id_account']; ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $account['id_account']; ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data akun.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="akunModal" tabindex="-1" aria-labelledby="akunModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="akunModalLabel">Tambah Akun Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="akunForm" action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="akunId" name="id_akun">
                        <div class="mb-3">
                            <label for="noAkun" class="form-label">Nomor Akun</label>
                            <input type="text" class="form-control" id="noAkun" name="noAkun" placeholder="Contoh: 1001" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsiAkun" class="form-label">Deskripsi Akun</label>
                            <input type="text" class="form-control" id="deskripsiAkun" name="deskripsiAkun" placeholder="Contoh: Kas di Tangan" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategoriAkun" class="form-label">Kategori</label>
                            <select class="form-select" id="kategoriAkun" name="kategoriAkun" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="submitBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Logika JavaScript tetap sama, hanya memanggil fungsi yang tidak ada lagi dari CSS kustom.
        // Mungkin perlu diperbaiki jika ada ketergantungan JavaScript pada class/ID CSS yang dihapus.
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
            // Logika Modal Tambah/Edit Akun
            $('#akunModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var mode = button.data('mode');

                var modal = $(this);
                var modalLabel = modal.find('.modal-title');
                var form = modal.find('#akunForm');
                var akunIdInput = modal.find('#akunId');
                var noAkunInput = modal.find('#noAkun');
                var deskripsiAkunInput = modal.find('#deskripsiAkun');
                var kategoriAkunSelect = modal.find('#kategoriAkun');
                var submitBtn = modal.find('#submitBtn');

                form[0].reset();
                akunIdInput.val('');

                if (mode === 'add') {
                    modalLabel.text('Tambah Akun Baru');
                    form.attr('action', '<?= base_url('admin/Account/add'); ?>');
                    submitBtn.text('Simpan');
                } else if (mode === 'edit') {
                    modalLabel.text('Edit Akun');
                    form.attr('action', '<?= base_url('admin/Account/update'); ?>');
                    var akunId = button.data('id');
                    var row = $('tr[data-id="' + akunId + '"]');
                    var noAkun = row.data('noakun');
                    var deskripsi = row.data('deskripsi');
                    var kategori = row.data('kategori');

                    akunIdInput.val(akunId);
                    noAkunInput.val(noAkun);
                    deskripsiAkunInput.val(deskripsi);
                    kategoriAkunSelect.val(kategori);
                    submitBtn.text('Perbarui');
                }
            });

            // Logika Hapus Akun
            $('.delete-btn').on('click', function() {
                var akunId = $(this).data('id');
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Data akun ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('admin/Account/delete/'); ?>' + akunId;
                    }
                });
            });

            // Notifikasi SweetAlert2
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