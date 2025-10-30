<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Admin_Controller.php';


class Penjualan extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memuat model untuk berinteraksi dengan database
        // Anda perlu membuat model ini terlebih dahulu (misalnya Financial_model)
        // $this->load->model('M_financial');
        $this->load->model('M_transaksi', 'trx');
        // $this->load->library('form_validation'); // Memuat library validasi form
    }


    public function batal_form()
    {
        // Mengambil semua data akun pengeluaran dari model
        $data["judul"] = "Form Pembatalan Penjualan Material";
        // $data['accounts'] = $this->M_financial->get_income_accounts();
        $data["page"] = "get_param";

        $this->load->view('admin/batal_form', $data);
    }

    public function batal_ambildata()
    {
        // Mengambil semua data akun pengeluaran dari model
        $data["judul"] = "Form Pembatalan Penjualan Material";

        $id =  $this->input->post('idtrx');
        // print_r($_REQUEST);
        // return;

        $sql = " 
                SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where a.id_transaksi = '$id'
            ";

        // echo $sql;
        // return;

        $data['data_trx'] = $this->db->query($sql)->result();


        $data["page"] = "respons";


        $this->load->view('admin/batal_form', $data);
    }

    public function batal_prosesdata()
    {


        // Memuat model yang telah dibuat
        // $this->load->model('Transaksi_model');

        // Mengambil ID transaksi dari form, menggunakan metode post
        $id =  $this->input->post('idtrx');

        // Memastikan id_transaksi tidak kosong sebelum memproses
        if (!empty($id)) {
            // Panggil metode 'batal_transaksi' dari model
            $result = $this->trx->batal_transaksi($id);

            if ($result) {
                // Jika proses di model berhasil
                $data['message'] = "Transaksi dengan ID " . $id . " berhasil dibatalkan.";
            } else {
                // Jika proses di model gagal
                $data['message'] = "Proses pembatalan transaksi gagal.";
            }
        } else {
            $data['message'] = "ID transaksi tidak ditemukan.";
        }

        // Menampilkan view dan mengirimkan pesan status
        redirect("admin/Penjualan/batal_form");
        // $this->load->view('admin/batal_form', $data);
    }
}
