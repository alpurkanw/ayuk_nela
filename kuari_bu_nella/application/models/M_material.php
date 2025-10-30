<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_material extends CI_Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id_material';

    public function __construct()
    {
        parent::__construct();
    }

    // Mengambil semua data material
    public function getAllMaterials()
    {
        return $this->db->get($this->table)->result_array();
    }

    // Mengambil data material berdasarkan ID
    public function getMaterialById($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row_array();
    }

    // Menambah data material baru
    public function addMaterial($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Memperbarui data material
    public function updateMaterial($id, $data)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, $data);
    }

    // Menghapus data material
    public function deleteMaterial($id)
    {
        return $this->db->delete($this->table, [$this->primaryKey => $id]);
    }
}
