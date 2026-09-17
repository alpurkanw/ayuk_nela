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

        $sql = "
                    SELECT b.id, a.nama_perum, a.norumah, a.nama_cust, b.nama_harga kategori_dp, b.nominal,
                           (SELECT SUM(nominal) terbayar
                            FROM `trx_transaksi`
                            WHERE tipe_transaksi = 'masuk'
                              AND id_perum = a.id_perum
                              AND id_rumah = a.id_rumah
                              AND id_kateg = b.id_jns) nom_terbayar
                    FROM trx_penj_rumah a
                    LEFT JOIN trx_penj_rumah_harga b ON b.id_penj_rumah = a.id
                    WHERE id_perum = $id_perumahan
                    ORDER BY a.nama_perum ASC, a.norumah ASC, a.id ASC
        ";

        return $this->db->query($sql);
    }

    public function getAllHargaPerIdrumah_terjual($id_perum, $id_rumah)
    {
        // return $this->db->get('tm_harga_rumah');

        // echo $id_perum . "tes";
        // echo $id_rumah;
        // return;

        $sql = "SELECT a.*, b.*, a.id AS id_harga,
                       COALESCE((SELECT SUM(nominal)
                                 FROM trx_transaksi
                                 WHERE tipe_transaksi = 'masuk'
                                   AND id_perum = b.id_perum
                                   AND id_rumah = b.id_rumah
                                   AND id_kateg = a.id_jns), 0) AS nom_terbayar
                FROM trx_penj_rumah_harga a
                JOIN trx_penj_rumah b ON b.id = a.id_penj_rumah
                WHERE b.id_perum = ?
                  AND b.id_rumah = ?
        ";
        return $this->db->query($sql, [$id_perum, $id_rumah]);
    }

    public function getListPendapatan($id_perum, $id_rumah)
    {
        // return $this->db->get('tm_harga_rumah');

        // echo $id_perum . "tes";
        // echo $id_rumah;
        // return;

        $sql = " 
            SELECT  nama_harga, id_jns  FROM trx_penj_rumah_harga where id_penj_rumah in (select id from trx_penj_rumah where id_perum = $id_perum and id_rumah = $id_rumah	)
        ";
        // echo $sql;
        // return;
        return $this->db->query($sql);
        // return $this->db->query($sql);
    }

    public function getAllHargaPerIdJns($id_perum, $id_rumah, $id_jns)
    {

        //    SELECT  a.*, b.*,a.id id_harga  FROM trx_penj_rumah_harga a
        //         JOIN trx_penj_rumah b on b.id = a.id_penj_rumah and b.id_perum =  and b.id_rumah = 
        //         where a.id_penj_rumah = $id_jns

        $sql = " 
                

                SELECT  a.*, b.*,a.id id_harga  FROM trx_penj_rumah_harga a
                left join trx_penj_rumah b on b.id = a.id_penj_rumah 
                where a.id_jns = $id_jns and b.id_perum = $id_perum and b.id_rumah = $id_rumah
        ";
        // echo $sql;
        // return;
        return $this->db->query($sql);
        // return $this->db->query($sql);
    }
}
