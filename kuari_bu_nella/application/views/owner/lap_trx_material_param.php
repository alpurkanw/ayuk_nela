<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Gaya untuk cetak */
        @media print {
            .no-print {
                display: none !important;
            }

            .card.shadow-sm {
                box-shadow: none !important;
                border: none !important;
            }

            table {
                font-size: 10pt;
            }
        }
    </style>
</head>

<body>

    <div class="overlay no-print" onclick="toggleSidebar()"></div>

    <?php $this->load->view('owner/side_menu'); ?>

    <div id="content" class="flex-grow-1 bg-light overflow-auto p-2">

        <div class="card m-2 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-2">Laporan Penjualan Material</h5>
                <p class="card-text mb-4">Menampilkan rekapitulasi penjualan material berdasarkan periode waktu.</p>
            </div>
            <div class="card-body">
                <form action="<?= base_url('owner/Laporan/lapMaterial_view'); ?>" method="post" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4 col-lg-3">
                            <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggalMulai" name="start_date" value="<?= isset($start_date) ? $start_date : date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggalSelesai" name="end_date" value="<?= isset($end_date) ? $end_date : date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <label for="materialFilter" class="form-label">Filter Material (Opsional)</label>
                            <select class="form-select" id="materialFilter" name="material_id">
                                <option value="0">Semua Material</option>
                                <?php if (!empty($materials)) : ?>
                                    <?php foreach ($materials as $mtr) : ?>
                                        <option value="<?= $mtr["id_material"]; ?>"><?= $mtr["nama_material"]; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-12 col-lg-3 d-flex justify-content-lg-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="bi bi-funnel me-2"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function exportExcel() {
            alert('Fitur Ekspor Excel akan dikembangkan. Mohon tunggu.');
        }

        function printReport() {
            $('body').addClass('no-print');
            window.print();
            $('body').removeClass('no-print');
        }

        // Asumsi fungsi toggleSidebar() ada di file side_menu atau script terpisah
        function toggleSidebar() {
            $('#sidebar').toggleClass('show');
            $('.overlay').toggleClass('active');
        }

        $(document).ready(function() {
            // Inisialisasi Select2 (jika digunakan)
            // $('#materialFilter').select2({
            //     placeholder: "Pilih Material",
            //     allowClear: true,
            //     theme: "bootstrap-5"
            // });

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