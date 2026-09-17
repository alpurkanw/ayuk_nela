<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url("owner/Home"); ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-home fa-2x"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BLG</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <hr class="sidebar-divider">



    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dashboard"
            aria-expanded="true" aria-controls="dashboard">
            <i class="fas fa-fw fa-cog"></i>
            <span>Dashboard</span>
        </a>
        <div id="dashboard" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url("owner/Cdashboard/per_perumahan"); ?>">Dashboard Per Perumahan</a>
            </div>
        </div>
    </li>






    <!-- Heading -->
    <div class="sidebar-heading mt-4">
        LAPORAN
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Tables -->
    <li class="nav-item ">
        <a class="nav-link" href="<?= base_url("owner/Claporan/lap_st_rumah_per_perum_form"); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Status Rumah</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="<?= base_url("owner/Claporan/lap_list_dp"); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>List Pendapatan(DP)</span></a>
    </li>
    <li class="nav-item ">
        <a class="nav-link" href="<?= base_url("owner/Claporan/lap_hutang_cust_form"); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Lap Hutang Customer</span></a>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#lap_penjualan"
            aria-expanded="true" aria-controls="lap_penjualan">
            <i class="fas fa-fw fa-cog"></i>
            <span>Laporan Penjualan</span>
        </a>
        <div id="lap_penjualan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="<?= base_url("owner/Claporan/lap_penjualan_per_perumahan"); ?>">Total per Perumahan</a>
                <!-- <a class="collapse-item" href="<?= base_url("owner/Claporan/lap_out_total_perumah_form"); ?>">Detail Per perumahan</a> -->
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#lap_keluar"
            aria-expanded="true" aria-controls="lap_keluar">
            <i class="fas fa-fw fa-cog"></i>
            <span>Laporan Pengeluaran</span>
        </a>
        <div id="lap_keluar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="<?= base_url("owner/Claporan/lap_out_per_perumahan"); ?>">UMUM Per Perumahan</a>
                <a class="collapse-item" href="<?= base_url("owner/Claporan/lap_out_rumah_per_perumahan"); ?>">RUMAH Per Perumahan</a>
                <a class="collapse-item" href="<?= base_url("owner/Claporan/lap_out_total_perumah_form"); ?>">Detail Per Rumah</a>
                <div class="dropdown-divider"></div>
                <a class="collapse-item" href="<?= base_url("owner/Claporan/lap_out_umum_per_perum_form"); ?>">Pengeluaran Umum</a>
                <!-- <a class="collapse-item" href="cards.html">Pengeluaran Umum</a> -->
            </div>
        </div>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="<?= base_url("owner/Claporan/lap_laba_rugi_form"); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Lap Laba Rugi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Tables -->
    <li class="nav-item ">
        <a class="nav-link" href="<?= base_url("Auth/logout"); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->
<link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon_04.png') ?>">