<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_bayar extends CI_Model
{
    protected $table = 'tm_kategori_pengeluaran';
    protected $table_trx = 'trx_transaksi';
    protected $table_harga_rumah = 'tm_harga_rumah';

    public function __construct()
    {
        parent::__construct();
    }

    // Mengambil semua data material
    public function getAllkategs()
    {
        return $this->db->get($this->table);
    }

    // // Mengambil data material berdasarkan ID
    // public function getMaterialById($id)
    // {
    //     return $this->db->get_where($this->table, [$this->primaryKey => $id])->row_array();
    // }

    // // Menambah data material baru
    public function addKategori($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function addOutPerRumah($data)
    {
        return $this->db->insert($this->table_trx, $data);
    }


    public function upd_master_hargaRumah($data, $id_perum, $id_rumah, $id_jns)
    {
        // return $this->db->insert($this->table_harga_rumah, $data);
        $this->db->where('id_perum', $id_perum);
        $this->db->where('id_rumah', $id_rumah);
        $this->db->where('id_jns', $id_jns);
        $this->db->update($this->table_harga_rumah, $data);
        return $this->db->affected_rows(); // Mengembalikan jumlah baris yang terpengaruh

    }


    // // Memperbarui data material
    // public function updateMaterial($id, $data)
    // {
    //     $this->db->where($this->primaryKey, $id);
    //     return $this->db->update($this->table, $data);
    // }

    // // Menghapus data material
    // public function deleteMaterial($id)
    // {
    //     return $this->db->delete($this->table, [$this->primaryKey => $id]);
    // }
}
