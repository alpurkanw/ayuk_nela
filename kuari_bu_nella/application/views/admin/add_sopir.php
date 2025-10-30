<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Penjualan - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="bg-light fs-6">

    <nav class="navbar navbar-expand-lg bg-success px-3">
        <div class="container-fluid d-flex justify-content-start align-items-center">
            <button class="btn btn-link text-white me-2 p-0" onclick="history.back()">
                <i class="bi bi-arrow-left fs-4"></i>
            </button>
            <span class="navbar-brand text-white fw-bold m-0">PENJUALAN</span>
        </div>
    </nav>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-2">Form Pendaftaran Sopir</h5>
                <hr class="my-3">
                <form action="<?= base_url('admin/Sopir/proses_pendaftaran'); ?>" method="post">
                    <div class="mb-3">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" placeholder="Masukkan nama lengkap sopir" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="nomorTelepon" name="nomorTelepon" placeholder="Contoh: 081234567890" pattern="[0-9]{10,15}" title="Masukkan nomor telepon yang valid (10-15 digit angka)" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap sopir" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="nomorSIM" class="form-label">Nomor SIM</label>
                        <input type="text" class="form-control" id="nomorSIM" name="nomorSIM" placeholder="Masukkan nomor SIM" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenisKendaraan" class="form-label">Jenis Kendaraan</label>
                        <select class="form-select" id="jenisKendaraan" name="jenisKendaraan" required>
                            <option value="">Pilih Jenis Kendaraan</option>
                            <option value="Truk Engkel">Truk Engkel</option>
                            <option value="Truk Double">Truk Double</option>
                            <option value="Truk Tronton">Truk Tronton</option>
                            <option value="Pick Up">Pick Up</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftarkan Sopir</button>
                </form>
            </div>
        </div>
    </div>


    <!-- <div class="fixed-bottom bg-white p-3 shadow-lg d-flex justify-content-center">
        <div class="container-fluid text-center" style="max-width: 540px;">
            Versi 0.1
        </div>
    </div> -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>