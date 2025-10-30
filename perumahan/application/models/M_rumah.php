<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rumah extends CI_Model
{
    protected $table = 'tm_rumah';
    protected $table_harga = 'tm_harga_rumah';

    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    // /**
    //  * Mengambil semua data akun dari database.
    //  *
    //  * @return array
    //  */
    public function getAllRumah()
    {
        // return $this->db->get($this->table)->result_array();
        $sql = " select a.id id_rumah, b.id id_perum, a.*, b.* from tm_rumah a
        left join tm_perumahan b on b.id = a.id_perumahan
        ";

        return $this->db->query($sql);
    }

    public function getAllHarga($id_perum, $id_rumah)
    {
        // $this->db->where('id_perum', $id_perum);
        // $this->db->where('id_rumah', $id_rumah); // Asumsi nama kolom di DB adalah 'norumah'

        // return $this->db->get('tm_harga_rumah');

        $sql = " select a.*, b.*,c.*, d.* from tm_harga_rumah a
        left join tm_rumah b on b.id = a.id_rumah
        left join tm_perumahan c on c.id = a.id_perum
        left join tm_jns_harga d on d.id = a.id_jns
        where a.id_perum = $id_perum and a.id_rumah = $id_rumah
        ";

        return $this->db->query($sql);
        // return $this->db->query($sql);
    }

    public function getAllHargaPerId($id_perum, $id_rumah, $jns_jenis)
    {
        // $this->db->where('id_perum', $id_perum);
        // $this->db->where('id_rumah', $id_rumah); // Asumsi nama kolom di DB adalah 'norumah'

        // return $this->db->get('tm_harga_rumah');

        $sql = " select a.*, b.*,c.*, d.* from tm_harga_rumah a
        left join tm_rumah b on b.id = a.id_rumah
        left join tm_perumahan c on c.id = a.id_perum
        left join tm_jns_harga d on d.id = a.id_jns
        where a.id_perum = $id_perum and a.id_rumah = $id_rumah and a.id_jns = $jns_jenis
        ";

        return $this->db->query($sql);
        // return $this->db->query($sql);
    }

    public function getAccountById($id)
    {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row_array();
    }


    public function addRumah($data)
    {
        return $this->db->insert($this->table, $data);
    }




    public function cek_duplikasi_rumah($id_perumahan, $no_rumah)
    {

        // 1. Tentukan kondisi WHERE untuk kedua kolom
        $this->db->where('id_perumahan', $id_perumahan);
        $this->db->where('norumah', $no_rumah); // Asumsi nama kolom di DB adalah 'norumah'

        // 2. Jalankan query SELECT pada tabel tm_rumah
        $query = $this->db->get('tm_rumah');

        // 3. Hitung hasilnya
        // Jika num_rows() > 0, berarti data sudah ada (duplikat)
        return $query->num_rows();
    }




    public function get_rumah_by_perum_id($id_perumahan)
    {

        $sql = " select * from tm_rumah 
        where id_perumahan=$id_perumahan
        ";

        return $this->db->query($sql);



        // Kembalikan hasil dalam bentuk array of objects
        // return $query->result();
    }


    public function get_rumah_by_perum_blm_terjual($id_perumahan)
    {

        $sql = " select * from tm_rumah 
        where id_perumahan=$id_perumahan and id not in (select id_rumah from trx_penj_rumah where id_perum = $id_perumahan )
        ";

        return $this->db->query($sql);



        // Kembalikan hasil dalam bentuk array of objects
        // return $query->result();
    }
    public function get_st_rumah_by_perum($id_perumahan)
    {

        $sql = " SELECT a.*,c.nama nama_perum, b.nama_cust from  `tm_rumah`a
                LEFT JOIN trx_penj_rumah b on b.id_rumah = a.id 
                LEFT JOIN tm_perumahan c on c.id = a.id_perumahan
                where id_perumahan = $id_perumahan

        ";

        return $this->db->query($sql);
    }


    public function get_rumah_terjual_by_perum($id_perumahan)
    {

        $sql = " select * from trx_penj_rumah 
        where id_perum=$id_perumahan 
        ";

        return $this->db->query($sql);



        // Kembalikan hasil dalam bentuk array of objects
        // return $query->result();
    }




    // /**
    //  * Menghapus data akun dari database.
    //  *
    //  * @param int $id ID Akun
    //  * @return bool
    //  */
    // public function deleteAccount($id)
    // {
    //     return $this->db->delete($this->table, [$this->primaryKey => $id]);
    // }
}
