<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Transaksi Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* CSS untuk tampilan cetak */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white !important;
                font-size: 12px;
                /* Ukuran font lebih kecil untuk cetak */
            }

            .card {
                /* Untuk memastikan card tercetak dengan rapi */
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
                margin-bottom: 0.5rem !important;
                /* Jarak antar card saat cetak */
            }

            .container {
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-light fs-6">

    <nav class="navbar navbar-expand-lg bg-success px-3 no-print">
        <div class="container-fluid d-flex justify-content-start align-items-center">
            <button class="btn btn-link text-white me-2 p-0" onclick="history.back()">
                <i class="bi bi-arrow-left fs-4"></i>
            </button>
            <span class="navbar-brand text-white fw-bold m-0">LAPORAN TRANSAKSI</span>
        </div>
    </nav>

    <div class="container py-3">
        <div class="card shadow-sm mb-4 no-print">
            <div class="card-body">
                <h5 class="card-title mb-3">Filter Laporan</h5>
                <!-- <form id="filterForm" class="row g-2 align-items-end"> -->
                <form action="<?= base_url("satgas/Laporan/retriev_trx"); ?>" class="form_submit" method="post">
                    <div class="col-md-5 col-sm-12">
                        <label for="tanggalMulai" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai">
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <label for="tanggalSelesai" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai">
                    </div>
                    <div class="col-md-2 col-sm-12 d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>

    <div class="fixed-bottom bg-white p-3 shadow-lg d-flex justify-content-center no-print">
        <div class="container-fluid text-center" style="max-width: 540px;">
            Versi 0.1
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mengisi tanggal hari ini secara otomatis untuk filter "Tanggal Selesai"
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            $('#tanggalSelesai').val(formattedDate);

            // Set tanggal mulai default (misal: 7 hari yang lalu)
            // const sevenDaysAgo = new Date();
            // sevenDaysAgo.setDate(today.getDate() - 7);
            // const formattedSevenDaysAgo = `${sevenDaysAgo.getFullYear()}-${String(sevenDaysAgo.getMonth() + 1).padStart(2, '0')}-${String(sevenDaysAgo.getDate()).padStart(2, '0')}`;
            $('#tanggalMulai').val(formattedDate);


            // Fungsi untuk mencetak laporan
            $('#printBtn').on('click', function() {
                window.print();
            });

            // Handle submit form filter (contoh, Anda perlu mengimplementasikan logika backend)

        });
    </script>
</body>

</html>