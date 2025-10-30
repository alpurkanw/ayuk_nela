<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Tambah Sopir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-light fs-6">

    <?php
    $param['judul'] = "Pendaftaran Sopir";
    $this->load->view('satgas/menu_atas', $param); ?>

    <div class="container py-2">
        <!-- Card untuk Formulir Tambah Sopir -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="sopirForm" action="<?= base_url("satgas/Sopir/add"); ?>" method="post">
                    <input type="hidden" id="sopirId" name="id_sopir">
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control <?= form_error('namaLengkap') ? 'is-invalid' : ''; ?>" id="namaLengkap" name="namaLengkap" placeholder="Masukkan nama lengkap sopir" required value="<?= set_value('namaLengkap'); ?>">
                        <?= form_error('namaLengkap', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control <?= form_error('nomorTelepon') ? 'is-invalid' : ''; ?>" id="nomorTelepon" name="nomorTelepon" placeholder="Contoh: 081234567890" pattern="[0-9]{10,15}" title="Masukkan nomor telepon yang valid (10-15 digit angka)" required value="<?= set_value('nomorTelepon'); ?>">
                        <?= form_error('nomorTelepon', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap sopir" required><?= set_value('alamat'); ?></textarea>
                        <?= form_error('alamat', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="nomorPlat" class="form-label">Nomor Plat Kendaraan</label>
                        <input type="text" class="form-control <?= form_error('nomorPlat') ? 'is-invalid' : ''; ?>" id="nomorPlat" name="nomorPlat" placeholder="Contoh: B 1234 ABC" required value="<?= set_value('nomorPlat'); ?>">
                        <?= form_error('nomorPlat', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="keteranganLain" class="form-label">Keterangan Lain</label>
                        <textarea class="form-control <?= form_error('keteranganLain') ? 'is-invalid' : ''; ?>" id="keteranganLain" name="keteranganLain" rows="3" placeholder="Contoh: Sopir utama untuk truk engkel"><?= set_value('keteranganLain'); ?></textarea>
                        <?= form_error('keteranganLain', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Sopir</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Skrip terkait select2 dihapus karena tidak ada elemen select yang digunakan pada form ini.

            // SweetAlert2 untuk menampilkan pesan dari flashdata
            var sukses = "<?php echo $this->session->flashdata('pesan_sukses'); ?>";
            var error = "<?php echo $this->session->flashdata('pesan_error'); ?>";

            if (sukses) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: sukses,
                    icon: 'success'
                });
            }

            // Pesan error di sini dihapus karena validasi akan ditampilkan secara inline
            // if (error) {
            //     Swal.fire({
            //         title: 'Gagal!',
            //         text: error,
            //         icon: 'error'
            //     });
            // }
        });
    </script>
</body>

</html>