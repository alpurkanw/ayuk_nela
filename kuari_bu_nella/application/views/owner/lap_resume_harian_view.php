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

    <?php $this->load->view('owner/side_menu'); ?>

    <div id="content" class="">
        <div class="row">
            <div class="col">
                <div class="card m-2 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="<?= base_url('owner/Laporan/harian') ?>" class="btn btn-primary me-2" rel="noopener noreferrer">Kembali</a>
                            <button type="button" class="btn btn-primary" onclick="printReportHarian()"><i class="bi bi-printer me-2"></i> Cetak Laporan</button>
                        </div>

                        <h6 class="mt-4 mb-3">Laporan untuk Tanggal: <?= $start_date . " Sampai Dengan " . $end_date; ?></h6>

                        <div class="card bg-light mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-arrow-down-left-square me-2"></i> Pendapatan</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-sm table-striped table-bordered">
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
                                                    <td colspan="3" class="text-center text-muted">Tidak ada transaksi pendapatan pada periode ini.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot class="table-group-divider">
                                            <tr class="fw-bold">
                                                <td class="text-end">TOTAL</td>
                                                <td class="text-end"><?= number_format($total_trx_inc, 0); ?></td>
                                                <td class="text-end ">Rp <?= number_format($total_inc, 0); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0"><i class="bi bi-arrow-up-right-square me-2"></i> Pengeluaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-sm table-striped table-bordered">
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
                                                    <td colspan="3" class="text-center text-muted">Tidak ada transaksi pengeluaran pada periode ini.</td>
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

                        <?php $saldo_harian = $total_inc - $total_dec; ?>
                        <div class="card shadow-sm mt-4">
                            <div class="card-body 
                        <?php if ($saldo_harian > 0) : ?>
                            bg-primary
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

        function toggleSidebar() {
            $('#sidebar').toggleClass('show');
            $('.overlay').toggleClass('active');
        }

        $(document).ready(function() {
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