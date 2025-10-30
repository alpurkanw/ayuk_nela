<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('admin/side_menu'); ?>
    <!-- Konten Utama -->
    <div id="content">
        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <h4 class="card-title">Selamat Datang, Admin!</h4>
                <p class="card-text">Ini adalah halaman beranda untuk panel administrasi Anda.</p>
                <!-- <a href="<?= base_url('penjualan'); ?>" class="btn btn-success mt-3"><i class="bi bi-cart-plus me-2"></i> Input Penjualan Baru</a> -->
            </div>
        </div>


    </div>

    <!-- Menghilangkan script JS kustom karena sudah digantikan dengan Bootstrap Offcanvas -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>