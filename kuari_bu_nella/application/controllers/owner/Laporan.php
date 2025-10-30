<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Owner_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/owner/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Laporan extends MY_Owner_Controller

{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_material'); // <-- baris penting ini
        $this->load->model('M_sopir'); // <-- baris penting ini
        $this->load->model('M_financial'); // <-- baris penting ini
    }




    public function lapMaterial()
    {
        // echo "tes Home";
        // return;
        // $data['menus'] = $this->Menu_model->get_all();
        $data['materials'] = $this->M_material->getAllMaterials();
        $this->load->view('owner/lap_trx_material_param', $data);
    }


    public function lapMaterial_view()
    {
        // print_r($_POST);
        // return;
        // Array ( [start_date] => 2025-08-07 [end_date] => 2025-08-07 [material_id] => 0 )

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $mtrl_id = $this->input->post('material_id');
        // echo "tes " . $mtrl_id;

        // where tanggal_transaksi between '$start_date' and '$end_date' 

        if ($mtrl_id == '0') {

            $sql = " 
                SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where tanggal_transaksi between '$start_date' and '$end_date' 
            ";
        } else {

            $sql = " 
               SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where tanggal_transaksi between '$start_date' and '$end_date' and a.id_material = '$mtrl_id' 
            ";
        }

        // echo $sql;
        // return;
        $data["trx_mtrls"] =  $this->db->query($sql)->result();

        // print_r($data);

        // $data['menus'] = $this->Menu_model->get_all();
        $this->load->view('owner/lap_trx_material_view', $data);
    }

    public function lapMaterialperSopir()
    {
        // echo "tes Home";
        // return;
        // $data['menus'] = $this->Menu_model->get_all();
        $data['sopirs'] = $this->M_sopir->get_all_sopir();
        $this->load->view('owner/lap_trx_material_persopir_param', $data);
    }




    public function lapMaterialperSopir_view()
    {
        // print_r($_POST);
        // return;
        // Array ( [start_date] => 2025-08-07 [end_date] => 2025-08-07 [id_sopir] => 2 )


        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $id_sopir = $this->input->post('id_sopir');
        // echo "tes " . $id_sopir;

        if ($id_sopir == '0') {

            $sql = " 
                SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where tanggal_transaksi between '$start_date' and '$end_date' 
            ";
        } else {

            $sql = " 
               SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where tanggal_transaksi between '$start_date' and '$end_date' and a.id_sopir = '$id_sopir' 
            ";
        }


        // echo $sql;
        // return;
        $data["trx_mtrls"] =  $this->db->query($sql)->result();

        // print_r($data);

        // $data['menus'] = $this->Menu_model->get_all();
        $this->load->view('owner/lap_trx_material_persopir_view', $data);
    }

    public function lap_uang_masuk()
    {
        // echo "tes Home";
        // return;
        // $data['menus'] = $this->Menu_model->get_all();
        $data['accounts'] = $this->M_financial->get_income_accounts();
        $this->load->view('owner/lap_trx_uangmasuk_param', $data);
    }

    public function lap_uang_masuk_view()
    {

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $kategori_id = $this->input->post('kategori_id');
        // echo "tes " . $id_sopir;

        if ($kategori_id == '0') {
            $sql = " 
                SELECT * from transaksi a
                LEFT JOIN accounts b on a.jenis = b.no_account
                where (tanggal between '$start_date' and '$end_date') and b.category = 'Pemasukan' order by tanggal
             ";
        } else {

            $sql = " 
                SELECT * from transaksi a
                LEFT JOIN accounts b on a.jenis = b.no_account
                where tanggal between '$start_date' and '$end_date' and a.jenis = '$kategori_id' order by tanggal
            ";
        }

        $data["kategori_id"] = $kategori_id;
        $data["trx_mtrls"] =  $this->db->query($sql)->result();

        $this->load->view('owner/lap_trx_uangmasuk_view', $data);
    }




    public function lap_uang_keluar()
    {
        // echo "tes Home";
        // return;
        // $data['menus'] = $this->Menu_model->get_all();
        // Mengambil semua data akun pengeluaran dari model
        $data['accounts'] = $this->M_financial->get_expense_accounts();

        // $data['materials'] = $this->M_material->getAllMaterials();
        $this->load->view('owner/lap_trx_uangkeluar_param', $data);
    }

    public function lap_uang_keluar_view()
    {
        // print_r($_POST);
        // return;
        // Array ( [start_date] => 2025-08-07 [end_date] => 2025-08-07 [id_sopir] => 2 )


        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $kategori_id = $this->input->post('kategori_id');
        // echo "tes " . $id_sopir;

        if ($kategori_id == '0') {

            $sql = " 
                SELECT * from transaksi a
                LEFT JOIN accounts b on a.jenis = b.no_account
                where (tanggal between '$start_date' and '$end_date') and b.category = 'Pengeluaran' order by tanggal
            ";
        } else {

            $sql = " 
               SELECT * from transaksi a
                LEFT JOIN accounts b on a.jenis = b.no_account
                where tanggal between '$start_date' and '$end_date' and a.jenis = '$kategori_id' order by tanggal
            ";
        }

        $data["kategori_id"] = $kategori_id;

        // echo $sql;
        // return;
        $data["trx_mtrls"] =  $this->db->query($sql)->result();

        // print_r($data);

        // $data['menus'] = $this->Menu_model->get_all();
        $this->load->view('owner/lap_trx_uangkeluar_view', $data);
    }



    public function harian()
    {
        $this->load->view('owner/lap_resume_harian_param');
    }

    public function harian_view()
    {
        // print_r($_POST);
        // return;

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $data["start_date"] = $start_date;
        $data["end_date"] = $end_date;

        //ambbil transaksi material 
        $sql = " 
        SELECT 'Transaksi Penjualan Material' as ket, count(*) as jum_trx, sum(total_harga) jum_nominal FROM `transaksi_penjualan_material` 
                where tanggal_transaksi BETWEEN '$start_date' and '$end_date' 
                UNION ALL
                SELECT  description_account as ket, count(*) as jum_trx, sum(jumlah) as jum_nominal from transaksi a
                LEFT JOIN accounts b on a.jenis = b.no_account
                where (tanggal BETWEEN '$start_date' and '$end_date' ) and b.category = 'Pemasukan' GROUP BY no_account, description_account 
            ";

        $data["trx_uangmasuk"] =  $this->db->query($sql)->result();

        $sql = " 
                SELECT  description_account as ket, count(*) as jum_trx, sum(jumlah) as jum_nominal from transaksi a
                LEFT JOIN accounts b on a.jenis = b.no_account
                where (tanggal BETWEEN '$start_date' and '$end_date' ) and b.category = 'Pengeluaran' GROUP BY no_account, description_account 
            ";

        $data["trx_uangkeluar"] =  $this->db->query($sql)->result();


        $data["kategori_id"] = "";

        // // echo $sql;
        // // return;
        // $data["trx_mtrls"] =  $this->db->query($sql)->result();

        $this->load->view('owner/lap_resume_harian_view', $data);
    }
}
