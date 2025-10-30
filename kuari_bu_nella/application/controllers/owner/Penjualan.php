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
        $this->load->model('M_financial');
        $this->load->library('form_validation'); // Memuat library validasi form
    }


    public function batal_form()
    {
        // Mengambil semua data akun pengeluaran dari model
        $data["judul"] = "Form Pembatalan Penjualan Material";
        // $data['accounts'] = $this->M_financial->get_income_accounts();


        $this->load->view('owner/batal_form', $data);
    }

    // public function uangKeluar()
    // {
    //     // Mengambil semua data akun pengeluaran dari model
    //     $data['accounts'] = $this->M_financial->get_expense_accounts();

    //     // Menampilkan form untuk input uang keluar dan mengirimkan data akun
    //     $this->load->view('owner/trx_uang_keluar', $data);
    // }
}
