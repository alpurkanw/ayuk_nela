<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaksi Berhasil!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Menghilangkan elemen non-print saat mencetak */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
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
            <span class="navbar-brand text-white fw-bold m-0">TRANSAKSI SUKSES</span>
        </div>
    </nav>

    <div class="container py-4">




        <div class="card shadow-sm text-center">
            <div class="card-body">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    <h2 class="card-title text-success mt-3">Bintang Lacita Group</h2>
                    <p class="card-text text-muted">Nota Penjualan Material</p>
                </div>

                <hr class="my-4">
                <h4></h4>

                <?php //print_r($trx);
                $trans = $trx[0]; ?>

                <h5 class="mb-3">Detail Transaksi:</h5>
                <div class="text-start mx-auto" style="max-width: 350px;">
                    <div>
                        <div class="row">
                            <div class="col">
                                <p class="mb-1"><strong>ID Transaksi:</strong> <span id="transaksiId">TRX-<?= $trans->id_transaksi; ?></span></p>
                            </div>
                            <div class="col-auto">|</div>
                            <div class="col-auto">
                                <p class="mb-1"><strong>Petugas:</strong> <span id="transaksiId"><?= $trans->user_inp; ?></span></p>
                            </div>
                        </div>
                    </div>
                    <p class="mb-1"><strong>Tanggal:</strong> <span id="tanggalTransaksiDisplay"><?= $trans->tanggal_transaksi; ?></span></p>
                    <p class="mb-1"><strong>Sopir:</strong> <span id="namaSopirDisplay"><?= $trans->nama_lengkap; ?></span></p>
                    <p class="mb-1"><strong>Material:</strong> <span id="jenisMaterialDisplay"><?= $trans->nama_material; ?></span></p>
                    <p class="mb-1"><strong>Harga:</strong> Rp <span id="hargaPenjualanDisplay"><?= number_format($trans->total_harga); ?></span></p>
                    <p class="mb-1"><strong>Status :</strong> <span id="tujuanPengangkutanDisplay">Sukses</span></p>
                    <p class="mb-1"><strong>Tujuan:</strong> <span id="tujuanPengangkutanDisplay"><?= $trans->tujuan_pengangkutan; ?></span></p>
                </div>

                <hr class="my-4">

                <div class="text-start mx-auto" style="max-width: 350px;">

                    <p class="mb-1 text-center"><span id="tujuanPengangkutanDisplay">Terima kasih sudah membeli material ditempat kami</span></p>
                </div>
                <hr class="my-4">

                <div class="d-grid gap-2 col-md-8 mx-auto no-print">
                    <button id="printBtn" class="btn btn-primary btn-lg"><i class="bi bi-printer me-2"></i> Cetak Struk</button>
                    <a href="<?= base_url('satgas/Penjualan'); ?>" class="btn btn-outline-success">Input Transaksi Baru</a>
                    <a href="<?= base_url('satgas/Home'); ?>" class="btn btn-outline-success">Kembali ke Menu Utama</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk mencetak halaman
            $('#printBtn').on('click', function() {
                window.print();
            });

            // Anda bisa mengisi data ini secara dinamis dari server (misal: dengan PHP, Node.js, dll.)
            // Setelah data transaksi disimpan di database dari form sebelumnya,
            // server akan mengarahkan ke halaman ini dan mengirimkan data transaksi.
            // Contoh statis data:
            /*
            $('#transaksiId').text('TRX-20250723-001');
            $('#tanggalTransaksiDisplay').text('23 Juli 2025');
            $('#namaSopirDisplay').text('Budi Santoso');
            $('#jenisMaterialDisplay').text('Pasir');
            $('#hargaPenjualanDisplay').text('150.000');
            $('#tujuanPengangkutanDisplay').text('Jl. Merdeka No. 10, Depok');
            */
            // Untuk simulasi, data sudah terisi langsung di HTML.
        });
    </script>
</body>

</html>