<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Satgas_Controller.php';

class Laporan extends MY_Satgas_Controller
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
        $this->load->view('satgas/lap_trx_param');
    }
    public function retriev_trx()
    {
        // return;
        // print_r($_POST);
        // return;

        $tanggalMulai =  trim($this->input->post("tanggalMulai"));
        $tanggalSelesai =  trim($this->input->post("tanggalSelesai"));

        // $petugas = $_SESSION["usernm"];

        $sql = " 
                SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where tanggal_transaksi between '$tanggalMulai' and '$tanggalSelesai' 
            ";



        // echo $sql;
        // return;
        $data["trxs"] =  $this->db->query($sql)->result();

        $data["tanggalMulai"] = $tanggalMulai;
        $data["tanggalSelesai"] = $tanggalSelesai;
        $this->load->view('satgas/list_transaksi', $data);
    }
}
