<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Uang Massuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
</head>

<body>
    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('owner/side_menu'); ?>

    <div id="content m-2">

        <div class="card m-2 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-2">Laporan TOTAL Transaksi Harian </h5>
                <p class="card-text mb-4">
                    Menampilkan rekapitulasi transaksi uang Massuk berdasarkan periode waktu dan jenis kategori.</p>
            </div>
            <div class="card-body">

                <form action="<?= base_url('owner/Laporan/harian_view'); ?>" method="post" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4 col-lg-3">
                            <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggalMulai" name="start_date" value="<?= isset($start_date) ? $start_date : date('Y-m-d'); ?>">
                            <input type="hidden" name="jenis" value="Pemasukan">
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggalSelesai" name="end_date" value="<?= isset($end_date) ? $end_date : date('Y-m-d'); ?>">
                        </div>

                        <div class="col-md-12 col-lg-3 d-flex justify-content-lg-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="bi bi-funnel me-2"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#kategoriFilter').select2({
                placeholder: "Pilih Kategori",
                allowClear: true,
                theme: "bootstrap-5"
            });

            if ($('#tanggalMulai').val() === '' && $('#tanggalSelesai').val() === '') {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;
                $('#tanggalMulai').val(formattedDate);
                $('#tanggalSelesai').val(formattedDate);
            }
        });
    </script>
</body>

</html>