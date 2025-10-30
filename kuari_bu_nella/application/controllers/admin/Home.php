<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Home extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Logika otentikasi dari MY_Admin_Controller akan dieksekusi di sini.
    }

    public function index()
    {
        $today = date('Y-m-d');

        // uang masuk dan keluar
        $sql = " select * from (
                    SELECT 1 as jenis,  count(*) as jum_trx, sum(jumlah) as jum_nominal from transaksi a
                    LEFT JOIN accounts b on a.jenis = b.no_account
                    where (tanggal BETWEEN '$today' and '$today' ) and b.category = 'Pemasukan' 
                    UNION ALL
                    SELECT 2 as jenis,  count(*) as jum_trx, sum(jumlah) as jum_nominal from transaksi a
                    LEFT JOIN accounts b on a.jenis = b.no_account
                    where (tanggal BETWEEN '$today' and '$today' ) and b.category = 'Pengeluaran' ) x order by jenis
                ";

        $data["trx_inout"] =  $this->db->query($sql)->result();

        $sql = " SELECT a.id_material, b.nama_material, sum(jumlah_ritase)  jumlah FROM `transaksi_penjualan_material` a
                    left join materials b on b.id_material= a.id_material
                    GROUP BY id_material ORDER BY sum(jumlah_ritase) DESC;
                ";

        $data["material_terlaris"] =  $this->db->query($sql)->result();

        // 5 transaksi terakhir
        $sql = " 
                SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                order by a.created_at desc limit 5
            ";
        $data["trx_mtrls"] =  $this->db->query($sql)->result();

        // jumlah transaksi material hari ini 
        $sql = " 
            SELECT count(*) as jum_trx, sum(total_harga) as jumlah_total_today from transaksi_penjualan_material a
            where tanggal_transaksi = '$today' 
        ";
        $data["jumlah_total_today"] =  $this->db->query($sql)->result();

        $this->load->view('admin/home', $data);
    }
}
