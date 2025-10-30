<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Uang Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-dark bg-dark d-block d-md-none sticky-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas"
                aria-controls="sidebarOffcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="navbar-brand mb-0 h1 ms-3">Laporan Keuangan</span>
        </div>
    </nav>

    <div class="d-flex flex-fill">
        <div class="offcanvas-md offcanvas-start bg-dark text-white d-flex flex-column flex-shrink-0 p-3"
            tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel" style="width: 250px;">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title text-white" id="sidebarOffcanvasLabel">Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column p-0">
                <?php $this->load->view('admin/side_menu'); ?>
            </div>
        </div>

        <div id="content" class="flex-grow-1 p-3 bg-light">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-2">Laporan Uang Keluar (Pengeluaran)</h5>
                    <p class="card-text mb-4">Menampilkan rekapitulasi transaksi uang Keluar berdasarkan periode waktu dan jenis kategori.</p>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/Laporan/lap_uang_keluar_view'); ?>" method="post" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4 col-lg-3">
                                <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggalMulai" name="start_date"
                                    value="<?= isset($start_date) ? $start_date : date('Y-m-d'); ?>">
                                <input type="hidden" name="jenis" value="Pengeluaran">
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggalSelesai" name="end_date"
                                    value="<?= isset($end_date) ? $end_date : date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="kategoriFilter" class="form-label">Filter Kategori (Opsional)</label>
                                <select class="form-select" id="kategoriFilter" name="kategori_id">
                                    <option value="0">Semua Kategori</option>
                                    <?php if (!empty($accounts)) : ?>
                                        <?php foreach ($accounts as $account) : ?>
                                            <option value="<?= $account->no_account; ?>"><?= $account->no_account . '-' . $account->description_account; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-3 d-flex justify-content-lg-end">
                                <button type="submit" class="btn btn-danger me-2"><i class="bi bi-funnel me-2"></i> Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
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