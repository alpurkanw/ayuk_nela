<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            /* Menggunakan flexbox untuk tata letak utama */
            min-height: 100vh;
            /* Pastikan body mengambil tinggi penuh viewport */
        }

        #sidebar {
            width: 250px;
            /* Lebar sidebar default */
            flex-shrink: 0;
            /* Jangan biarkan sidebar menyusut */
            background-color: #343a40;
            /* Warna gelap untuk sidebar */
            color: white;
            transition: all 0.3s;
            /* Transisi untuk efek buka/tutup */
            overflow-y: auto;
            /* Scroll jika konten sidebar terlalu panjang */
        }

        #sidebar.collapsed {
            margin-left: -250px;
            /* Sembunyikan sidebar ke kiri */
        }

        #content {
            flex-grow: 1;
            /* Konten utama mengambil sisa ruang */
            padding: 20px;
            background-color: #f8f9fa;
            /* Warna background konten */
            overflow-y: auto;
            /* Scroll jika konten utama terlalu panjang */
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #495057;
            text-align: center;
        }

        .sidebar-menu .nav-link {
            color: #adb5bd;
            /* Warna teks menu */
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: #495057;
            /* Warna hover/aktif */
        }

        .sidebar-menu .nav-link i {
            margin-right: 10px;
        }

        .sidebar-submenu .nav-link {
            padding-left: 40px;
            /* Indentasi submenu */
            font-size: 0.9em;
        }

        .navbar-toggler {
            display: none;
            /* Sembunyikan toggler di desktop */
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 767.98px) {
            #sidebar {
                position: fixed;
                /* Sidebar tetap di tempatnya */
                height: 100vh;
                z-index: 1030;
                /* Di atas konten */
                margin-left: -250px;
                /* Awalnya tersembunyi */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }

            #sidebar.collapsed {
                margin-left: 0;
                /* Tampilkan sidebar */
            }

            #content {
                width: 100%;
                /* Konten mengambil lebar penuh */
            }

            .navbar-toggler {
                display: block;
                /* Tampilkan toggler di HP */
            }

            .overlay {
                /* Overlay saat sidebar terbuka di HP */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1029;
                display: none;
            }

            .overlay.active {
                display: block;
            }
        }

        @media print {
            body.no-print #sidebar,
            body.no-print .navbar-toggler,
            body.no-print .no-print,
            body.no-print .d-flex.justify-content-end,
            /* Tombol ekspor/cetak */
            body.no-print .card-body>form,
            /* Form filter */
            body.no-print .d-flex.justify-content-center.mt-3

            /* Pagination */
                {
                display: none !important;
            }

            body.no-print #content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0;
                overflow: visible !important;
            }

            body.no-print .card.shadow-sm {
                box-shadow: none !important;
                border: none !important;
            }

            /* Atur ukuran font atau margin untuk print */
            body.no-print table {
                font-size: 10pt;
            }
        }
    </style>

</head>

<body>
    <div class="overlay" onclick="toggleSidebar()"></div>

    <?php $this->load->view('admin/side_menu'); ?>

    <div id="content m-2">

        <div class="card m-2 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-2">Laporan Penjualan Material Per Sopir</h5>
                <p class="card-text text-muted mb-4">Menampilkan rekapitulasi penjualan material berdasarkan periode waktu.</p>
                <hr class="my-3">

                <div class="mb-3 d-flex justify-content-end">
                    <!-- <button type="button" class="btn btn-success me-2"><i class="bi bi-file-earmark-excel me-2"></i> Kembali</button> -->
                    <button type="button" class="btn btn-danger" onclick="printReport()"><i class="bi bi-printer me-2"></i> Cetak Laporan</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="laporanPenjualanMaterial">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Sopir</th>
                                <th>Material</th>
                                <th>Jumlah (unit/kubik)</th>
                                <th>Harga Satuan (Rp)</th>
                                <th>Total Harga (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // print_r($trx_mtrls); 
                            ?>
                            <?php if (!empty($trx_mtrls)) : ?>
                                <?php $no = 1; ?>
                                <?php $grand_total = 0; ?>
                                <?php foreach ($trx_mtrls as $data) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= "TRX-" . htmlspecialchars($data->id_transaksi); ?></td>
                                        <td><?= date('d-m-Y', strtotime($data->tanggal_transaksi)); ?></td>
                                        <td><?= htmlspecialchars($data->nama_lengkap); ?></td>
                                        <td><?= htmlspecialchars($data->nama_material); ?></td>
                                        <td class="text-end"><?= htmlspecialchars($data->jumlah_ritase); ?></td>
                                        <td class="text-end"><?= number_format($data->harga_per_unit, 0, ',', '.'); ?></td>
                                        <td class="text-end"><?= number_format($data->total_harga, 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php $grand_total += $data->total_harga; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Tidak ada data penjualan material untuk periode ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($trx_mtrls)) : ?>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="7" class="text-end">GRAND TOTAL PENJUALAN</th>
                                    <th class="text-end">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
                                </tr>
                            </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
                <?php if (isset($pagination_links)) : ?>
                    <div class="d-flex justify-content-center mt-3">
                        <?= $pagination_links; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>



    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk ekspor Excel (contoh sederhana)
        function exportExcel() {
            // Anda perlu menggunakan library seperti SheetJS (js-xlsx) atau membuat endpoint di backend
            // untuk menghasilkan file Excel. Ini hanya placeholder.
            alert('Fitur Ekspor Excel akan dikembangkan. Mohon tunggu.');
            // Contoh: window.location.href = '<?= base_url('admin/laporan/exportPenjualanMaterialExcel'); ?>' + window.location.search;
        }

        // Fungsi untuk mencetak laporan (membuka dialog print browser)
        function printReport() {
            // Menyembunyikan elemen yang tidak perlu dicetak (misal: sidebar, navbar di HP)
            $('body').addClass('no-print'); // Tambahkan class 'no-print' ke body untuk CSS print
            window.print();
            $('body').removeClass('no-print'); // Hapus kembali setelah mencetak
        }

        $(document).ready(function() {
            // Inisialisasi Select2 untuk filter material (jika material banyak)
            $('#materialFilter').select2({
                placeholder: "Pilih Material",
                allowClear: true,
                theme: "bootstrap-5"
            });

            // Set tanggal default jika belum ada filter
            if ($('#tanggalMulai').val() === '' && $('#tanggalSelesai').val() === '') {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;
                $('#tanggalMulai').val(formattedDate);
                $('#tanggalSelesai').val(formattedDate);
            }
        });
    </script>

</body>

</html>