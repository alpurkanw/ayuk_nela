<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Sistem Keuangan</title>
    <link href="<?= base_url("assets/adminsb/"); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="<?= base_url("assets/adminsb/"); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .full-screen-center {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fc;
            /* Warna background default SB Admin 2 */
        }
    </style>
</head>

<body class="full-screen-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-primary p-5 text-white text-center">
                                <h4 class="fw-bold mt-4">Bintang Lacita Group</h4>
                                <p class="small">Sistem Keuangan & Aset Properti</p>
                                <img src="" alt="" class="img-fluid my-4">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 fw-bold">Selamat Datang Kembali!</h1>
                                    </div>

                                    <?php if ($this->session->flashdata('error')) : ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?= $this->session->flashdata('error') ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <form class="user" method="POST" action="<?= site_url('Auth/login_process') ?>">

                                        <div class="form-group">
                                            <input type="text" name="username" id="username" class="form-control form-control-user"
                                                placeholder="Masukkan Username Anda..." required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="password" id="password" class="form-control form-control-user"
                                                placeholder="Password" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block mt-4">
                                            Masuk
                                        </button>
                                    </form>
                                    <hr>

                                    <div class="text-center mt-4">
                                        <a class="small" href="#">Lupa Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url("assets/adminsb/"); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url("assets/adminsb/"); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url("assets/adminsb/"); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="<?= base_url("assets/adminsb/"); ?>js/sb-admin-2.min.js"></script>

</body>

</html>