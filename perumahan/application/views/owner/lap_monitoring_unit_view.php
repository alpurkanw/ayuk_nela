<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= htmlspecialchars($judul); ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon_04.png') ?>">
    <link href="<?= base_url('assets/adminsb/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/adminsb/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <style>
        body {
            background: #f8f9fc;
        }

        .report-table th,
        .report-table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .report-table thead th {
            background: #f8f9fc;
            font-weight: 700;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #fff;
            }
        }
    </style>
</head>

<body id="page-top">
    <?php
    $rupiah = function ($nominal) {
        return 'Rp ' . number_format((float) $nominal, 0, ',', '.');
    };
    $formatTanggal = function ($tanggal) {
        return preg_match('/^\d{8}$/', (string) $tanggal) ? substr($tanggal, 6, 2) . '/' . substr($tanggal, 4, 2) . '/' . substr($tanggal, 0, 4) : '-';
    };
    ?>

    <div id="wrapper">
        <?php $this->load->view('owner/01_sidebar'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php $this->load->view('owner/02_topbar'); ?>

                <div class="container-fluid p-3">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary mb-0">Monitoring Seluruh Unit Rumah</h6>
                            <div class="no-print">
                                <a href="<?= base_url('owner/Cdashboard/per_perumahan_view?id_perumahan=' . $id_perum); ?>" class="btn btn-secondary btn-sm mr-2">Kembali</a>
                                <button onclick="window.print();" class="btn btn-primary btn-sm">Print</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div><strong>Perumahan:</strong> <?= htmlspecialchars($perum->nama); ?></div>
                                <div><strong>Alamat/Keterangan:</strong> <?= htmlspecialchars($perum->desk ?: '-'); ?></div>
                                <div><strong>Tanggal:</strong> <?= htmlspecialchars($report_date); ?></div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover report-table mb-0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Rumah</th>
                                            <th>Status</th>
                                            <th>Pembeli / Tgl Jual</th>
                                            <th class="text-right">Harga Jual</th>
                                            <th class="text-right">Tagihan</th>
                                            <th class="text-right">Terbayar</th>
                                            <th class="text-right">Sisa Piutang</th>
                                            <th class="text-right">Biaya Rumah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($status_rumah)) : ?>
                                            <?php foreach ($status_rumah as $index => $item) : ?>
                                                <?php $sisa = max(0, $item->tagihan - $item->terbayar); ?>
                                                <?php if (!$item->nama_cust) {
                                                    $status = '<span class="badge badge-secondary">Belum Terjual</span>';
                                                } elseif ($sisa > 0) {
                                                    $status = '<span class="badge badge-warning">Terjual - Piutang</span>';
                                                } else {
                                                    $status = '<span class="badge badge-success">Terjual - Lunas</span>';
                                                } ?>
                                                <tr>
                                                    <td><?= $index + 1; ?></td>
                                                    <td><?= htmlspecialchars($item->norumah); ?><small class="d-block text-muted"><?= htmlspecialchars($item->mtd_jual ?: '-'); ?></small></td>
                                                    <td><?= $status; ?></td>
                                                    <td><?= $item->nama_cust ? htmlspecialchars($item->nama_cust) . '<small class="d-block text-muted">' . $formatTanggal($item->tanggal_jual) . '</small>' : '-'; ?></td>
                                                    <td class="text-right"><?= $rupiah($item->harga_jual); ?></td>
                                                    <td class="text-right"><?= $rupiah($item->tagihan); ?></td>
                                                    <td class="text-right"><?= $rupiah($item->terbayar); ?></td>
                                                    <td class="text-right <?= $sisa > 0 ? 'text-danger font-weight-bold' : ''; ?>"><?= $rupiah($sisa); ?></td>
                                                    <td class="text-right"><?= $rupiah($item->biaya_rumah); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-3">Belum ada data rumah pada perumahan ini.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/adminsb/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/adminsb/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/adminsb/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <script src="<?= base_url('assets/adminsb/js/sb-admin-2.min.js'); ?>"></script>
</body>

</html>