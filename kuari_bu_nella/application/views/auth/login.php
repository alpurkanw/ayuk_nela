<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            /* Smooth gradient background */
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            /* Green gradient */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Full viewport height */
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 1rem;
            /* Rounded corners for the card */
            overflow: hidden;
            /* Ensures header gradient fits within rounded corners */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            /* Enhanced shadow */
            border: none;
            /* Remove default card border */
        }

        .card-header {
            background: linear-gradient(to right, #28a745, #218838);
            /* Darker green gradient for header */
            color: white;
            padding: 1.5rem;
            border-bottom: none;
            position: relative;
        }

        .card-header h5 {
            font-weight: 700;
            font-size: 1.75rem;
            /* Larger font size for title */
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .input-group-text {
            background-color: #e9ecef;
            border-right: none;
            border-color: #ced4da;
        }

        .form-control {
            border-left: none;
            border-color: #ced4da;
            padding-left: 0.75rem;
            /* Adjust padding due to icon */
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
            /* Green focus glow */
            border-color: #28a745;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
            /* Slight lift on hover */
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.875rem;
            padding: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card {
                margin: 1rem;
                /* Add some margin on small screens */
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-header h5 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-7 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header text-white text-center">
                        <h5 class="mb-0">Bintang Lacita Group</h5>
                        <p class="mb-0 mt-1" style="font-size: 0.9rem;">Masuk untuk melanjutkan</p>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php
                        // echo "pesan: " . $this->session->flashdata('pesan');
                        ?>

                        <form method="POST" action="<?= site_url('Auth/login_process') ?>">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username Anda" required autofocus>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mt-3">Masuk</button>
                        </form>
                    </div>
                    <div class="card-footer text-muted text-center">
                        Sistem Keuangan Kuari &copy; <?= date('Y') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>