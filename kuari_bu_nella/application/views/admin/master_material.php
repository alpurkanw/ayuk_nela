<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('admin/side_menu'); ?>

    <div id="content">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">Manajemen Material</h3>
                <p class="card-text">Kelola daftar jenis material yang tersedia dan harga per ritase.</p>
                <button type="button" class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#materialModal" data-mode="add">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Material Baru
                </button>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Daftar Material</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary">
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
                                    <tr data-id="<?= $material['id_material']; ?>" data-nama="<?= $material['nama_material']; ?>"
                                        data-harga="<?= $material['harga_per_ritase']; ?>" data-status="<?= $material['status']; ?>">
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
                <div class="modal-header bg-info text-white">
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
                        <button type="submit" class="btn btn-info" id="submitMaterialBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

            $('#hargaPerRitase').on('keyup', function() {
                let inputVal = $(this).val();
                let unformattedVal = unformatRupiah(inputVal);
                $(this).val(formatRupiah(unformattedVal));
                $('#hargaPerRitaseRaw').val(unformattedVal);
            });

            $('#materialModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var mode = button.data('mode');

                var modal = $(this);
                var modalLabel = modal.find('.modal-title');
                var form = modal.find('#materialForm');
                var materialIdInput = modal.find('#materialId');
                var namaMaterialInput = modal.find('#namaMaterial');
                var hargaPerRitaseInput = modal.find('#hargaPerRitase');
                var hargaPerRitaseRawInput = modal.find('#hargaPerRitaseRaw');
                var statusMaterialSelect = modal.find('#statusMaterial');
                var submitBtn = modal.find('#submitMaterialBtn');

                form[0].reset();
                hargaPerRitaseInput.val('');
                hargaPerRitaseRawInput.val('');
                materialIdInput.val('');

                if (mode === 'add') {
                    modalLabel.text('Tambah Material Baru');
                    form.attr('action', '<?= base_url('admin/Material/add'); ?>');
                    submitBtn.text('Simpan');
                } else if (mode === 'edit') {
                    modalLabel.text('Edit Material');
                    form.attr('action', '<?= base_url('admin/Material/update'); ?>');

                    var materialId = button.data('id');
                    var row = $('tr[data-id="' + materialId + '"]');
                    var nama = row.data('nama');
                    var harga = row.data('harga');
                    var status = row.data('status');

                    materialIdInput.val(materialId);
                    namaMaterialInput.val(nama);
                    hargaPerRitaseInput.val(formatRupiah(harga));
                    hargaPerRitaseRawInput.val(harga);
                    statusMaterialSelect.val(status);
                    submitBtn.text('Perbarui');
                }
            });

            $('.delete-material-btn').on('click', function() {
                var materialId = $(this).data('id');
                Swal.fire({
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
                        window.location.href = '<?= base_url('admin/Material/delete/'); ?>' + materialId;
                    }
                });
            });

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