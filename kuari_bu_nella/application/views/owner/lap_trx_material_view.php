<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* CSS untuk print, tidak bisa diganti dengan kelas Bootstrap */
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
            <div class="card-body">
                <h5 class="card-title mb-2">Laporan Penjualan Material</h5>
                <p class="card-text text-muted mb-4">Menampilkan rekapitulasi penjualan material berdasarkan periode waktu.</p>
                <hr class="my-3">

                <div class="mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger" onclick="printReport()"><i class="bi bi-printer me-2"></i> Cetak Laporan</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="laporanPenjualanMaterial">
                        <thead class="table-primary">
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
        function exportExcel() {
            alert('Fitur Ekspor Excel akan dikembangkan. Mohon tunggu.');
        }

        function printReport() {
            $('body').addClass('no-print');
            window.print();
            $('body').removeClass('no-print');
        }

        function toggleSidebar() {
            $('#sidebar').toggleClass('collapsed');
            $('.overlay').toggleClass('active');
        }

        $(document).ready(function() {
            $('#materialFilter').select2({
                placeholder: "Pilih Material",
                allowClear: true,
                theme: "bootstrap-5"
            });

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