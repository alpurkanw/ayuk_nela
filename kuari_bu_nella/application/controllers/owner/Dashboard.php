<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Owner_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/owner/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Dashboard extends MY_Owner_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Logika otentikasi dari MY_Admin_Controller akan dieksekusi di sini.
    }

    public function index()
    {

        ($this->input->post("tanggal") !== null) ? $today = $this->input->post("tanggal") : $today = date('Y-m-d');
        $bulan = substr($today, 0, 7);
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
                    where tanggal_transaksi = '$today'
                    GROUP BY id_material ORDER BY sum(jumlah_ritase) DESC;
                ";

        $data["material_terlaris"] =  $this->db->query($sql)->result();

        // donat daftar pengeluaran 
        $sql = " SELECT description_account, sum(jumlah) as jum_nom
                FROM `transaksi` a
                LEFT JOIN accounts b on a.jenis = b.no_account 
                where tanggal = '$today' AND tipe_transaksi = 'keluar'
                GROUP BY description_account ORDER BY sum(jumlah) desc
                ";

        $data["keluar_terbanyak"] =  $this->db->query($sql)->result();


        // jumlah transaksi material hari ini 
        $sql = " 
            SELECT count(*) as jum_trx, sum(total_harga) as jumlah_total_today from transaksi_penjualan_material a
            where tanggal_transaksi = '$today' 
        ";
        $data["jumlah_total_today"] =  $this->db->query($sql)->result();

        // jumlah transaksi per hari dalam 1 bulan 
        $sql = " 
            SELECT tanggal_transaksi,count(*) as jum_trx, sum(total_harga) as jumlah_total_today from transaksi_penjualan_material a
            where left(tanggal_transaksi,7) = '$bulan' group by tanggal_transaksi order by tanggal_transaksi
     ";
        $data["barchart_total"] =  $this->db->query($sql)->result();


        $sql = " 
                    SELECT 
                        tanggal_trx,
                        SUM(CASE WHEN jenis_trx = 'masuk' THEN jum_nom ELSE 0 END) AS nom_masuk,
                        SUM(CASE WHEN jenis_trx = 'keluar' THEN jum_nom ELSE 0 END) AS nom_keluar,
                        SUM(CASE WHEN jenis_trx = 'masuk' THEN jum_nom ELSE 0 END) 
                        - SUM(CASE WHEN jenis_trx = 'keluar' THEN jum_nom ELSE 0 END) AS nom_margin
                    FROM (
                        SELECT tanggal_transaksi AS tanggal_trx, SUM(total_harga) AS jum_nom, 'masuk' AS jenis_trx
                        FROM transaksi_penjualan_material
                        WHERE LEFT(tanggal_transaksi, 7) = '$bulan'
                        GROUP BY tanggal_transaksi

                        UNION ALL

                        SELECT tanggal AS tanggal_trx, SUM(jumlah) AS jum_nom, 'keluar' AS jenis_trx
                        FROM transaksi
                        WHERE LEFT(tanggal, 7) = '$bulan' AND tipe_transaksi = 'keluar'
                        GROUP BY tanggal

                        UNION ALL

                        SELECT tanggal AS tanggal_trx, SUM(jumlah) AS jum_nom, 'masuk' AS jenis_trx
                        FROM transaksi
                        WHERE LEFT(tanggal, 7) = '$bulan' AND tipe_transaksi = 'masuk'
                        GROUP BY tanggal
                    ) x
                    GROUP BY tanggal_trx
                    ORDER BY tanggal_trx;

            ";
        $data["char_total"] =  $this->db->query($sql)->result_array();





        $data["today"] = $today;

        $this->load->view('owner/dashboard', $data);

        // // 5 transaksi terakhir
        // $sql = " 
        //         SELECT * from transaksi_penjualan_material a
        //         LEFT JOIN sopir b on a.id_sopir = b.id_sopir
        //         LEFT JOIN materials c on a.id_material = c.id_material
        //         order by a.created_at desc limit 5
        //     ";
        // $data["trx_mtrls"] =  $this->db->query($sql)->result();



    }


    public function dsh_bulan()
    {

        // print_r($_POST);
        // return;

        ($this->input->post("bulan") !== null) ? $thismonth = $this->input->post("bulan") : $thismonth = date('Y-m');
        $tahun = date('Y');


        // uang masuk dan keluar
        $sql = " select * from (
                    SELECT 1 as jenis,  count(*) as jum_trx, sum(jumlah) as jum_nominal from transaksi a
                    LEFT JOIN accounts b on a.jenis = b.no_account
                    where left(tanggal,7) = '$thismonth'  and b.category = 'Pemasukan' 
                    UNION ALL
                    SELECT 2 as jenis,  count(*) as jum_trx, sum(jumlah) as jum_nominal from transaksi a
                    LEFT JOIN accounts b on a.jenis = b.no_account
                    where left(tanggal,7) = '$thismonth' and b.category = 'Pengeluaran' ) x order by jenis
                ";

        $data["trx_inout"] =  $this->db->query($sql)->result();


        // material Terlaris
        $sql = " SELECT a.id_material, b.nama_material, sum(jumlah_ritase)  jumlah FROM `transaksi_penjualan_material` a
                    left join materials b on b.id_material= a.id_material
                    where left(tanggal_transaksi,7) = '$thismonth'
                    GROUP BY id_material ORDER BY sum(jumlah_ritase) DESC;
                ";
        $data["material_terlaris"] =  $this->db->query($sql)->result();

        // List pengeluaran Terbanyak 
        $sql = " SELECT description_account, sum(jumlah) as jum_nom
                FROM `transaksi` a
                LEFT JOIN accounts b on a.jenis = b.no_account 
                where left(tanggal,7) = '$thismonth' AND tipe_transaksi = 'keluar'
                GROUP BY description_account ORDER BY sum(jumlah) desc
                ";

        $data["keluar_terbanyak"] =  $this->db->query($sql)->result();


        // jumlah transaksi material bulan ini  
        $sql = " 
            SELECT count(*) as jum_trx, sum(total_harga) as jumlah_total_today from transaksi_penjualan_material a
            where left(tanggal_transaksi,7) = '$thismonth' 
        ";
        $data["jumlah_total_today"] =  $this->db->query($sql)->result();



        // jumlah transaksi per bulan dalam 1 bulan 
        $sql = " 
            SELECT tanggal_transaksi,count(*) as jum_trx, sum(total_harga) as jumlah_total_today from transaksi_penjualan_material a
            where left(tanggal_transaksi,7) = '$thismonth' group by tanggal_transaksi order by tanggal_transaksi
     ";
        $data["barchart_total"] =  $this->db->query($sql)->result();


        // transaksi perbulan dalam setahun 
        $sql = " 
                    SELECT 
                        tanggal_trx,
                        SUM(CASE WHEN jenis_trx = 'masuk' THEN jum_nom ELSE 0 END) AS nom_masuk,
                        SUM(CASE WHEN jenis_trx = 'keluar' THEN jum_nom ELSE 0 END) AS nom_keluar,
                        SUM(CASE WHEN jenis_trx = 'masuk' THEN jum_nom ELSE 0 END) 
                        - SUM(CASE WHEN jenis_trx = 'keluar' THEN jum_nom ELSE 0 END) AS nom_margin
                    FROM (
                        SELECT left(tanggal_transaksi,7) AS tanggal_trx, SUM(total_harga) AS jum_nom, 'masuk' AS jenis_trx
                        FROM transaksi_penjualan_material
                        WHERE LEFT(tanggal_transaksi, 4) = '$tahun'
                        GROUP BY left(tanggal_transaksi,7)

                        UNION ALL

                        SELECT left(tanggal,7) AS tanggal_trx, SUM(jumlah) AS jum_nom, 'keluar' AS jenis_trx
                        FROM transaksi
                        WHERE LEFT(tanggal, 4) = '$tahun' AND tipe_transaksi = 'keluar'
                        GROUP BY left(tanggal,7)

                        UNION ALL

                        SELECT left(tanggal,7) AS tanggal_trx, SUM(jumlah) AS jum_nom, 'masuk' AS jenis_trx
                        FROM transaksi
                        WHERE LEFT(tanggal, 4) = '$tahun' AND tipe_transaksi = 'masuk'
                        GROUP BY left(tanggal,7)
                    ) x
                    GROUP BY tanggal_trx
                    ORDER BY tanggal_trx;

            ";
        $data["char_total"] =  $this->db->query($sql)->result_array();

        // print_r($data["char_total"]);
        // return;

        $data["bulan"] = $thismonth;

        $this->load->view('owner/dashboard_bulan', $data);
    }
}
