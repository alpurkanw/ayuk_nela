<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Transaksi Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* CSS untuk tampilan cetak */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white !important;
                font-size: 12px;
                /* Ukuran font lebih kecil untuk cetak */
            }

            .card {
                /* Untuk memastikan card tercetak dengan rapi */
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
                margin-bottom: 0.5rem !important;
                /* Jarak antar card saat cetak */
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
            <span class="navbar-brand text-white fw-bold m-0">LAPORAN TRANSAKSI</span>
        </div>
    </nav>

    <div class="container py-3">


        <div class="d-flex justify-content-between align-items-right mb-3 no-print">


            <button id="printBtn" class="btn btn-primary">
                <i class="bi bi-printer me-1"></i> Cetak Laporan
            </button>
        </div>

        <hr class="my-2 no-print">

        <h5 class="card-title mb-2">Daftar Transaksi</h5>
        <small>Dari Tanggal <?= $tanggalMulai; ?> sampai <?= $tanggalSelesai; ?> </small>

        <hr class="my-3 no-print">

        <div id="transaksiList">

            <?php

            $no = 1;
            $grant_total = 0;
            foreach ($trxs as $key => $trx) {

            ?>


                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">No : <?= $no; ?> || ID Transaksi: TRX-<?= $trx->id_transaksi; ?></h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-1"><strong>Tanggal:</strong> <?= $trx->tanggal_transaksi; ?></p>
                        <p class="card-text mb-1"><strong>Sopir:</strong> <?= $trx->nama_lengkap; ?></p>
                        <p class="card-text mb-1"><strong>Material:</strong> <?= $trx->tanggal_transaksi; ?></p>
                        <p class="card-text mb-1"><strong>Jumlah Ritase:</strong> <?= $trx->jumlah_ritase; ?></p>
                        <p class="card-text mb-1"><strong>Harga Per Ritase:</strong> <?= number_format($trx->harga_per_unit); ?></p>
                        <p class="card-text mb-1"><strong>Total Harga:</strong> <?= number_format($trx->total_harga); ?></p>
                        <p class="card-text mb-0"><strong>Tujuan:</strong> <?= $trx->tujuan_pengangkutan;; ?></p>
                    </div>
                </div>

            <?php
                $no++;
                $grant_total = $grant_total + $trx->total_harga;
            }; ?>


        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Total Penjualan:</h5>
                <h5 class="mb-0 text-success">Rp <?= number_format($grant_total); ?></h5>
            </div>
        </div>
    </div>

    <!-- <div class="fixed-bottom bg-white p-3 shadow-lg d-flex justify-content-center no-print">
        <div class="container-fluid text-center" style="max-width: 540px;">
            Versi 0.1
        </div>
    </div> -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mengisi tanggal hari ini secara otomatis untuk filter "Tanggal Selesai"
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            $('#tanggalSelesai').val(formattedDate);

            // Set tanggal mulai default (misal: 7 hari yang lalu)
            const sevenDaysAgo = new Date();
            sevenDaysAgo.setDate(today.getDate() - 7);
            const formattedSevenDaysAgo = `${sevenDaysAgo.getFullYear()}-${String(sevenDaysAgo.getMonth() + 1).padStart(2, '0')}-${String(sevenDaysAgo.getDate()).padStart(2, '0')}`;
            $('#tanggalMulai').val(formattedSevenDaysAgo);


            // Fungsi untuk mencetak laporan
            $('#printBtn').on('click', function() {
                window.print();
            });

            // Handle submit form filter (contoh, Anda perlu mengimplementasikan logika backend)
            $('#filterForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form dari submit secara default

                const tanggalMulai = $('#tanggalMulai').val();
                const tanggalSelesai = $('#tanggalSelesai').val();

                alert('Filter diklik!\nDari: ' + tanggalMulai + '\nSampai: ' + tanggalSelesai + '\n(Fungsionalitas pengambilan data dari server perlu diimplementasikan)');

                // Di sini Anda akan memanggil fungsi di controller CI Anda
                // untuk mengambil data transaksi berdasarkan tanggalMulai dan tanggalSelesai.
                // Contoh dengan AJAX untuk memperbarui tampilan tanpa reload halaman:
                /*
                $.ajax({
                    url: '<?= base_url("laporan/get_transaksi_ajax"); ?>', // Ganti dengan URL AJAX Anda
                    method: 'GET',
                    data: { tanggalMulai: tanggalMulai, tanggalSelesai: tanggalSelesai },
                    dataType: 'json', // Harapkan balasan JSON
                    success: function(response) {
                        $('#transaksiList').empty(); // Bersihkan daftar yang ada
                        let totalHargaKeseluruhan = 0;

                        if (response.data && response.data.length > 0) {
                            response.data.forEach(function(transaksi) {
                                totalHargaKeseluruhan += parseFloat(transaksi.harga_penjualan);
                                $('#transaksiList').append(`
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-bold">ID Transaksi: ${transaksi.id_transaksi}</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text mb-1"><strong>Tanggal:</strong> ${new Date(transaksi.tanggal_transaksi).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}</p>
                                            <p class="card-text mb-1"><strong>Sopir:</strong> ${transaksi.nama_sopir}</p>
                                            <p class="card-text mb-1"><strong>Material:</strong> ${transaksi.jenis_material}</p>
                                            <p class="card-text mb-1"><strong>Harga:</strong> Rp ${parseFloat(transaksi.harga_penjualan).toLocaleString('id-ID')}</p>
                                            <p class="card-text mb-0"><strong>Tujuan:</strong> ${transaksi.tujuan_pengangkutan}</p>
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            $('#transaksiList').append('<p class="text-center text-muted">Tidak ada transaksi ditemukan untuk periode ini.</p>');
                        }
                        // Update total penjualan di footer
                        $('.card.shadow-sm.mt-4 .text-success').text(`Rp ${totalHargaKeseluruhan.toLocaleString('id-ID')}`);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                        alert("Gagal memuat data laporan.");
                    }
                });
                */
            });
        });
    </script>
</body>

</html>