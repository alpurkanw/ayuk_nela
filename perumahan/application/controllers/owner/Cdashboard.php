<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Owner_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Cdashboard extends MY_Owner_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Logika otentikasi dari MY_Admin_Controller akan dieksekusi di sini.

        $this->load->model('M_perumahan', 'perum');
    }

    public function akupansi()
    {
        // $today = date('Y-m-d');

        $data["judul"] = "Akupansi Perumahan";
        // $data["list_perum"] = $this->perum->getAllperum();



        // ($this->input->post("tanggal") !== null) ? $today = $this->input->post("tanggal") : $today = date('Y-m-d');
        // $bulan = substr($today, 0, 7);
        // uang masuk dan keluar
        $sql = " select nama, jum_terjual, jum_rumah, (jum_terjual / jum_rumah) *100 as persen from (
                    SELECT nama , (select count(1) from trx_penj_rumah where id_perum = a.id ) as jum_terjual, (select count(1) from tm_rumah where id_perumahan = a.id) as jum_rumah FROM `tm_perumahan` a ) x
                ";

        $data["akupansi"] =  $this->db->query($sql)->result_array();



        $this->load->view('owner/dsh_akunpansi', $data);
    }

    public function cost_param()
    {
        // $today = date('Y-m-d');

        $data["judul"] = "{";
        $tahun  = date('Y');
        // $data["list_perum"] = $this->perum->getAllperum();
        $sql = " SELECT nama_perum, sum(nominal) as jum FROM `trx_transaksi`where tipe_transaksi = 'keluar' and left(tanggal,4) = $tahun GROUP BY id_perum ORDER BY jum DESC ";

        $data["akupansi"] =  $this->db->query($sql)->result_array();



        $this->load->view('owner/dsh_akunpansi', $data);
    }
    public function cost_view()
    {
        // $today = date('Y-m-d');

        $data["judul"] = "Akupansi Perumahan";
        $tahun  = date('Y');
        // $data["list_perum"] = $this->perum->getAllperum();
        $sql = " SELECT nama_perum, sum(nominal) as jum FROM `trx_transaksi`where tipe_transaksi = 'keluar' and left(tanggal,4) = $tahun GROUP BY id_perum ORDER BY jum DESC ";

        $data["akupansi"] =  $this->db->query($sql)->result_array();



        $this->load->view('owner/dsh_akunpansi', $data);
    }
    // public function cost_perumahan()
    // {
    //     // $today = date('Y-m-d');

    //     $data["judul"] = "Akupansi Perumahan";
    //     $tahun  = date('Y');
    //     // $data["list_perum"] = $this->perum->getAllperum();
    //     $sql = " SELECT nama_perum, sum(nominal) as jum FROM `trx_transaksi`where tipe_transaksi = 'keluar' and left(tanggal,4) = $tahun GROUP BY id_perum ORDER BY jum DESC ";

    //     $data["akupansi"] =  $this->db->query($sql)->result_array();



    //     $this->load->view('owner/dsh_akunpansi', $data);
    // }
}
