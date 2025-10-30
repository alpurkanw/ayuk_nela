<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Satgas_Controller.php';

class Home extends MY_Satgas_Controller
{


    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Menu_model'); // <-- baris penting ini
    }



    public function index()
    {
        // echo "tes Home";
        // return;
        // $data['menus'] = $this->Menu_model->get_all();
        $this->load->view('satgas/home');
    }

    public function checkout()
    {
        $cart = $this->input->post('cart');
        // Proses simpan ke database, dsb.
        echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil']);
    }
}
