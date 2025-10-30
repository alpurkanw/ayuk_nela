<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_trx_penj_rumah extends CI_Model
{
    protected $table = 'trx_penj_rumah';
    // protected $table_harga = 'tm_harga_rumah';
    // protected $table_trx = 'trx_transaksi';

    // protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }


    public function insertTrx($data)
    {
        return $this->db->insert($this->table, $data);
    }
}
