<nav class="navbar navbar-expand-lg bg-success px-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Tombol kembali di kiri -->
        <button class="btn btn-link text-white me-2 p-0" onclick="history.back()">
            <i class="bi bi-arrow-left fs-4"></i>
        </button>
        <span class="navbar-brand text-white fw-bold m-0 text-center flex-grow-1"><?= $judul; ?></span>
        <!-- Tombol burger bar di kanan -->
        <a class="btn btn-link text-white ms-2 p-0" href="<?= base_url('satgas/Home'); ?>">
            <i class="bi bi-list fs-4"></i>
        </a>
    </div>
</nav>