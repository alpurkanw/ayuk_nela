<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Admin_Controller.php';


class Charga extends MY_Admin_Controller

{
    public function __construct()
    {
        parent::__construct();
        // Memuat model M_account untuk berinteraksi dengan tabel 'accounts'
        $this->load->model('M_trx_penj_rumah_harga', 'hrg');
        $this->load->model('M_perumahan', 'perum');
        $this->load->model('M_jns_harga', 'jns_hrg');

        // $this->load->model('M_harga_rumah', 'hrg_rmh');

        // // Memuat library yang dibutuhkan
        $this->load->library('form_validation');
        // $this->load->library('session');
        // print_r($_SESSION);
        // return;
    }


    public function index()
    {
        // $data['account_list'] = $this->M_account->getAllAccounts();
        // $data['title'] = 'Manajemen Akun Keuangan';
        // echo "tes";
        // return;
        $data["judul"] = "List Harga-Harga";
        $data["list_harga"] = $this->jns_hrg->getAllJns_harga()->result_array();
        // print_r($data["list_harga"]);
        // return;
        $this->load->view('admin/harga_list', $data);
    }




    public function add_harga()
    {

        $data["judul"] = "Tambah Kategori Harga";

        $this->load->view('admin/harga_tambah', $data);
    }


    public function add_harga_proses()
    {



        // Set aturan validasi untuk input form
        $this->form_validation->set_rules('kategori', 'Jenis Kategori', 'required|is_unique[tm_jns_harga.jenis]');


        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
            $this->session->set_flashdata('pesan', validation_errors());
        } else {
            // Jika validasi berhasil, siapkan data untuk disimpan
            $data = [
                'jenis' => $this->input->post('kategori'),
            ];

            $insert = $this->jns_hrg->addKategori($data);

            if ($insert) {
                // $this->session->set_flashdata('pesan', 'Akun berhasil ditambahkan!');
                $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil ditambahkan!</div>');
            }
        }
        redirect('admin/Charga/add_harga');
    }
}
