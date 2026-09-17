<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Berhasil!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .printArea {
            background: white;
            max-width: 410px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media print {
            @page {
                size: 62mm auto;
                margin: 0;
                /* Menghapus margin kertas sistem */
            }

            .no-print,
            nav,
            .btn,
            .row {
                display: none !important;
            }

            body {
                width: 62mm !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white;
                -webkit-print-color-adjust: exact;
            }

            .printArea {
                width: 100% !important;
                /* Memaksa lebar penuh 58mm */
                max-width: 100% !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 1mm !important;
                /* Padding sangat tipis agar tulisan melebar ke pinggir */
                border: none !important;
            }

            /* Reset Font: Tanpa Bold, Monospace */
            .judul,
            .sub-judul,
            td,
            p,
            span {
                font-weight: normal !important;
                font-family: monospace !important;
                color: black !important;
                letter-spacing: 0.2px;
                /* Rapatkan sedikit agar muat teks lebih lebar */
            }

            .judul {
                font-size: 13pt !important;
                text-align: center;
                display: block;
                line-height: 1.1;
                margin-top: 5px;
            }

            .sub-judul {
                font-size: 10pt !important;
                text-align: center;
                display: block;
                margin-bottom: 5px;
            }

            table {
                width: 100% !important;
                /* Tabel wajib 100% dari lebar kertas */
                border-collapse: collapse !important;
                table-layout: fixed;
            }

            td {
                font-size: 11pt !important;
                padding: 3px 0 !important;
                word-wrap: break-word;
            }

            hr {
                border-top: 1px dashed black !important;
                opacity: 1 !important;
                margin: 5px 0 !important;
                width: 100% !important;
            }

            .footer-note {
                font-size: 10pt !important;
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-success px-3 no-print">
        <div class="container-fluid d-flex justify-content-start align-items-center">
            <button class="btn btn-link text-white me-2 p-0" onclick="history.back()">
                <i class="bi bi-arrow-left fs-4"></i>
            </button>
            <span class="navbar-brand text-white fw-bold m-0">TRANSAKSI SUKSES</span>
        </div>
    </nav>

    <div class="row m-2 no-print">
        <div class="col-12 mb-2">
            <button id="printBtn" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-printer me-2"></i> Cetak Struk
            </button>
        </div>
        <div class="col-6">
            <a href="<?= base_url('satgas/Penjualan'); ?>" class="btn btn-outline-success w-100">Input Baru</a>
        </div>
        <div class="col-6">
            <a href="<?= base_url('satgas/Home'); ?>" class="btn btn-outline-success w-100">Menu Utama</a>
        </div>
    </div>

    <div id="strukContent" class="printArea">
        <div class="text-center">
            <div class="no-print">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
            </div>
            <span class="judul">CV BINTANG NATA SEJAHTERA</span>
            <span class="sub-judul">Nota Penjualan Material</span>
        </div>

        <hr>

        <?php $trans = $trx[0]; ?>

        <table>
            <tr>
                <td style="width: 38%;">ID</td>
                <td>: TRX-<?= $trans->id_transaksi; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?= $trans->tanggal_transaksi; ?></td>
            </tr>
            <tr>
                <td>Petugas</td>
                <td>: <?= strtoupper($trans->user_inp); ?></td>
            </tr>
        </table>

        <hr>

        <table>
            <tr>
                <td style="width: 38%;">Sopir</td>
                <td>: <?= strtoupper($trans->nama_lengkap); ?></td>
            </tr>
            <tr>
                <td>Material</td>
                <td>: <?= strtoupper($trans->nama_material); ?></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>: Rp <?= number_format($trans->total_harga); ?></td>
            </tr>
            <tr>
                <td>Tujuan</td>
                <td>: <?= strtoupper($trans->tujuan_pengangkutan); ?></td>
            </tr>
        </table>

        <hr>
        <p class="footer-note mt-2">Terima kasih atas kepercayaan Anda.</p>

        <div style="height: 30px;" class="d-none d-print-block"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#printBtn').on('click', function() {
                window.print();
            });
        });
    </script>
</body>

</html>