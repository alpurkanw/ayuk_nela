<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* =======================================
        * Struktur Layout Utama
        * ======================================= */
        body {
            display: flex;
            min-height: 100vh;
            font-size: 0.9rem;
            /* Ukuran font lebih kecil untuk kerapian */
        }

        #sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: #212529;
            /* Warna yang lebih gelap dan kontras */
            color: #f8f9fa;
            transition: all 0.3s ease;
            overflow-y: auto;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
        }

        #sidebar.collapsed {
            margin-left: -250px;
        }

        #content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f0f2f5;
            /* Warna background konten yang lebih lembut */
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        /* =======================================
        * Navigasi Sidebar
        * ======================================= */
        .sidebar-menu .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: #343a40;
            border-radius: 5px;
            /* Menambahkan sudut melengkung */
        }

        .sidebar-menu .nav-link i {
            margin-right: 10px;
        }

        .sidebar-submenu .nav-link {
            padding-left: 40px;
            font-size: 0.85em;
        }

        .navbar-toggler {
            display: none;
        }

        /* =======================================
        * Kartu dan Tabel Konten
        * ======================================= */
        .card {
            border-radius: 10px;
            /* Sudut melengkung untuk kartu */
            border: none;
        }

        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .table-bordered {
            border-color: #e9ecef;
        }

        /* =======================================
        * Responsif & Print
        * ======================================= */
        @media (max-width: 767.98px) {
            #sidebar {
                position: fixed;
                height: 100vh;
                z-index: 1030;
                margin-left: -250px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }

            #sidebar.show {
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

    <?php $this->load->view('admin/side_menu'); ?>

    <div id="content m-2">
        <div class="card m-2 shadow-sm mb-4">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-end">
                    <a href="<?= base_url('admin/Laporan/harian') ?>" class="btn btn-success me-2" rel="noopener noreferrer">Kembali</a>
                    <button type="button" class="btn btn-danger" onclick="printReportHarian()"><i class="bi bi-printer me-2"></i> Cetak Laporan</button>
                </div>

                <h6 class="mt-4 mb-3">Laporan untuk Tanggal: <?= $start_date . " Sampai Dengan " . $end_date; ?></h6>

                <!-- Card Pendapatan -->
                <div class="card bg-light mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-arrow-down-left-square me-2"></i> Pendapatan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Keterangan</th>
                                        <th class="text-end">Jumlah Transaksi</th>
                                        <th class="text-end">Jumlah (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_inc = 0;
                                    $total_trx_inc = 0; ?>
                                    <?php if (!empty($trx_uangmasuk)) : ?>
                                        <?php foreach ($trx_uangmasuk as $inc) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($inc->ket); ?></td>
                                                <td class="text-end"><?= number_format($inc->jum_trx, 0); ?></td>
                                                <td class="text-end"><?= number_format($inc->jum_nominal, 0); ?></td>
                                            </tr>
                                            <?php $total_inc += $inc->jum_nominal;
                                            $total_trx_inc += $inc->jum_trx; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada transaksi pendapatan pada tanggal ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-group-divider">
                                    <tr class="fw-bold">
                                        <td class="text-end">TOTAL</td>
                                        <td class="text-end"><?= number_format($total_trx_inc, 0); ?></td>
                                        <td class="text-end text-success">Rp <?= number_format($total_inc, 0); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Card Pengeluaran -->
                <div class="card bg-light mb-3">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-arrow-up-right-square me-2"></i> Pengeluaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Keterangan</th>
                                        <th class="text-end">Jumlah Transaksi</th>
                                        <th class="text-end">Jumlah (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_dec = 0;
                                    $total_trx_dec = 0; ?>
                                    <?php if (!empty($trx_uangkeluar)) : ?>
                                        <?php foreach ($trx_uangkeluar as $keluar) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($keluar->ket); ?></td>
                                                <td class="text-end"><?= number_format($keluar->jum_trx, 0); ?></td>
                                                <td class="text-end"><?= number_format($keluar->jum_nominal, 0); ?></td>
                                            </tr>
                                            <?php $total_dec += $keluar->jum_nominal;
                                            $total_trx_dec += $keluar->jum_trx; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada transaksi pengeluaran pada tanggal ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-group-divider">
                                    <tr class="fw-bold">
                                        <td class="text-end">TOTAL</td>
                                        <td class="text-end"><?= number_format($total_trx_dec, 0); ?></td>
                                        <td class="text-end text-danger">Rp <?= number_format($total_dec, 0, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Saldo Harian -->
                <?php $saldo_harian = $total_inc - $total_dec; ?>
                <div class="card shadow-sm mt-4">
                    <div class="card-body 
                            <?php if ($saldo_harian > 0) : ?>
                                bg-success
                            <?php elseif ($saldo_harian < 0) : ?>
                                bg-danger
                            <?php else : ?>
                                bg-secondary
                            <?php endif; ?>
                            text-white text-center">
                        <h5 class="card-title mb-2">SALDO BERSIH HARIAN</h5>
                        <p class="card-text fs-3 fw-bold">
                            Rp <?= number_format($saldo_harian, 0, ',', '.'); ?>
                            <?php if ($saldo_harian > 0) : ?>
                                <i class="bi bi-arrow-up-right text-light ms-2"></i>
                            <?php elseif ($saldo_harian < 0) : ?>
                                <i class="bi bi-arrow-down-left text-light ms-2"></i>
                            <?php else : ?>
                                <i class="bi bi-dash-lg text-light ms-2"></i>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function exportExcelHarian() {
            alert('Fitur Ekspor Excel Laporan Harian akan dikembangkan. Mohon tunggu.');
        }

        function printReportHarian() {
            $('body').addClass('no-print');
            window.print();
            $('body').removeClass('no-print');
        }

        // Script untuk toggle sidebar (asumsi ada)
        function toggleSidebar() {
            $('#sidebar').toggleClass('show');
            $('.overlay').toggleClass('active');
        }

        $(document).ready(function() {
            // Logika untuk menampilkan/menyembunyikan sidebar di layar kecil
            $('.navbar-toggler').on('click', function() {
                $('#sidebar').toggleClass('show');
                $('.overlay').toggleClass('active');
            });

            $('.overlay').on('click', function() {
                $('#sidebar').removeClass('show');
                $('.overlay').removeClass('active');
            });
        });
    </script>
</body>

</html>