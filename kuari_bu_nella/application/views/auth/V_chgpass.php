<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $judul; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-2">

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->




                <div class="row">
                    <div class="col">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Ganti Password
                                </h3>
                            </div> <!-- /.card-body -->
                            <div class="card-body">
                                <?= $this->session->flashdata('pesan'); ?>
                                <form action="<?= base_url('Auth/gantiPass_Proses') ?>" method="post">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="old_password">Password Lama:</label>
                                            <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Masukkan password lama">
                                            <?php echo form_error('old_password', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="new_password">Password Baru:</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru (minimal 8 karakter)">
                                            <?php echo form_error('new_password', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="new_password_confirm">Konfirmasi Password Baru:</label>
                                            <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="Konfirmasi password baru">
                                            <?php echo form_error('new_password_confirm', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                        <div class="form-group mt-2">
                                            <a href="<?= base_url() ?>" class="btn btn-secondary">Batal</a>
                                            <button type="submit" class="btn btn-primary">Ganti Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                        </div>

                    </div>

                </div>

                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>