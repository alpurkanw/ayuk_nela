<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php

    // char_total
    // $data_barchart_total = [];
    // foreach ($barchart_total as $key => $value) {
    //     $data_barchart_total[] = [
    //         "tanggal" => $value->tanggal_transaksi,
    //         "jumlah" => $value->jum_trx
    //     ];
    // }
    // print_r($data_barchart_total);
    // return;
    ?>

    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('owner/side_menu'); ?>
    <div id="content">
        <h4 class="card-title">Dashboard Bulanan </h4>
        <hr>
        <form method="post" action="<?= base_url('owner/Dashboard/dsh_bulan'); ?>">
            <div class="row">
                <div class="col-6">
                    <input type="month" class="form-control" id="bulan" name="bulan" value="<?= isset($start_date) ? date('Y-m') : date('Y-m'); ?>">
                </div>
                <div class="col-6 d-flex align-items-start">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        <hr>
        <h4>
            Data Periode bulan : <?= $bulan; ?>
        </h4>
        <div class="row text-sm">
            <div class="col-lg-12 ">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <a href="<?= base_url('owner/Laporan/lapMaterial'); ?>" class="text-reset text-decoration-none">
                            <div class="card text-white bg-primary shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-cash-coin me-3" style="font-size: 2.5rem;"></i>
                                    <div>
                                        <h5 class="card-title text-sm">Penjualan Material Hari Ini</h5>
                                        <p class="card-text fs-6 fw-bold">
                                            <?= !is_null($jumlah_total_today[0]->jumlah_total_today) ? "Rp " . number_format($jumlah_total_today[0]->jumlah_total_today) : "Belum Ada Transaksi" ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="card text-white bg-primary shadow-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi bi-box-arrow-in-left me-3" style="font-size: 2.5rem;"></i>
                                <div>
                                    <h5 class="card-title text-sm">Pendapatan lain Hari Ini</h5>
                                    <p class="card-text fs-6 fw-bold">
                                        <?= ($trx_inout[0]->jum_nominal) ? "Rp " . number_format($trx_inout[0]->jum_nominal) : "Belum Ada Transaksi"; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="<?= base_url('owner/Laporan/lap_uang_keluar'); ?>" class="text-reset text-decoration-none">
                            <div class="card text-white bg-primary shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-box-arrow-right me-3" style="font-size: 2.5rem;"></i>
                                    <div>
                                        <h5 class="card-title text-sm">Pengeluaran Hari Ini</h5>
                                        <p class="card-text fs-6 fw-bold">
                                            <?= ($trx_inout[1]->jum_nominal) ? "Rp " . number_format($trx_inout[1]->jum_nominal) : "Belum Ada Transaksi"; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                    $total_margin = number_format($jumlah_total_today[0]->jumlah_total_today + $trx_inout[0]->jum_nominal - $trx_inout[1]->jum_nominal); ?>
                    <div class="col-md-12 ">
                        <a href="<?= base_url('owner/Laporan/harian'); ?>" class="text-reset text-decoration-none">
                            <div class="card text-white <?= ($total_margin < 0) ? 'bg-danger' : 'bg-primary'; ?> shadow-sm h-100">
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-coin me-3" style="font-size: 2.5rem;"></i>
                                    <div>
                                        <h5 class="card-title text-sm">Margin (Laba / Rugi) </h5>
                                        <p class="card-text fs-6 fw-bold"><?= "Rp " . $total_margin; ?> </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-sm mt-2">
            <div class="col-lg-6 ">
                <div class="card shadow-sm ">
                    <div class="card-header">
                        <h5 class="card-title">Material Terlaris</h5>
                        <p class="card-text">Daftar Material Terlaris Bulan Ini</p>
                    </div>
                    <div class="card-body">
                        <?php
                        $labels_chart = [];
                        $data_chart = [];
                        if (!empty($material_terlaris)) : ?>
                            <div class="row justify-content-center ">
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div style="width: 300px; height: 300px;" class="chart-container">
                                        <canvas id="donutChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-4">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered table-sm" id="laporanPenjualanMaterial">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Material</th>
                                                    <th>Jumlah Ritase</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                // echo "angka 1 " . $no;
                                                $total_jum = 0;
                                                $backgroundColor = [
                                                    '#0d6efd',
                                                    '#dc3545',
                                                    '#ffc107',
                                                    '#198754',
                                                    '#6610f2',
                                                    '#fd7e14',
                                                    '#20c997',
                                                    '#3498db',
                                                    '#e74c3c',
                                                    '#2ecc71',
                                                    '#f39c12',
                                                    '#9b59b6',
                                                    '#1abc9c',
                                                    '#f1c40f',
                                                    '#e67e22'
                                                ]; ?>
                                                <?php foreach ($material_terlaris as $mtrl_terlaris) : ?>
                                                    <?php
                                                    $labels_chart[] = $mtrl_terlaris->nama_material;
                                                    $data_chart[] = (int)$mtrl_terlaris->jumlah;
                                                    ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= htmlspecialchars($mtrl_terlaris->nama_material); ?></td>
                                                        <td class="text-end"> <span class="badge" style="background-color: <?= $backgroundColor[$no - 1] ?>; color: #fff;"><?= number_format($mtrl_terlaris->jumlah, 0, ',', '.'); ?></span> </td>
                                                    </tr>
                                                <?php
                                                    // echo "angka 2 " . $no;
                                                    $no++;
                                                    $total_jum += $mtrl_terlaris->jumlah;
                                                endforeach; ?>
                                            </tbody>
                                            <tfoot class="table-primary">
                                                <tr>
                                                    <th colspan="2" class="text-end">Total</th>
                                                    <th class="text-end"><?= number_format($total_jum); ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="text-center text-muted">Tidak ada data penjualan material untuk periode ini.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 ">

                <div class="card shadow-sm ">
                    <a href="<?= base_url('owner/Laporan/lap_uang_keluar'); ?>" class="text-reset text-decoration-none">
                        <div class="card-header">
                            <h5 class="card-title">10 Daftar Pengeluaran terbanyak bulan ini</h5>
                            <p class="card-text"> Klik di sini untuk melihat Detail</p>
                        </div>
                    </a>
                    <div class="card-body">
                        <?php
                        $labels_chart_trxkeluar = [];
                        $data_chart_trxkeluar = [];
                        if (!empty($keluar_terbanyak)) : ?>

                            <div class="row justify-content-center ">
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div style="width: 400px; height: 300px;" class="chart-container">
                                        <canvas id="donutChart_pengeluaran_terbanyak"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-4">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered table-sm" id="laporanPenjualanMaterial">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Keterangan</th>
                                                    <th>Nominal Transaksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;

                                                $total_nom = 0;
                                                $backgroundColor = [
                                                    '#0d6efd',
                                                    '#dc3545',
                                                    '#ffc107',
                                                    '#198754',
                                                    '#6610f2',
                                                    '#fd7e14',
                                                    '#20c997',
                                                    '#3498db',
                                                    '#e74c3c',
                                                    '#2ecc71',
                                                    '#f39c12',
                                                    '#9b59b6',
                                                    '#1abc9c',
                                                    '#f1c40f',
                                                    '#e67e22'
                                                ];
                                                ?>
                                                <?php foreach ($keluar_terbanyak as $trx_keluar) : ?>
                                                    <?php
                                                    $labels_chart_trxkeluar[] = $trx_keluar->description_account;
                                                    $data_chart_trxkeluar[] = (int)$trx_keluar->jum_nom;
                                                    ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= htmlspecialchars($trx_keluar->description_account); ?></td>
                                                        <td class="text-end"> <span class="badge" style="background-color: <?= $backgroundColor[$no - 1] ?>; color: #fff;"><?= number_format($trx_keluar->jum_nom, 0, ',', '.'); ?></span> </td>
                                                    </tr>
                                                <?php
                                                    $total_nom += (int)$trx_keluar->jum_nom;
                                                    $no++;
                                                    if ($no == 11) {
                                                        break;
                                                    }
                                                endforeach; ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="text-center text-muted">Tidak ada pengeluaran untuk periode ini.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-sm mt-2">
            <div class="col-lg-12 ">
                <div class="card shadow-sm ">
                    <div class="card-header">
                        <h5 class="card-title">Jumlah Nominal Transaksi Perbulan Dalam Setahun </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div style="width: 100%; max-width: 1200px; margin: auto;">
                                    <canvas id="transaksiChart"></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    echo "<script>const transaksiData = '" . json_encode($char_total) . "';</script>";
    ?>

    <script>
        $(document).ready(function() {
            // Donut Chart 1: Material Terlaris
            let labels_chart_json = '<?= json_encode($labels_chart); ?>';
            let data_chart_json = '<?= json_encode($data_chart); ?>';
            let labels = JSON.parse(labels_chart_json);
            let data = JSON.parse(data_chart_json);

            if (data.length > 0) {
                const ctx = document.getElementById('donutChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Ritase',
                            data: data,
                            backgroundColor: [
                                '#0d6efd', '#dc3545', '#ffc107', '#198754', '#6610f2', '#fd7e14', '#20c997',
                                '#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#f1c40f',
                                '#e67e22'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                                position: 'right'
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Ritase Material Terlaris'
                            }
                        }
                    }
                });
            }

            // Donut Chart 2: Pengeluaran Terbanyak
            let labels_chart_json_trxkeluar = '<?= json_encode($labels_chart_trxkeluar); ?>';
            let data_chart_json_trxkeluar = '<?= json_encode($data_chart_trxkeluar); ?>';
            let labels_trxkeluar = JSON.parse(labels_chart_json_trxkeluar);
            let data_trxkeluar = JSON.parse(data_chart_json_trxkeluar);

            if (data_trxkeluar.length > 0) {
                const ctx_keluar = document.getElementById('donutChart_pengeluaran_terbanyak').getContext('2d');
                new Chart(ctx_keluar, {
                    type: 'doughnut',
                    data: {
                        labels: labels_trxkeluar,
                        datasets: [{
                            label: 'Jumlah Nominal',
                            data: data_trxkeluar,
                            backgroundColor: [
                                '#0d6efd', '#dc3545', '#ffc107', '#198754', '#6610f2', '#fd7e14', '#20c997',
                                '#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#f1c40f',
                                '#e67e22'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                                position: 'right'
                            },
                            title: {
                                display: true,
                                text: 'List Pengeluaran'
                            }
                        }
                    }
                });
            }

            // Bar Chart Harian

            if (typeof transaksiData !== 'undefined' && transaksiData.length > 0) {
                // 1. Parsing data JSON
                const dataParsed = JSON.parse(transaksiData);

                // 2. Mendapatkan tahun dari data pertama
                const year_total = dataParsed.length > 0 ? new Date(dataParsed[0].tanggal_trx + '-01').getFullYear() : new Date().getFullYear();

                // 3. Membuat array untuk semua 12 bulan
                const labels_total = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const nomMasuk = Array(12).fill(0);
                const nomKeluar = Array(12).fill(0);
                const nomMargin = Array(12).fill(0);

                // 4. Mengisi array dengan data yang relevan
                dataParsed.forEach(row => {
                    // Mendapatkan indeks bulan (0-11) dari tanggal transaksi
                    const monthIndex = new Date(row.tanggal_trx + '-01').getMonth();

                    // Memastikan data numerik dengan parseFloat
                    nomMasuk[monthIndex] = parseFloat(row.nom_masuk);
                    nomKeluar[monthIndex] = parseFloat(row.nom_keluar);
                    nomMargin[monthIndex] = parseFloat(row.nom_margin);
                });

                const data_total = {
                    labels: labels_total,
                    datasets: [{
                            label: 'Uang Masuk',
                            data: nomMasuk,
                            backgroundColor: '#198754'
                        },
                        {
                            label: 'Uang Keluar',
                            data: nomKeluar,
                            backgroundColor: '#dc3545'
                        },
                        {
                            label: 'Margin(laba/rugi)',
                            data: nomMargin,
                            backgroundColor: '#6610f2'
                        }
                    ]
                };

                const config = {
                    type: 'bar',
                    data: data_total,
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: `Grafik Jumlah Nominal Transaksi Tahun ${year_total}`
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Nominal'
                                }
                            }
                        }
                    }
                };
                new Chart(document.getElementById('transaksiChart').getContext('2d'), config);
            }


        });
    </script>
</body>

</html>