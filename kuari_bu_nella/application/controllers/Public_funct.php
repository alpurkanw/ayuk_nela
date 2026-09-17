<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Public_funct extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        // echo "auth";
    }


    public function print_nota($id)
    {

        // Halaman ini bisa menampilkan pesan sukses atau daftar transaksi terbaru
        $data['title'] = 'Transaksi Berhasil';


        $sql = " 
                SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where id_transaksi = $id
            ";



        // echo $sql;
        // return;
        $data["trx"] =  $this->db->query($sql)->result();



        $this->load->view('satgas/trx_sukses', $data); // Sesuaikan path view Anda
    }
}
