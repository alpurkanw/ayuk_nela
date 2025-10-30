<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('admin/side_menu'); ?>

    <div id="content">

        <div class="container">
            <div class="card ">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-2">Input Transaksi Uang Keluar</h5>
                    <p class="card-text mb-4">Form untuk mencatat setiap pengeluaran dana keuangan.</p>
                </div>
                <div class="card-body">

                    <form action="<?= base_url('admin/financial/prosesUangKeluar'); ?>" method="post" id="formUangKeluar">
                        <div class="mb-3">
                            <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggalTransaksi" name="tanggalTransaksi" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisPengeluaran" class="form-label">Jenis Pengeluaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenisPengeluaran" name="jenisPengeluaran" required>
                                <option value="">Pilih Jenis Pengeluaran</option>
                                <?php if (!empty($accounts)) : ?>
                                    <?php foreach ($accounts as $account) : ?>
                                        <option value="<?= $account->no_account; ?>"><?= $account->description_account; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlahUangKeluar" class="form-label">Jumlah Uang Keluar (Rp) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-end" id="jumlahUangKeluar" name="jumlahUangKeluar" placeholder="Masukkan jumlah uang keluar" required inputmode="numeric">
                            <div class="form-text text-muted">Contoh: 150000 (tanpa titik atau koma)</div>
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Pembelian semen 10 zak untuk proyek C"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Simpan Uang Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            $('#tanggalTransaksi').val(formattedDate);

            $('#jumlahUangKeluar').on('keyup blur', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9]/g, '');

                if (value) {
                    $(this).val(parseInt(value, 10).toLocaleString('id-ID'));
                } else {
                    $(this).val('');
                }
            });

            $('#formUangKeluar').on('submit', function() {
                let jumlahUang = $('#jumlahUangKeluar').val();
                jumlahUang = jumlahUang.replace(/\./g, '');
                jumlahUang = jumlahUang.replace(/,/g, '');
                $('#jumlahUangKeluar').val(jumlahUang);
            });

            <?php if ($this->session->flashdata('success_message')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '<?= $this->session->flashdata('success_message') ?>',
                    showConfirmButton: false,
                    timer: 3000
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