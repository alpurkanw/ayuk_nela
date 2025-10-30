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

    <style>
        @media print {

            body.no-print #sidebar,
            body.no-print .navbar-toggler,
            body.no-print .no-print,
            body.no-print .d-flex.justify-content-end,
            body.no-print .card-body>form,
            body.no-print .d-flex.justify-content-center.mt-3 {
                display: none !important;
            }

            body.no-print #content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0;
                overflow: visible !important;
            }

            body.no-print .card.shadow-sm {
                box-shadow: none !important;
                border: none !important;
            }

            body.no-print table {
                font-size: 10pt;
            }
        }
    </style>

</head>

<body>
    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('owner/side_menu'); ?>

    <div id="content">

        <div class=" card shadow-sm ">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-2">Laporan Uang Massuk (Pendapatan)</h5>
                <p class="card-text ">
                    Menampilkan rekapitulasi transaksi uang Massuk berdasarkan periode waktu dan jenis kategori.</p>
            </div>
            <div class="card-body">

                <form action="<?= base_url('owner/Laporan/lap_uang_masuk_view'); ?>" method="post" class="">
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
                        <div class="col-md-4 col-lg-3">
                            <label for="kategoriFilter" class="form-label">Filter Kategori (Opsional)</label>
                            <select class="form-select" id="kategoriFilter" name="kategori_id">
                                <option value="0">Semua Kategori</option>
                                <!-- Looping untuk menampilkan data dari database -->
                                <?php if (!empty($accounts)) : ?>
                                    <?php foreach ($accounts as $account) : ?>
                                        <option value="<?= $account->no_account; ?>"><?= $account->no_account . '-' . $account->description_account; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
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
            // Inisialisasi Select2 untuk filter kategori
            $('#kategoriFilter').select2({
                placeholder: "Pilih Kategori",
                allowClear: true,
                theme: "bootstrap-5"
            });

            // Set tanggal default jika belum ada filter
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