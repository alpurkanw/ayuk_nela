<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bintang Lacita Group</title>
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

                <?php $this->load->view('owner/02_topbar'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid p-2">

                    <a href="#" class="btn mb-2 btn-primary btn_print " target="_blank">
                        Print</a>

                    <div class="card shadow mb-4 printed_area">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">LIST PENDAPATAN(DP) PENJUALAN RUMAH</h6>
                            <br><?= "PERUMAHAN : " . htmlspecialchars(
                                    (isset($list_rumah[0]) && $list_rumah[0]->nama_perum != "")
                                        ? $list_rumah[0]->nama_perum
                                        : "Tidak Ada Data Rumah Terjual"
                                ); ?>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped" role="grid" id="laporanPenjualanKeluar">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No.</th>
                                            <th>No Rumah </th>
                                            <th>Pemilik </th>
                                            <th>Jenis Pendapatan(DP) </th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($list_rumah)) : ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($list_rumah as $data) : ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= htmlspecialchars($data->norumah); ?></td>
                                                    <td><?= htmlspecialchars($data->nama_cust); ?></td>
                                                    <td><?= htmlspecialchars($data->nama_harga); ?></td>
                                                    <td><?= number_format($data->nominal); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada data DP untuk periode ini.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid p-2 -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url("assets/adminsb/"); ?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url("assets/adminsb/"); ?>js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#laporanPenjualanKeluar').DataTable({
                "pageLength": 25,
                "ordering": true,
                "order": [
                    [1, "asc"]
                ],
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }]
            });

            $(".btn_print").click(function() {
                var table = $('#laporanPenjualanKeluar').DataTable();
                var headerHtml = $('#laporanPenjualanKeluar thead').prop('outerHTML');
                var rowsNodes = table.rows().nodes();
                var bodyHtml = '';
                for (var i = 0; i < rowsNodes.length; i++) {
                    bodyHtml += rowsNodes[i].outerHTML;
                }

                var fullTable = '<table class="table table-sm table-bordered table-striped" role="grid">' + headerHtml + '<tbody>' + bodyHtml + '</tbody></table>';
                var newWindow = window.open('', '_blank');
                newWindow.document.write(`<!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                        <title><?= isset($judul) ? $judul : 'Print'; ?></title>
<link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon_04.png') ?>">

                        <link href="<?= base_url("assets/adminsb/"); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
                        <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
                        <link href="<?= base_url("assets/adminsb/"); ?>css/sb-admin-2.min.css" rel="stylesheet">
                        <link href="<?= base_url("assets/adminsb/"); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
                        <style>body{padding:20px;} .dataTables_filter, .dataTables_length, .dataTables_info, .dataTables_paginate{display:none !important;}</style>
                    </head>
                    <body>
                        <h4>LIST PENDAPATAN(DP) PENJUALAN RUMAH</h4>
                        <h5>PERUMAHAN : <?= isset($list_rumah[0]) && $list_rumah[0]->nama_perum ? htmlspecialchars($list_rumah[0]->nama_perum) : 'Tidak Ada Data Rumah Terjual'; ?></h5>
                        ` + fullTable + `
                    </body>
                    </html>`);
                newWindow.document.close();
            });
        });
    </script>

</body>

</html>