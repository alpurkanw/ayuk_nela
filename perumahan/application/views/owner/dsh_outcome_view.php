<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $judul; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon_04.png') ?>">


    <!-- Custom fonts for this template -->
    <link href="<?= base_url("assets/adminsb/"); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url("assets/adminsb/"); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= base_url("assets/adminsb/"); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php $this->load->view('owner/01_sidebar'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php $this->load->view('owner/02_topbar');                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading
                    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

                    <!-- DataTales Example -->

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Pengeluaran Bulan <?= date('M Y'); ?> </h1>
                    </div>


                    <!-- TOTAL SEMUA -->
                    <div class="row pb-0 mb-4">


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-md-12">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-x3 font-weight-bold text-info text-uppercase mb-1">TOTAL SELURUH PENGELUARAN
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> Rp <?= number_format($tot_nom_semua[0]["tot_nom_semua"]); ?></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <small>Semua pengeluaran (Umum + Rumah)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row pb-0 mb-4">


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-x3 font-weight-bold text-info text-uppercase mb-1">TOTAL PENGELUARAN UMUM
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> Rp <?= number_format($tot_nom_umum[0]["tot_nom_umum"]); ?></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <small>Semua pengeluaran Perumahan diluar kebutuhan rumah</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-x3 font-weight-bold text-info text-uppercase mb-1">TOTAL PENGELUARAN RUMAH
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> Rp <?= number_format($tot_nom_rumah[0]["tot_nom_rumah"]); ?></div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <small>Semua Pengeluaran Yang Digunakan Untuk Pembangunan Rumah</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row pb-0 ">


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6">


                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Pengeluaran Umum</h6>

                                </div>

                                <div class="card-body m-0 p-2">

                                    <?php
                                    $labels_chart_trxkeluar = [];
                                    $data_chart_trxkeluar = [];
                                    if (!empty($per_kateg_umum)) : ?>
                                        <div class="row">
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
                                                            <?php
                                                            // print_r($per_kateg_umum);
                                                            foreach ($per_kateg_umum as $trx_out_umum) : ?>
                                                                <?php
                                                                // $labels_chart_trxkeluar[] = $trx_out_umum->description_account;
                                                                // $data_chart_trxkeluar[] = (int)$trx_out_umum->jum_nom;
                                                                ?>
                                                                <tr>
                                                                    <td><?= $no ?></td>
                                                                    <td><?= htmlspecialchars($trx_out_umum->nama_kateg); ?></td>
                                                                    <td class="text-right"> <span class="badge" style="background-color: #0d6efd;; color: #fff;">Rp <?= number_format($trx_out_umum->jumlah, 0, ',', '.'); ?></span> </td>
                                                                </tr>
                                                            <?php
                                                                $total_nom += (int)$trx_out_umum->jumlah;
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

                                        <small>Kategori Pengeluaran diurutkan dari terbesar sampai terkecil dalam 1 bulan </small>
                                    <?php else : ?>
                                        <div class="text-center text-muted">Tidak ada pengeluaran untuk Umum periode ini.</div>
                                    <?php endif; ?>


                                </div>
                            </div>


                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card shadow ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Pengeluaran Rumah</h6>

                                </div>

                                <div class="card-body p-2 m-0">


                                    <?php
                                    $labels_chart_trxkeluar = [];
                                    $data_chart_trxkeluar = [];
                                    if (!empty($per_kateg_umum)) : ?>
                                        <div class="row">
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
                                                            // $backgroundColor = [
                                                            //     '#0d6efd',
                                                            //     '#dc3545',
                                                            //     '#ffc107',
                                                            //     '#198754',
                                                            //     '#6610f2',
                                                            //     '#fd7e14',
                                                            //     '#20c997',
                                                            //     '#3498db',
                                                            //     '#e74c3c',
                                                            //     '#2ecc71',
                                                            //     '#f39c12',
                                                            //     '#9b59b6',
                                                            //     '#1abc9c',
                                                            //     '#f1c40f',
                                                            //     '#e67e22'
                                                            // ];
                                                            ?>
                                                            <?php
                                                            // print_r($per_kateg_umum);
                                                            foreach ($per_kateg_rumah as $trx_out_umum) : ?>
                                                                <?php
                                                                // $labels_chart_trxkeluar[] = $trx_out_umum->description_account;
                                                                // $data_chart_trxkeluar[] = (int)$trx_out_umum->jum_nom;
                                                                ?>
                                                                <tr>
                                                                    <td><?= $no ?></td>
                                                                    <td><?= htmlspecialchars($trx_out_umum->nama_kateg); ?></td>
                                                                    <td class="text-right"> <span class="badge" style="background-color: #0d6efd; color: #fff;">Rp <?= number_format($trx_out_umum->jumlah, 0, ',', '.'); ?></span> </td>
                                                                </tr>
                                                            <?php
                                                                $total_nom += (int)$trx_out_umum->jumlah;
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

                                        <small>Berikut adalah dashboard yang menjelaskan Persentase penjualan rumah per perumahan</small>
                                    <?php else : ?>
                                        <div class="text-center text-muted">Tidak ada pengeluaran untuk Umum periode ini.</div>
                                    <?php endif; ?>


                                </div>
                            </div>

                        </div>

                    </div>



                    <!-- <div class="row pb-0 mb-4">


                        <div class="col-xl-12 col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="myBarChart" width="448" height="320" style="display: block; width: 448px; height: 320px;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <hr>
                                    Styling for the bar chart can be found in the
                                    <code>/js/demo/chart-bar-demo.js</code> file.
                                </div>
                            </div>

                        </div>


                    </div> -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url("assets/adminsb/"); ?>js/sb-admin-2.min.js"></script>


    <!-- Page level plugins -->
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url("assets/adminsb/"); ?>js/demo/chart-bar-demo.js"></script>


    <!-- Page level custom scripts -->
    <script src="<?= base_url("assets/adminsb/"); ?>js/demo/datatables-demo.js"></script>

</body>

</html>