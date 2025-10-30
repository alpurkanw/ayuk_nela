<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Penjualan - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
</head>

<body class="bg-light fs-6">

    <?php
    $param['judul'] = "Input Penjualan";
    $this->load->view('satgas/menu_atas', $param); ?>

    <div class="container py-2">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?= base_url('satgas/Penjualan/proses_transaksi'); ?>" method="post">
                    <div class="mb-3">
                        <label for="tanggalTransaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tanggalTransaksi" name="tanggalTransaksi" required>
                    </div>
                    <div class="mb-3">
                        <!-- ID SOPIR -->
                        <label for="id_sopir" class="form-label">Nama Sopir</label>
                        <select class="form-select" id="id_sopir" name="id_sopir" required>
                            <option value="">Pilih Sopir</option>
                            <?php if (!empty($sopirs)) : ?>
                                <?php foreach ($sopirs as $spr) : ?>
                                    <option value="<?= $spr["id_sopir"]; ?>"><?= $spr["nama_lengkap"]; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <!-- ID MATERIAL -->
                        <label for="id_material" class="form-label">Jenis Material</label>
                        <select class="form-select" id="id_material" name="id_material" required>
                            <option value="">Pilih Jenis Material</option>
                            <?php if (!empty($materials)) : ?>
                                <?php foreach ($materials as $mtr) : ?>
                                    <option value="<?= $mtr["id_material"]; ?>" data-harga="<?= $mtr["harga_per_ritase"]; ?>"><?= $mtr["nama_material"]; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hargaPenjualan" class="form-label">Harga Penjualan</label>
                        <input type="text" class="form-control" id="hargaPenjualan" name="hargaPenjualan" placeholder="Harga akan terisi otomatis" readonly required>
                        <input type="hidden" id="hargaPenjualanRaw" name="hargaPenjualanRaw">
                    </div>
                    <div class="mb-3">
                        <label for="jumlahRitase" class="form-label">Jumlah Ritase</label>
                        <input type="number" class="form-control" id="jumlahRitase" name="jumlahRitase" min="1" value="1" placeholder="Masukkan jumlah ritase" required>
                    </div>
                    <div class="mb-3">
                        <label for="totalHarga" class="form-label">Total Jumlah Harga</label>
                        <input type="text" class="form-control" id="totalHarga" name="totalHarga" placeholder="Total harga akan terisi otomatis" readonly required>
                        <input type="hidden" id="totalHargaRaw" name="totalHargaRaw">
                    </div>
                    <div class="mb-3">
                        <label for="jenisPenjualan" class="form-label">Jenis Penjualan</label>
                        <select class="form-select" id="jenisPenjualan" name="jenisPenjualan" required>
                            <option value="">Pilih Jenis Penjualan</option>
                            <option value="Cash">Cash</option>
                            <option value="Piutang">Piutang</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="tujuanPengangkutan" class="form-label">Tujuan Pengangkutan</label>
                        <textarea class="form-control" id="tujuanPengangkutan" name="tujuanPengangkutan" rows="3" placeholder="Masukkan alamat tujuan pengangkutan" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Penjualan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 - ID sudah disesuaikan
            $('#id_sopir, #id_material').select2({
                placeholder: "Cari atau pilih...",
                allowClear: true,
                theme: "bootstrap-5"
            });

            // Fungsi untuk format angka ke format Rupiah
            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }

            // Fungsi untuk menghitung dan memperbarui total harga
            function hitungTotalHarga() {
                const hargaPerUnit = parseFloat($('#hargaPenjualanRaw').val()) || 0;
                const jumlahRitase = parseFloat($('#jumlahRitase').val()) || 0;
                const total = hargaPerUnit * jumlahRitase;

                $('#totalHarga').val(formatRupiah(total));
                $('#totalHargaRaw').val(total);
            }

            // Mengisi tanggal transaksi otomatis dengan tanggal hari ini
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            $('#tanggalTransaksi').val(formattedDate);

            // Event listener saat jenis material berubah - ID sudah disesuaikan
            $('#id_material').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const harga = selectedOption.data('harga');

                if (harga) {
                    $('#hargaPenjualan').val(formatRupiah(harga));
                    $('#hargaPenjualanRaw').val(harga);
                    $('#hargaPenjualan').prop('readonly', true);
                } else {
                    $('#hargaPenjualan').val('');
                    $('#hargaPenjualanRaw').val('');
                    $('#hargaPenjualan').prop('readonly', false);
                }
                hitungTotalHarga();
            });

            // Event listener saat jumlah ritase berubah
            $('#jumlahRitase').on('input', function() {
                hitungTotalHarga();
            });

            // Event listener saat harga penjualan diubah (jika tidak readonly)
            $('#hargaPenjualan').on('keyup', function() {
                let harga = $(this).val().replace(/\./g, '');
                $('#hargaPenjualanRaw').val(harga);
                hitungTotalHarga();
            }).on('dblclick', function() {
                $(this).prop('readonly', false).focus();
            }).on('blur', function() {
                if ($(this).val() !== '' && $('#id_material').val() !== '') {
                    $(this).prop('readonly', true);
                }
            });

            // Panggil hitung total harga saat halaman dimuat jika ada nilai yang sudah terisi
            if ($('#id_material').val()) {
                hitungTotalHarga();
            }
        });
    </script>
</body>

</html>