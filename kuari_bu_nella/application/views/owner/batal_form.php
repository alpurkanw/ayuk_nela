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

    <div class="row">
        <div class="col-12 ">
            <div class="card m-2">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-2">Pembatalan Penjualan Material</h5>
                    <p class="card-text mb-4">
                        Silahkan Input ID Transakksi di form ini.</p>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>