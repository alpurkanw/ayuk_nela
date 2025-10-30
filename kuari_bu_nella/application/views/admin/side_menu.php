<style>
    /* CSS kustom minimal untuk layout */
    body {
        display: flex;
        min-height: 100vh;
    }

    #content {
        flex-grow: 1;
        padding: 20px;
        background-color: #f8f9fa;
        overflow-y: auto;
    }

    /* Pastikan elemen body tidak memiliki display:flex di layar kecil agar konten utama menempati 100% lebar */
    @media (max-width: 767.98px) {
        body {
            display: block;
        }
    }
</style>

<!-- Tombol burger untuk menampilkan sidebar di perangkat seluler -->
<nav class="navbar navbar-light bg-light shadow-sm d-md-none">
    <div class="container-fluid">
        <!-- Tambahkan nama aplikasi di sini -->
        <div class="d-flex align-items-center me-auto">
            <div>
                <span class="fs-6 fw-bold">Aplikasi Pencatatan Transaksi Kuari</span><br>
                <small class="text-muted">By Bintang Lacita Group</small>
            </div>
        </div>
        <!-- Tombol Burger di kanan -->
        <button class="btn btn-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Komponen Offcanvas untuk Sidebar di perangkat seluler -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
    <div class="offcanvas-header">
        <a href="<?= base_url(); ?>" class="text-reset text-decoration-none">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Admin Panel</h5>
        </a>

        <!-- Tombol untuk menutup offcanvas -->
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Konten Sidebar dengan kelas bawaan Bootstrap -->
        <div class="d-flex flex-column h-100">
            <nav class="nav flex-column sidebar-menu flex-grow-1">
                <a class="nav-link text-white active" href="<?= base_url(); ?>"><i class="bi bi-house me-2"></i> Home</a>

                <div class="nav-item">
                    <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#masterMenu" role="button" aria-expanded="false" aria-controls="masterMenu">
                        <i class="bi bi-database me-2"></i> Master Table
                    </a>
                    <div class="collapse" id="masterMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Account'); ?>"><i class="bi bi-dot me-2"></i> Account</a></li>
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Material'); ?>"><i class="bi bi-dot me-2"></i> Material</a></li>
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Sopir'); ?>"><i class="bi bi-dot me-2"></i> Sopir</a></li>
                        </ul>
                    </div>
                </div>

                <div class="nav-item">
                    <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#transaksiMenu" role="button" aria-expanded="false" aria-controls="transaksiMenu">
                        <i class="bi bi-cash-stack me-2"></i> Transaksi
                    </a>
                    <div class="collapse" id="transaksiMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Financial/uangMasuk'); ?>"><i class="bi bi-dot me-2"></i> Uang Masuk</a></li>
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Financial/uangKeluar'); ?>"><i class="bi bi-dot me-2"></i> Uang Keluar</a></li>
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Penjualan/batal_form'); ?>"><i class="bi bi-dot me-2"></i> Pembatalan Penjualan</a></li>
                        </ul>
                    </div>
                </div>

                <div class="nav-item">
                    <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#laporanMenu" role="button" aria-expanded="false" aria-controls="laporanMenu">
                        <i class="bi bi-graph-up me-2"></i> Laporan
                    </a>
                    <div class="collapse" id="laporanMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Laporan/lapMaterial'); ?>"><i class="bi bi-dot me-2"></i> Lap. Penjualan Material</a></li>
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Laporan/lapMaterialperSopir'); ?>"><i class="bi bi-dot me-2"></i> Lap. Penjualan Material per Sopir</a></li>
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Laporan/lap_uang_masuk'); ?>"><i class="bi bi-dot me-2"></i> Lap. Transaksi Uang Masuk</a></li>
                            <li><a class="nav-link text-white" href="<?= base_url('admin/Laporan/lap_uang_keluar') ?>"><i class="bi bi-dot me-2"></i> Lap. Transaksi Uang Keluar</a></li>
                            <li hidden><a class="nav-link text-white" href="<?= base_url('admin/Laporan/harian'); ?>"><i class="bi bi-dot me-2"></i> Laporan Harian</a></li>
                        </ul>
                    </div>
                </div>
                <a class="nav-link text-white active" href="<?= base_url('Auth/gantiPass'); ?>"><i class="bi bi-speedometer me-2"></i> Ganti Password</a>
                <div class="mt-auto">
                    <a class="nav-link text-danger" href="<?= base_url('Auth/logout'); ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
                </div>
            </nav>
        </div>
    </div>
</div>

<!-- Sidebar untuk tampilan desktop (Layar lebar) -->
<div id="sidebar" class="d-none d-md-flex flex-column p-2 bg-info text-white" style="width: 350px;">
    <div class="border-bottom pb-3 mb-3 text-center">
        <h4 class="text-muted mb-0">Admin Panel</h4>
        <small class="text-muted">Aplikasi Kuari</small>
    </div>
    <nav class="nav flex-column flex-grow-1">
        <a class="nav-link text-muted active" href="<?= base_url(); ?>"><i class="bi bi-house me-2"></i> Home</a>

        <div class="nav-item">
            <a class="nav-link text-muted collapsed" data-bs-toggle="collapse" href="#masterMenuDesktop" role="button" aria-expanded="false" aria-controls="masterMenuDesktop">
                <i class="bi bi-database me-2"></i> Master Table
            </a>
            <div class="collapse" id="masterMenuDesktop">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Account'); ?>"><i class="bi bi-dot me-2"></i> Account</a></li>
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Material'); ?>"><i class="bi bi-dot me-2"></i> Material</a></li>
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Sopir'); ?>"><i class="bi bi-dot me-2"></i> Sopir</a></li>
                </ul>
            </div>
        </div>

        <div class="nav-item">
            <a class="nav-link text-muted collapsed" data-bs-toggle="collapse" href="#transaksiMenuDesktop" role="button" aria-expanded="false" aria-controls="transaksiMenuDesktop">
                <i class="bi bi-cash-stack me-2"></i> Transaksi
            </a>
            <div class="collapse" id="transaksiMenuDesktop">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-3">
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Financial/uangMasuk'); ?>"><i class="bi bi-dot me-2"></i> Uang Masuk</a></li>
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Financial/uangKeluar'); ?>"><i class="bi bi-dot me-2"></i> Uang Keluar</a></li>
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Penjualan/batal_form'); ?>"><i class="bi bi-dot me-2"></i> Pembatalan Penjualan</a></li>

                </ul>
            </div>
        </div>

        <div class="nav-item">
            <a class="nav-link text-muted collapsed" data-bs-toggle="collapse" href="#laporanMenuDesktop" role="button" aria-expanded="false" aria-controls="laporanMenuDesktop">
                <i class="bi bi-graph-up me-1"></i> Laporan
            </a>
            <div class="collapse" id="laporanMenuDesktop">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-1">
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Laporan/lapMaterial'); ?>"><i class="bi bi-dot me-2"></i> Lap. Penjualan Material</a></li>
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Laporan/lapMaterialperSopir'); ?>"><i class="bi bi-dot me-2"></i> Lap. Penjualan Material per Sopir</a></li>
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Laporan/lap_uang_masuk'); ?>"><i class="bi bi-dot me-2"></i> Lap. Transaksi Uang Masuk</a></li>
                    <li><a class="nav-link text-muted" href="<?= base_url('admin/Laporan/lap_uang_keluar') ?>"><i class="bi bi-dot me-2"></i> Lap. Transaksi Uang Keluar</a></li>
                    <li hidden><a class="nav-link text-muted" href="<?= base_url('admin/Laporan/harian'); ?>"><i class="bi bi-dot me-2"></i> Laporan Harian</a></li>
                </ul>
            </div>
        </div>
        <a class="nav-link text-muted active" href="<?= base_url('Auth/gantiPass'); ?>"><i class="bi bi-speedometer me-2"></i> Ganti Password</a>
        <div class="nav-item">
            <a class="nav-link text-danger" href="<?= base_url('Auth/logout'); ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
        </div>
    </nav>
</div>