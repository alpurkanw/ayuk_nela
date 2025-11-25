<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_harga_rumah extends CI_Model
{
    // protected $table = 'tm_rumah';
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



    // public function getAllRumah()
    // {
    //     // return $this->db->get($this->table)->result_array();
    //     $sql = " select a.*, b.* from tm_rumah a
    //     left join tm_perumahan b on b.id = a.id_perumahan
    //     ";

    //     return $this->db->query($sql);
    // }

    public function getAllHarga()
    {
        // $this->db->where('id_perum', $id_perum);
        // $this->db->where('id_rumah', $id_rumah); // Asumsi nama kolom di DB adalah 'norumah'

        // return $this->db->get('tm_harga_rumah');

        $sql = " select a.*, b.*,c.*, d.* from tm_harga_rumah a
        left join tm_rumah b on b.id = a.id_rumah
        left join tm_perumahan c on c.id = a.id_perum
        left join tm_jns_harga d on d.id = a.id_jns order by a.id_perum,a.id_rumah,a.id_jns
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


    public function cek_duplikasi_harga($id_perumahan, $no_rumah, $jenis_harga)
    {

        // 1. Tentukan kondisi WHERE untuk kedua kolom
        $this->db->where('id_perum', $id_perumahan);
        $this->db->where('id_rumah', $no_rumah); // Asumsi nama kolom di DB adalah 'norumah'
        $this->db->where('id_jns', $jenis_harga);

        // 2. Jalankan query SELECT pada tabel tm_rumah
        $query = $this->db->get('tm_harga_rumah');

        // 3. Hitung hasilnya
        // Jika num_rows() > 0, berarti data sudah ada (duplikat)
        return $query->num_rows();
    }


    public function update_master_harga($nominal, $id_perum, $id_rumah, $id_kateg)
    {

        // PERHATIAN: JANGAN GUNAKAN NILAI VARIABEL LANGSUNG! 
        // Gunakan fungsi escape CodeIgniter untuk keamanan
        $nominal_esc = $this->db->escape($nominal);
        $id_perum_esc = $this->db->escape($id_perum);
        $id_rumah_esc = $this->db->escape($id_rumah);
        $id_kateg_esc = $this->db->escape($id_kateg);

        // Raw SQL dengan variabel yang sudah di-escape
        $sql = " UPDATE tm_harga_rumah 
             SET terbayar = terbayar + $nominal_esc
             WHERE id_perum = $id_perum_esc 
               AND id_rumah = $id_rumah_esc 
               AND id_jns = $id_kateg_esc ";

        // Jalankan query
        $this->db->query($sql);

        // KUNCI: Kembalikan jumlah baris yang terpengaruh
        return $this->db->affected_rows();
    }
}
