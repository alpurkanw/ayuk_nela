<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_transaksi extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat library database
    }

    /**
     * Fungsi untuk menyimpan data ke tabel
     * @param string $table Nama tabel
     * @param array $data Data yang akan disimpan
     * @return int|bool ID dari record yang baru dibuat jika berhasil, atau FALSE jika gagal
     */
    public function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id(); // Mengembalikan ID dari record yang baru saja di-insert
    }

    // public function batalkan($id)
    // {
    //     return $this->db->get_where("transaksi_penjualan_material", ["id_transaksi" => $id])->row_array();
    // }

    public function batal_transaksi($id_transaksi)
    {
        // Mulai transaksi database
        $this->db->trans_begin();

        // 1. Backup data ke tabel log
        $this->db->query("INSERT INTO transaksi_penjualan_material_log_delete SELECT * FROM `transaksi_penjualan_material` WHERE id_transaksi = ?", array($id_transaksi));

        // 2. Hapus data dari tabel utama
        $this->db->query("DELETE FROM `transaksi_penjualan_material` WHERE id_transaksi = ?", array($id_transaksi));

        // Cek apakah ada error dalam transaksi
        if ($this->db->trans_status() === FALSE) {
            // Jika ada error, batalkan semua perubahan
            $this->db->trans_rollback();
            return FALSE;
        } else {
            // Jika berhasil, terapkan perubahan
            $this->db->trans_commit();
            return TRUE;
        }
    }
    // Anda bisa menambahkan fungsi lain di sini, contoh:
    // public function get_all_transactions() { ... }
    // public function get_transaction_by_id($id) { ... }
}
