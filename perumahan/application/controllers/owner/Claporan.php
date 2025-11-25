<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Owner_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/owner/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Claporan extends MY_Owner_Controller

{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_rumah', 'rmh'); // <-- baris penting ini
        $this->load->model('M_transaksi', 'trx'); // <-- baris penting ini
        $this->load->model('M_trx_penj_rumah_harga', 'hrg_rmh'); // <-- baris penting ini
        // $this->load->model('M_financial'); // <-- baris penting ini
    }

    public function lap_out_rumah_per_perum_form()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('owner/lap_out_rumah_per_perum_form', $data);
    }

    public function lap_out_rumah_per_perum_view()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        $id_perum = $this->input->post('id_perumahan');

        $data['list_rumah'] = $this->trx->get_nom_out_rumah_per_perum($id_perum)->result();
        $this->load->view('owner/lap_out_rumah_per_perum_view', $data);
    }


    public function lap_out_umum_per_perum_form()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('owner/lap_out_umum_per_perum_form', $data);
    }

    public function lap_out_umum_per_perum_view()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        $id_perum = $this->input->post('id_perumahan');

        $data['list_rumah'] = $this->trx->get_nom_out_umum_per_perum($id_perum)->result();
        $this->load->view('owner/lap_out_umum_per_perum_view', $data);
    }


    public function lap_st_rumah_per_perum_form()
    {
        $data["judul"] = "Laporan Penjualan Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('owner/lap_st_rumah_per_perum_form', $data);
    }
    public function lap_st_rumah_per_perum_view()
    {
        $data["judul"] = "Laporan Penjualan Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $id_perum = $this->input->post('id_perumahan');


        $data['list_rumah'] = $this->rmh->get_st_rumah_by_perum($id_perum)->result();
        $this->load->view('owner/lap_st_rumah_per_perum_view', $data);
    }


    public function lap_hutang_cust_form()
    {
        $data["judul"] = "Laporan Hutang Customer";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('owner/lap_hutang_cust_form', $data);
    }
    public function lap_hutang_cust_view()
    {
        $data["judul"] = "Laporan Hutang Customer";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $id_perum = $this->input->post('id_perumahan');


        $data['list_rumah'] = $this->hrg_rmh->get_hutang_cust_per_perum($id_perum)->result();
        $this->load->view('owner/lap_hutang_cust_view', $data);
    }


    //     SELECT * FROM trx_penj_rumah_harga a
    // LEFT JOIN trx_penj_rumah b on b.id = a.id_penj_rumah and b.id_perum = 1 
    // where nominal > terbayar

    // public function lap_status_rumah_per_perum()
    // {

    // }

}
