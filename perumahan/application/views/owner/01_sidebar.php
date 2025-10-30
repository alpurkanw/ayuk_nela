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

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url("admin/Home"); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>



    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Pengeluaran"
            aria-expanded="true" aria-controls="Pengeluaran">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pembayaran Rumah</span>
        </a>
        <div id="Pengeluaran" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="<?= base_url("admin/Crumah"); ?>">Per Perumahan</a>
                <a class="collapse-item" href="<?= base_url("admin/Crumah"); ?>">Per Rumah</a>

            </div>
        </div>
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