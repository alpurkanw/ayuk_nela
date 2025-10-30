<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Cbayar extends MY_Admin_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_transaksi', 'trx');
        // $this->load->model('M_pengeluaran', 'out');
        $this->load->model('M_rumah', 'rmh');
        $this->load->model('M_harga_rumah', 'hrg');
    }


    public function trx_bayar_rmh_form()
    {
        $data["judul"] = "TRX Pengeluaran";
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $data["ketegs"] = $this->db->get('tm_jns_harga')->result();


        $this->load->view('admin/trx_bayar_rmh_form', $data);
    }

    public function getHargaRumah()
    {
        $data["harga_rmh"] = $this->rmh->getAllHarga($id_perum, $id_rumah)->result_array();
        $this->load->view('admin/trx_bayar_rmh_form', $data);
    }

    public function get_harga_perrumah()
    {
        $id_perum = $this->input->post('id_perum');
        $id_rumah = $this->input->post('id_rumah');

        // if ($id_perum) {
        // Panggil Model untuk mengambil data rumah

        $harga_rmh = $this->rmh->getAllHarga($id_perum, $id_rumah)->result_array();
        echo json_encode($harga_rmh);
        // } else {
        //     echo json_encode([]);
        // }
    }


    public function trx_bayar_inquery()
    {
        $id_perum = $this->input->post('id_perum');
        $id_rumah     = $this->input->post('id_rumah'); // Nama field di form adalah 'norumah', ini adalah ID unit rumah
        $id_jenis     = $this->input->post('id_jenis');

        // 2. Siapkan data untuk tabel trx_transaksi
        // echo 'tes' . '-' . $id_perumahan . '-' . $id_rumah . '-' . $id_jenis;
        // print_r($_POST);
        // return;

        $harga_rmh = $this->rmh->getAllHargaPerId($id_perum, $id_rumah, $id_jenis)->result_array();

        //ambil yang sudah terbayar


        $pembayaran = $this->trx->getAllTrxPerId($id_perum, $id_rumah, $id_jenis)->result_array();

        $data = array(
            'harga_rumah'       => $harga_rmh,
            'terbayar'       => $pembayaran
        );

        echo json_encode($data);
    }



    public function trx_bayar_rmh_proses()
    {
        // 1. Ambil data dari POST


        $id_perum = $this->input->post('id_perum');
        $nama_perum = $this->input->post('nama_perum');
        $id_rumah     = $this->input->post('id_rumah'); // Nama field di form adalah 'norumah', ini adalah ID unit rumah
        $norumah     = $this->input->post('norumah'); // Nama field di form adalah 'norumah', ini adalah ID unit rumah
        $id_kateg     = $this->input->post('id_kateg'); // ID Kategori Pengeluaran
        $nama_kateg     = $this->input->post('nama_kateg'); // ID Kategori Pengeluaran
        $nominal      = $this->input->post('nominal'); // Sudah dibersihkan dari format ribuan oleh jQuery sebelum submit
        $keterangan   = $this->input->post('keterangan');




        $data_transaksi = array(
            'tipe_transaksi' => 'masuk', // pemasukan
            'id_perum'       => $id_perum,
            'nama_perum'       => $nama_perum,
            'peruntukan'     => 'rumah', // Pemasukan khusus untuk Rumah
            'id_rumah'       => $id_rumah,
            'norumah'       => $norumah,
            'id_kateg'       => $id_kateg,
            'nama_kateg'       => $nama_kateg,
            'tanggal'        => date('Ymd'), // Menggunakan tanggal hari ini
            'keterangan'     => $keterangan,
            'nominal'        => $nominal
        );



        // 3. Simpan data ke Model (Asumsi fungsi Model adalah addTrx)
        $insert = $this->trx->insertTrx($data_transaksi);

        // 4. Beri notifikasi dan redirect
        if ($insert) {
            //update master harga rumah disini 



            // Di dalam Controller Anda

            // Asumsi: $nominal, $id_perum, $id_rumah, dan $id_kateg sudah didefinisikan sebelumnya.

            $update = $this->hrg->update_master_harga($nominal, $id_perum, $id_rumah, $id_kateg);

            // Cek apakah ada baris yang terpengaruh (nilai harus > 0)
            if ($update > 0) {
                // KONDISI SUKSES: Ada baris yang berhasil diupdate
                $pesan_html = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      Transaksi Pengeluaran sebesar **Rp ' . number_format($nominal) . '** berhasil dicatat!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                   </div>';
            } else {
                // KONDISI GAGAL/TIDAK ADA: Tidak ada data yang cocok dengan kriteria WHERE
                $pesan_html = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      Peringatan: Tidak ada data harga rumah yang cocok (ID Perum, ID Rumah, atau Jenis Kategori salah). Data tidak diupdate.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                   </div>';
            }

            // Set flashdata dengan pesan yang sudah ditentukan
            $this->session->set_flashdata('pesan', $pesan_html);

            // Lanjutkan ke redirect atau proses selanjutnya
            // redirect('halaman_tujuan');


        } else {
            // Gagal menyimpan
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger">Terjadi kesalahan database saat mencoba menyimpan Transaksi Pengeluaran.</div>'
            );
        }

        // Redirect kembali ke form pengeluaran (atau ke halaman list transaksi)
        redirect('admin/Cpengeluaran/trx_out_rmh_form');
    }
}
