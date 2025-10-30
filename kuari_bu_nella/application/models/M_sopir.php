<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sopir extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat library database
    }

    // Fungsi untuk mengambil semua data sopir
    public function get_all_sopir()
    {

        $this->db->order_by("nama_lengkap", "asc");
        $query = $this->db->get('sopir');
        return $query->result_array();
    }

    // Fungsi untuk mengambil satu data sopir berdasarkan ID
    public function get_sopir_by_id($id)
    {
        $this->db->where('id_sopir', $id);
        $query = $this->db->get('sopir');
        return $query->row(); // Mengembalikan satu baris data
    }

    // Fungsi untuk memasukkan data sopir baru
    public function insert_sopir($data)
    {
        $this->db->insert('sopir', $data);
        return $this->db->insert_id(); // Mengembalikan ID dari data yang baru dimasukkan
    }

    // Fungsi untuk memperbarui data sopir
    public function update_sopir($id, $data)
    {
        $this->db->where('id_sopir', $id);
        $this->db->update('sopir', $data);
        return $this->db->affected_rows(); // Mengembalikan jumlah baris yang terpengaruh
    }

    // Fungsi untuk menghapus data sopir
    public function delete_sopir($id)
    {
        $this->db->where('id_sopir', $id);
        $this->db->delete('sopir');
        return $this->db->affected_rows(); // Mengembalikan jumlah baris yang terhapus
    }
}
