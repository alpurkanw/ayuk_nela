<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>POS Kasir - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom styles for the elegant buttons */
        .menu-button {
            transition: all 0.3s ease;
            /* Smooth transition for hover effects */
            border: 2px solid var(--bs-success);
            /* Defined border */
            background-color: white;
            /* Default background */
            color: var(--bs-success);
            /* Default text/icon color */
        }

        .menu-button:hover {
            background-color: var(--bs-success);
            /* Green background on hover */
            color: white;
            /* White text/icon on hover */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            /* Subtle shadow on hover */
            transform: translateY(-3px);
            /* Slightly lift the button */
        }

        .menu-button .menu-icon {
            font-size: 2.5rem;
            /* Larger icon size */
            margin-bottom: 0.5rem;
            /* Space below icon */
            color: inherit;
            /* Inherit color from parent (menu-button) */
        }

        .menu-button strong,
        .menu-button small {
            color: inherit;
            /* Inherit color from parent (menu-button) */
        }

        .navbar-brand {
            font-size: 1.5rem;
            /* Make brand name slightly larger */
        }
    </style>
</head>

<body class="bg-light fs-6">

    <nav class="navbar navbar-expand-lg bg-success px-3">
        <div class="container-fluid justify-content-between align-items-center">
            <span class="navbar-brand text-white fw-bold">PENJUALAN</span>
        </div>
    </nav>

    <div class="text-white p-4" style="background: linear-gradient(to bottom, #198754, #146c43); border-bottom-left-radius: 1.25rem; border-bottom-right-radius: 1.25rem;">
        <h5 class="fw-bold">Selamat Datang</h5>
        <p class="mb-0">Menu Utama</p>
    </div>

    <hr class="my-3">

    <div class="container pb-3">
        <div id="menu-list" class="row g-3">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="ratio ratio-1x1 shadow-sm rounded-3 overflow-hidden">
                    <a href="<?= base_url('satgas/Penjualan'); ?>" class="btn menu-button d-flex flex-column align-items-center justify-content-center h-100 w-100">
                        <i class="bi bi-cart-fill menu-icon"></i> <strong class="mb-1">Penjualan</strong>
                        <small>Input Transaksi Baru</small>
                    </a>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="ratio ratio-1x1 shadow-sm rounded-3 overflow-hidden">
                    <a href="<?= base_url('satgas/Laporan'); ?>" class="btn menu-button d-flex flex-column align-items-center justify-content-center h-100 w-100">
                        <i class="bi bi-list-columns-reverse menu-icon"></i> <strong class="mb-1">List Transaksi</strong>
                        <small>Lihat Riwayat Penjualan</small>
                    </a>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="ratio ratio-1x1 shadow-sm rounded-3 overflow-hidden">
                    <a href="<?= base_url('satgas/Sopir/tambah'); ?>" class="btn menu-button d-flex flex-column align-items-center justify-content-center h-100 w-100">
                        <i class="bi bi-person-plus-fill menu-icon"></i> <strong class="mb-1">Daftar Sopir</strong>
                        <small>Registrasi Pengemudi</small>
                    </a>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="ratio ratio-1x1 shadow-sm rounded-3 overflow-hidden">
                    <a href="<?= base_url('Auth/gantiPass'); ?>" class="btn menu-button d-flex flex-column align-items-center justify-content-center h-100 w-100">
                        <i class="bi bi-lock-fill menu-icon"></i> <strong class="mb-1">Ganti Password</strong>
                        <small>Silahkan Ganti password anda disini</small>
                    </a>
                </div>
            </div>



            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="ratio ratio-1x1 shadow-sm rounded-3 overflow-hidden">
                    <a href="<?= base_url('Auth/logout'); ?>" class="btn menu-button d-flex flex-column align-items-center justify-content-center h-100 w-100">
                        <i class="bi bi-box-arrow-right menu-icon"></i> <strong class="mb-1">Logout</strong>
                        <small>Keluar Aplikasi</small>
                    </a>
                </div>
            </div>

        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>