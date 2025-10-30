<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_financial extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Memuat library database CodeIgniter
        $this->load->database();
    }

    /**
     * Menyimpan data uang masuk ke tabel transaksi_uang_masuk.
     *
     * @param array $data Data yang akan disimpan.
     * @return bool Hasil operasi (TRUE jika berhasil, FALSE jika gagal).
     */
    public function insert_uang_masuk($data)
    {
        // Menyimpan data ke tabel 'transaksi_uang_masuk'
        return $this->db->insert('transaksi', $data);
    }

    public function insert_uang_keluar($data)
    {
        // Menyimpan data ke tabel 'transaksi_uang_masuk'
        return $this->db->insert('transaksi', $data);
    }

    public function get_expense_accounts()
    {
        $this->db->where('category', 'Pengeluaran');
        $this->db->order_by('no_account'); // Menambahkan pengurutan berdasarkan no_account
        return $this->db->get('accounts')->result();
    }

    public function get_income_accounts()
    {
        // Mengambil semua data dari tabel 'accounts' di mana category adalah 'Pemasukan'
        $this->db->where('category', 'Pemasukan');
        $this->db->order_by('no_account');
        return $this->db->get('accounts')->result();
    }
}
