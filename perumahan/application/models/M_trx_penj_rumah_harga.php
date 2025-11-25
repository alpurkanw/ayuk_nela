<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_trx_penj_rumah_harga extends CI_Model
{
    protected $table = 'trx_penj_rumah';
    protected $table_harga = 'trx_penj_rumah_harga';
    // protected $table_trx = 'trx_transaksi';

    // protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }


    public function addharga($data)
    {
        return $this->db->insert($this->table_harga, $data);
    }


    public function get_hutang_cust_per_perum($id_perumahan)
    {

        $sql = "SELECT * FROM trx_penj_rumah_harga a
                LEFT JOIN trx_penj_rumah b on b.id = a.id_penj_rumah and b.id_perum = $id_perumahan
                where nominal > terbayar

        ";

        return $this->db->query($sql);
    }

    public function getAllHargaPerIdrumah($id_perum, $id_rumah)
    {
        // return $this->db->get('tm_harga_rumah');

        // echo $id_perum . "tes";
        // echo $id_rumah;
        // return;



        $sql = " SELECT  a.*, b.*,a.id id_harga  FROM trx_penj_rumah_harga a
                JOIN trx_penj_rumah b on b.id = a.id_penj_rumah and b.id_perum = $id_perum and b.id_rumah = $id_rumah
        ";
        // echo $sql;
        // return;
        return $this->db->query($sql);
        // return $this->db->query($sql);
    }

    public function getAllHargaPerIdJns($id_perum, $id_rumah, $id_jns)
    {

        $sql = " SELECT  a.*, b.*,a.id id_harga  FROM trx_penj_rumah_harga a
                JOIN trx_penj_rumah b on b.id = a.id_penj_rumah and b.id_perum = $id_perum and b.id_rumah = $id_rumah
                where a.id_jns = $id_jns
        ";
        // echo $sql;
        // return;
        return $this->db->query($sql);
        // return $this->db->query($sql);
    }
}
