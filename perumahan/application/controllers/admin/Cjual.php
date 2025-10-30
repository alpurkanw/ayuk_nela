<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Cjual extends MY_Admin_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_trx_penj_rumah', 'trx_rumah');
        // // $this->load->model('M_pengeluaran', 'out');
        // $this->load->model('M_rumah', 'rmh');
        // $this->load->model('M_harga_rumah', 'hrg');
    }


    public function index()
    {
        $data["judul"] = "Transaksi Penjualan";
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $data["ketegs"] = $this->db->get('tm_jns_harga')->result();


        $this->load->view('admin/trx_jual_rmh_form', $data);
    }



    public function trx_jual_rmh_proses()
    {
        $rumah = explode("|", $this->input->post('norumah'));
        $perumahan = explode("|", $this->input->post('id_perumahan'));
        $nama_cust     = $this->input->post('nama_cust'); // ID Kategori Pengeluaran
        $noktp     = $this->input->post('noktp'); // ID Kategori Pengeluaran
        $notelp      = $this->input->post('notelp'); // Sudah dibersihkan dari format ribuan oleh jQuery sebelum submit
        $alamat      = $this->input->post('alamat'); // Sudah dibersihkan dari format ribuan oleh jQuery sebelum submit
        $keterangan   = $this->input->post('keterangan');

        $data_transaksi = array(
            'id_perum'       => $perumahan[0],
            'nama_perum'       => $perumahan[1],
            'id_rumah'       => $rumah[0],
            'norumah'       => $rumah[1],
            'nama_cust'       => $nama_cust,
            'no_ktp'       => $noktp,
            'notelp'       => $notelp,
            'alamat'       => $alamat,
            'tanggal'        => date('Ymd'), // Menggunakan tanggal hari ini
            'keterangan'     => $keterangan
        );

        // 3. Simpan data ke Model (Asumsi fungsi Model adalah addTrx)
        $insert = $this->trx_rumah->insertTrx($data_transaksi);

        // 4. Beri notifikasi dan redirect
        if ($insert) {



            // Set flashdata dengan pesan yang sudah ditentukan

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success">Transaksi Penjualan Berhasil Diinput </div>'
            );
            // $this->session->set_flashdata('pesan', $pesan_html);

            // Lanjutkan ke redirect atau proses selanjutnya
            // redirect('halaman_tujuan');


        } else {
            // Gagal menyimpan
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger">Terjadi Penjualan Gagal Diinput !!! </div>'
            );
        }

        // Redirect kembali ke form pengeluaran (atau ke halaman list transaksi)
        redirect('admin/Cjual');
    }
}
