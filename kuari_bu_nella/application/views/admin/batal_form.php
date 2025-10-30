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

        <?php if ($page == 'get_param') { ?>

            <div class="row">
                <div class="col">
                    <div class="card ">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-2">Pembatalan Penjualan Material</h5>
                        </div>
                        <div class="card-body">

                            <form action="<?= base_url('admin/Penjualan/batal_ambildata'); ?>" method="post" id="formUangKeluar">
                                <div class="mb-3">
                                    <label for="idtrx" class="form-label">Masukan ID Transaksi di sini</label>
                                    <div class="input-group">
                                        <span class="input-group-text">TRX - </span>
                                        <input type="text" class="form-control" id="idtrx" name="idtrx" placeholder="Masukan Id Transaksi, cth : 180" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info w-100">Check Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>






        <?php




        if (isset($data_trx)) {

            // print_r($data_trx);
            // echo !isset($data_trx) ? "tidak ada" : "ada";
            // 
            // echo count($data_trx[0]);
            if (!empty($data_trx)) {
                $data = $data_trx[0];
        ?>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="card ">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title mb-2">Detail Data</h5>
                                <p class="card-text mb-4">Cek Terlebih dahulu data yang akan di-Batalkan, bila perlu konfirmasi data kepihak terkait terlebih dahulu</p>
                            </div>
                            <div class="card-body">

                                <form action="<?= base_url('admin/Penjualan/batal_prosesdata'); ?>" method="post" id="formbataltrx">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="idtrx" class="form-label">ID Transaksi</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">TRX -</span>
                                                    <input type="text" class="form-control" id="idtrx" name="idtrx" value="<?= $data->id_transaksi; ?>" readonly>
                                                </div>

                                            </div>
                                            <div class="mb-3">
                                                <label for="tgl_trx" class="form-label">Tanggal Transaksi</label>
                                                <input type="text" class="form-control" id="tgl_trx" name="tgl_trx" value="<?= $data->tanggal_transaksi; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_material" class="form-label">Material Angkutan</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="nama_material" name="nama_material" value="<?= $data->nama_material; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hargaPerRitase" class="form-label">Harga</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">RP </span>
                                                    <input type="text" class="form-control" id="hargaPerRitase" name="hargaPerRitase" value="<?= number_format($data->total_harga); ?>" readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="namaMaterial" class="form-label">Jenis Transaksi</label>
                                                <input type="text" class="form-control" id="namaMaterial" name="namaMaterial" value="<?= $data->jenis_penjualan; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="namaMaterial" class="form-label">Nama Sopir</label>
                                                <input type="text" class="form-control" id="namaMaterial" name="namaMaterial" value="<?= $data->nama_lengkap; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="namaMaterial" class="form-label">Tujuan Pengangkutan</label>
                                                <input type="text" class="form-control" id="namaMaterial" name="namaMaterial" value="<?= $data->tujuan_pengangkutan; ?>" readonly>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <a href="<?= base_url('admin/Penjualan/batal_form'); ?>" class="btn btn-secondary w-100 shadow">Kembali</a>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-danger w-100 shadow">Batalkan Transaksi ini</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <hr>
                <div class="row">
                    <div class="col">
                        Data Tidak ditemukan, Periksa kembali ID Transaksi <br>
                        <a href="<?= base_url('admin/Penjualan/batal_form'); ?>" class="btn btn-secondary mt-2 shadow">Klik Untuk Kembali</a>
                    </div>
                </div>
        <?php }
        } ?>
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