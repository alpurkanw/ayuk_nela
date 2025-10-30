<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_account extends CI_Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'id_account';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Mengambil semua data akun dari database.
     *
     * @return array
     */
    public function getAllAccounts()
    {
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Mengambil satu data akun berdasarkan ID.
     *
     * @param int $id ID Akun
     * @return array
     */
    public function getAccountById($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row_array();
    }

    /**
     * Menambahkan data akun baru ke database.
     *
     * @param array $data Data yang akan ditambahkan
     * @return bool
     */
    public function addAccount($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Memperbarui data akun yang sudah ada.
     *
     * @param int $id ID Akun
     * @param array $data Data yang akan diperbarui
     * @return bool
     */
    public function updateAccount($id, $data)
    {
        $this->db->where($this->primaryKey, $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Menghapus data akun dari database.
     *
     * @param int $id ID Akun
     * @return bool
     */
    public function deleteAccount($id)
    {
        return $this->db->delete($this->table, [$this->primaryKey => $id]);
    }
}
