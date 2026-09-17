<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Claporan extends MY_Admin_Controller

{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_rumah', 'rmh'); // <-- baris penting ini
        $this->load->model('M_transaksi', 'trx'); // <-- baris penting ini
        $this->load->model('M_trx_penj_rumah_harga', 'hrg_rmh'); // <-- baris penting ini
        // $this->load->model('M_financial'); // <-- baris penting ini
    }

    public function lap_out_rumah_per_perum_form()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('admin/lap_out_rumah_per_perum_form', $data);
    }

    public function lap_out_rumah_per_perum_view()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        $id_perum = $this->input->post('id_perumahan');
        if (!$id_perum) {
            $id_perum = $this->input->get('id_perumahan');
        }

        $data['list_rumah'] = $this->trx->get_nom_out_rumah_per_perum($id_perum)->result();
        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        $data['nama_perumahan'] = $perum ? $perum->nama : '-';
        $data['report_date'] = date('d/m/Y');
        $this->load->view('admin/lap_out_rumah_per_perum_view', $data);
    }

    public function lap_out_rumah_per_perumahan()
    {
        $data['judul'] = 'Laporan Pengeluaran Rumah Per Perumahan';
        $sql = "SELECT p.id,
                       p.nama AS nama_perum,
                       COALESCE(SUM(k.total_kategori), 0) AS total_pengeluaran
                FROM tm_perumahan p
                LEFT JOIN (
                    SELECT id_perum, id_kateg, SUM(nominal) AS total_kategori
                    FROM trx_transaksi
                    WHERE tipe_transaksi = 'keluar'
                        AND peruntukan = 'rumah'
                    GROUP BY id_perum, id_kateg
                ) k ON k.id_perum = p.id
                GROUP BY p.id, p.nama
                ORDER BY p.nama";

        $data['list_perumahan'] = $this->db->query($sql)->result();
        $data['report_date'] = date('d/m/Y');
        $data['grand_total'] = 0;
        foreach ($data['list_perumahan'] as $row) {
            $data['grand_total'] += (float) $row->total_pengeluaran;
        }

        $this->load->view('admin/lap_out_rumah_per_perumahan_view', $data);
    }

    public function lap_out_rumah_per_perumahan_detail()
    {
        $id_perum = (int) $this->input->post('id_perum');
        if (!$id_perum) {
            $id_perum = (int) $this->input->get('id_perum');
        }

        if (!$id_perum) {
            redirect('admin/Claporan/lap_out_rumah_per_perumahan');
            return;
        }

        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        $data['judul'] = 'Detail Pengeluaran Rumah Per Perumahan';
        $data['nama_perumahan'] = $perum ? $perum->nama : '-';
        $data['report_date'] = date('d/m/Y');
        $data['list_transaksi'] = $this->trx->get_detail_out_rumah_per_perumahan($id_perum)->result();
        $data['grand_total'] = 0;
        foreach ($data['list_transaksi'] as $row) {
            $data['grand_total'] += (float) $row->total_pengeluaran;
        }

        $this->load->view('admin/lap_out_rumah_per_perumahan_detail_view', $data);
    }


    public function lap_out_umum_per_perum_form()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('admin/lap_out_umum_per_perum_form', $data);
    }

    public function lap_out_umum_per_perum_view()
    {
        $data["judul"] = "Detail Harga Rumah";
        $id_perum = $this->input->post('id_perumahan');
        if (!$id_perum) {
            $id_perum = $this->input->get('id_perumahan');
        }

        if (!$id_perum) {
            redirect('admin/claporan/lap_out_umum_per_perum_form');
            return;
        }

        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        $range = $this->trx->get_range_out_umum_per_perum($id_perum)->row();

        $data['id_perum'] = (int) $id_perum;
        $data['nama_perumahan'] = $perum ? $perum->nama : '-';
        $data['report_date'] = date('d/m/Y');
        $data['periode_awal'] = (!empty($range) && !empty($range->tanggal_awal)) ? $range->tanggal_awal : null;
        $data['periode_akhir'] = (!empty($range) && !empty($range->tanggal_akhir)) ? $range->tanggal_akhir : null;
        $data['grand_total'] = (!empty($range) && isset($range->total_pengeluaran)) ? (float) $range->total_pengeluaran : 0;
        $data['list_rumah'] = $this->trx->get_nom_out_umum_per_perum($id_perum)->result();
        $this->load->view('admin/lap_out_umum_per_perum_view', $data);
    }

    public function lap_out_umum_per_perum_detail()
    {
        $id_perum = (int) $this->input->post('id_perum');
        $id_kateg = (int) $this->input->post('id_kateg');

        if (!$id_perum || !$id_kateg) {
            echo json_encode(['status' => 'error', 'message' => 'Parameter tidak valid.', 'data' => []]);
            return;
        }

        $rows = $this->trx->get_detail_out_umum_per_perum($id_perum, $id_kateg)->result();

        $total = 0;
        foreach ($rows as $row) {
            $total += (float) $row->nominal;
        }

        echo json_encode(['status' => 'success', 'data' => $rows, 'total' => $total]);
    }

    public function lap_penjualan_per_perumahan()
    {
        $data["judul"] = "Laporan Penjualan Per Perumahan";
        $sql = "SELECT p.id, p.nama AS nama_perum, COALESCE(SUM(h.nominal), 0) AS total_penjualan
                FROM tm_perumahan p
                LEFT JOIN tm_rumah r ON r.id_perumahan = p.id
                LEFT JOIN trx_penj_rumah tr ON tr.id_rumah = r.id
                LEFT JOIN trx_penj_rumah_harga h ON h.id_penj_rumah = tr.id
                GROUP BY p.id, p.nama
                ORDER BY p.nama";
        $data['list_perumahan'] = $this->db->query($sql)->result();
        $data['report_date'] = date('d/m/Y');
        $data['grand_total'] = 0;
        foreach ($data['list_perumahan'] as $row) {
            $data['grand_total'] += (float) $row->total_penjualan;
        }
        $this->load->view('admin/lap_penjualan_per_perumahan_view', $data);
    }

    public function lap_out_per_perumahan()
    {
        $data["judul"] = "Laporan Pengeluaran Umum Per Perumahan";
        $sql = "SELECT p.id, p.nama AS nama_perum,
                       COALESCE(SUM(k.total_kategori), 0) AS total_pengeluaran
                FROM tm_perumahan p
                LEFT JOIN (
                    SELECT id_perum, id_kateg, SUM(nominal) AS total_kategori
                    FROM trx_transaksi
                    WHERE tipe_transaksi = 'keluar'
                        AND peruntukan = 'umum'
                    GROUP BY id_perum, id_kateg
                ) k ON k.id_perum = p.id
                GROUP BY p.id, p.nama
                ORDER BY p.nama";
        $data['list_perumahan'] = $this->db->query($sql)->result();
        $data['report_date'] = date('d/m/Y');
        $data['grand_total'] = 0;
        foreach ($data['list_perumahan'] as $row) {
            $data['grand_total'] += (float) $row->total_pengeluaran;
        }
        $this->load->view('admin/lap_out_per_perumahan_view', $data);
    }

    public function lap_out_per_perumahan_detail()
    {
        $id_perum = (int) $this->input->post('id_perum');
        if (!$id_perum) {
            $id_perum = (int) $this->input->get('id_perum');
        }

        if (!$id_perum) {
            redirect('admin/Claporan/lap_out_per_perumahan');
            return;
        }

        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        $data['judul'] = "Detail Pengeluaran Umum Per Perumahan";
        $data['id_perum'] = $id_perum;
        $data['nama_perumahan'] = $perum ? $perum->nama : '-';
        $data['report_date'] = date('d/m/Y');
        $data['list_transaksi'] = $this->trx->get_detail_out_umum_perum_all($id_perum)->result();
        $data['grand_total'] = 0;
        foreach ($data['list_transaksi'] as $row) {
            $data['grand_total'] += (float) $row->total_pengeluaran;
        }

        $this->load->view('admin/lap_out_per_perumahan_detail_view', $data);
    }

    public function lap_laba_rugi_form()
    {
        $data['judul'] = 'Laporan Laba Rugi';
        $data['list_perum'] = $this->db->order_by('nama', 'ASC')->get('tm_perumahan')->result();
        $this->load->view('admin/lap_laba_rugi_form', $data);
    }

    public function lap_laba_rugi_view()
    {
        $id_perum = (int) $this->input->post('id_perumahan');
        if (!$id_perum) {
            $id_perum = (int) $this->input->get('id_perumahan');
        }

        if (!$id_perum) {
            redirect('admin/Claporan/lap_laba_rugi_form');
            return;
        }

        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        $data['nama_perumahan'] = $perum ? $perum->nama : '-';
        $data['report_date'] = date('d-m-Y');

        $data['total_rumah'] = (int) $this->db->where('id_perumahan', $id_perum)->count_all_results('tm_rumah');
        $data['total_terjual'] = (int) $this->db->where('id_perum', $id_perum)->count_all_results('trx_penj_rumah');

        $rows = [];
        $pendapatan_total = 0;

        $penjualan_sql = "
            SELECT COALESCE(SUM(r.harga_jual), 0) AS nominal
            FROM trx_penj_rumah tr
            JOIN tm_rumah r ON r.id = tr.id_rumah
            WHERE tr.id_perum = ?
        ";
        $penjualan_row = $this->db->query($penjualan_sql, [$id_perum])->row();
        $penjualan_nominal = $penjualan_row ? (float) $penjualan_row->nominal : 0;
        $rows[] = [
            'deskripsi' => 'Pendapatan Penjualan rumah (' . $data['total_terjual'] . ' rumah)',
            'pendapatan' => $penjualan_nominal,
            'biaya' => 0
        ];
        $pendapatan_total += $penjualan_nominal;

        $pendapatan_sql = "
            SELECT h.nama_harga AS deskripsi,
                   COALESCE(SUM(t.nominal), 0) AS nominal
            FROM trx_penj_rumah_harga h
            JOIN trx_penj_rumah p ON p.id = h.id_penj_rumah
            LEFT JOIN trx_transaksi t
                ON t.id_perum = p.id_perum
               AND t.id_rumah = p.id_rumah
               AND t.id_kateg = h.id_jns
               AND t.tipe_transaksi = 'masuk'
            WHERE p.id_perum = ?
            GROUP BY h.id_jns, h.nama_harga
            ORDER BY h.nama_harga ASC
        ";

        $pendapatan_rows = $this->db->query($pendapatan_sql, [$id_perum])->result();
        foreach ($pendapatan_rows as $row) {
            $nominal = (float) $row->nominal;
            $rows[] = [
                'deskripsi' => $row->deskripsi,
                'pendapatan' => $nominal,
                'biaya' => 0
            ];
            $pendapatan_total += $nominal;
        }

        $biaya_total = 0;
        $biaya_sql = "
            SELECT k.kateg AS deskripsi,
                   COALESCE(SUM(t.nominal), 0) AS nominal
            FROM tm_kategori_pengeluaran k
            LEFT JOIN trx_transaksi t
                ON t.id_kateg = k.id
               AND t.tipe_transaksi = 'keluar'
               AND t.id_perum = ?
               AND t.peruntukan IN ('rumah', 'umum')
            GROUP BY k.id, k.kateg
            ORDER BY k.kateg ASC
        ";

        $biaya_rows = $this->db->query($biaya_sql, [$id_perum])->result();
        foreach ($biaya_rows as $row) {
            $nominal = (float) $row->nominal;
            $rows[] = [
                'deskripsi' => $row->deskripsi,
                'pendapatan' => 0,
                'biaya' => $nominal
            ];
            $biaya_total += $nominal;
        }

        $data['rows'] = $rows;
        $data['total_pendapatan'] = $pendapatan_total;
        $data['total_biaya'] = $biaya_total;
        $data['saldo'] = $pendapatan_total - $biaya_total;

        $this->load->view('admin/lap_laba_rugi_view', $data);
    }


    public function lap_st_rumah_per_perum_form()
    {
        $data["judul"] = "Laporan Penjualan Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('admin/lap_st_rumah_per_perum_form', $data);
    }
    public function lap_st_rumah_per_perum_view()
    {
        $data["judul"] = "Laporan Penjualan Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $id_perum = $this->input->post('id_perumahan');


        $data['list_rumah'] = $this->rmh->get_st_rumah_by_perum($id_perum)->result();
        $this->load->view('admin/lap_st_rumah_per_perum_view', $data);
    }

    //laporan untuk menampilkan list pendapatan apa saja yang akan ada pada rumah yang dijual
    public function lap_list_dp()
    {
        $data["judul"] = "List Pendapatan(DP)";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('admin/lap_list_dp_form', $data);
    }
    public function lap_list_dp_view()
    {
        $data["judul"] = "List Pendapatan(DP) Penjualan Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $id_perum = $this->input->post('id_perumahan');

        $sql = " SELECT a.id id_hrg_penj_rumah, a.id_jns, a.nama_harga, nominal, id_perum, nama_perum, id_rumah, norumah, nama_cust, notelp, alamat  FROM `trx_penj_rumah_harga` a 
left JOIN trx_penj_rumah b on b.id = a.id_penj_rumah 
where b.id_perum = $id_perum order by id_perum, id_rumah";

        // Jalankan query
        $data['list_rumah'] = $this->db->query($sql)->result();
        $this->load->view('admin/lap_list_dp_view', $data);
    }


    public function lap_hutang_cust_form()
    {
        $data["judul"] = "Laporan Hutang Customer";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $this->load->view('admin/lap_hutang_cust_form', $data);
    }

    public function lap_hutang_cust_view()
    {
        $data["judul"] = "Laporan Hutang Customer";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['materials'] = $this->M_material->getAllMaterials();

        $id_perum = $this->input->post('id_perumahan');
        if (!$id_perum) {
            $id_perum = $this->input->get('id_perumahan');
        }

        if (!$id_perum) {
            redirect('admin/claporan/lap_hutang_cust_form');
            return;
        }

        $data['list_rumah'] = $this->hrg_rmh->get_hutang_cust_per_perum($id_perum)->result();
        $this->load->view('admin/lap_hutang_cust_view', $data);
    }

    public function lap_hutang_cust_detail($id_hrg_penj_rumah = null)
    {
        if (!$id_hrg_penj_rumah) {
            redirect('admin/claporan/lap_hutang_cust_form');
        }

        $data["judul"] = "Detail Hutang Customer";

        $sql_harga = "
            SELECT a.id, a.id_penj_rumah, a.id_jns, a.nama_harga, a.nominal,
                   b.id_perum, b.id_rumah, b.nama_perum,
                   b.norumah, b.nama_cust, b.notelp, b.alamat
            FROM trx_penj_rumah_harga a
            JOIN trx_penj_rumah b ON b.id = a.id_penj_rumah
            WHERE a.id = ?
        ";
        $detail_harga = $this->db->query($sql_harga, [$id_hrg_penj_rumah])->row();

        if (!$detail_harga) {
            redirect('admin/claporan/lap_hutang_cust_form');
        }

        $data['rumah_info'] = $this->db->query(
            "SELECT * FROM tm_rumah WHERE id = ?",
            [$detail_harga->id_rumah]
        )->row();

        $data['pembeli_info'] = (object)[
            'nama_cust' => $detail_harga->nama_cust,
            'notelp' => $detail_harga->notelp,
            'alamat' => $detail_harga->alamat,
            'norumah' => $detail_harga->norumah,
            'nama_perum' => $detail_harga->nama_perum
        ];

        $data['harga_detail'] = $detail_harga;
        $sql_harga_list = "
            SELECT a.id, a.id_penj_rumah, a.id_jns, a.nama_harga, a.nominal,
                   COALESCE((
                       SELECT SUM(t.nominal)
                       FROM trx_transaksi t
                       WHERE t.tipe_transaksi = 'masuk'
                         AND t.id_perum = b.id_perum
                         AND t.id_rumah = b.id_rumah
                         AND t.id_kateg = a.id_jns
                   ), 0) AS nom_terbayar
            FROM trx_penj_rumah_harga a
            JOIN trx_penj_rumah b ON b.id = a.id_penj_rumah
            WHERE a.id_penj_rumah = ?
        ";
        $raw_list_harga = $this->db->query($sql_harga_list, [$detail_harga->id_penj_rumah])->result();

        $aggregated_harga = [];
        foreach ($raw_list_harga as $harga) {
            $kategoriId = isset($harga->id_jns) ? $harga->id_jns : 0;
            $nominal = isset($harga->nominal) ? $harga->nominal : 0;
            $nom_terbayar = isset($harga->nom_terbayar) ? $harga->nom_terbayar : 0;

            if (!isset($aggregated_harga[$kategoriId])) {
                $aggregated_harga[$kategoriId] = (object) [
                    'id_jns' => $kategoriId,
                    'nama_harga' => isset($harga->nama_harga) ? $harga->nama_harga : '-',
                    'nominal' => $nominal,
                    'nom_terbayar' => $nom_terbayar,
                ];
            } else {
                $aggregated_harga[$kategoriId]->nominal += $nominal;
                $aggregated_harga[$kategoriId]->nom_terbayar += $nom_terbayar;
            }
        }

        $data['list_harga'] = array_values($aggregated_harga);
        $data['total_nominal'] = 0;
        $data['total_terbayar'] = 0;
        $data['total_sisa'] = 0;
        foreach ($data['list_harga'] as $harga) {
            $harga_nominal = isset($harga->nominal) ? $harga->nominal : 0;
            $harga_nom_terbayar = isset($harga->nom_terbayar) ? $harga->nom_terbayar : 0;
            $data['total_nominal'] += $harga_nominal;
            $data['total_terbayar'] += $harga_nom_terbayar;
            $data['total_sisa'] += ($harga_nominal - $harga_nom_terbayar);
        }

        $sql_transaksi = "
            SELECT t.id, t.id_kateg, t.tanggal, t.keterangan, t.nominal,
                   h.nama_harga AS kategori
            FROM trx_transaksi t
            JOIN (
                SELECT DISTINCT id_jns, nama_harga
                FROM trx_penj_rumah_harga
                WHERE id_penj_rumah = ?
            ) h ON h.id_jns = t.id_kateg
            WHERE t.tipe_transaksi = 'masuk'
                AND t.id_perum = ?
                AND t.id_rumah = ?
            ORDER BY t.tanggal
        ";
        $data['list_transaksi'] = $this->db->query(
            $sql_transaksi,
            [$detail_harga->id_penj_rumah, $detail_harga->id_perum, $detail_harga->id_rumah]
        )->result();

        $data['transaksi_by_kategori'] = [];
        $data['total_pembayaran'] = 0;
        foreach ($data['list_transaksi'] as $trx) {
            $kategoriId = isset($trx->id_kateg) ? $trx->id_kateg : 0;
            if (!isset($data['transaksi_by_kategori'][$kategoriId])) {
                $data['transaksi_by_kategori'][$kategoriId] = [];
            }
            $data['transaksi_by_kategori'][$kategoriId][] = $trx;
            $data['total_pembayaran'] += $trx->nominal;
        }

        $this->load->view('admin/lap_hutang_cust_detail', $data);
    }


    ####### Fungsi Laporan Pengeluaran Umum Per Rumah (Detail Per Rumah) #####
    public function lap_out_total_perumah_form()
    {
        $data["judul"] = "Detail Harga Rumah";
        // $data['menus'] = $this->Menu_model->get_all();
        // $data['list_perum'] = $this->db->get('tm_perumahan')->result();

        $data['list_rumah'] = $this->db
            ->select('a.id as id_rumah, a.norumah, b.id as id_perum, b.nama as nama_perum')
            ->from('tm_rumah a')
            ->join('tm_perumahan b', 'b.id = a.id_perumahan', 'left')
            ->order_by('b.nama, a.norumah')
            ->get()
            ->result();

        $this->load->view('admin/lap_out_total_perumah_form', $data);
    }

    public function lap_out_total_perumah_view()
    {
        $data["judul"] = "Detail Pengeluaran Per Rumah";
        $id_rumah = (int) $this->input->post('id_rumah');

        $info_sql = "SELECT r.id AS id_rumah, r.norumah, p.nama AS nama_perum
                     FROM tm_rumah r
                     LEFT JOIN tm_perumahan p ON p.id = r.id_perumahan
                     WHERE r.id = ?";
        $data['rumah_info'] = $this->db->query($info_sql, [$id_rumah])->row();
        $data['id_rumah'] = $id_rumah;
        $data['report_date'] = date('d-m-Y');

        $sql = "SELECT k.id AS id_kateg, k.kateg AS nama_kateg, COALESCE(SUM(t.nominal), 0) AS total_pengeluaran
                FROM tm_kategori_pengeluaran k
                LEFT JOIN trx_transaksi t ON t.id_kateg = k.id
                    AND t.tipe_transaksi = 'keluar'
                    AND t.peruntukan = 'rumah'
                    AND t.id_rumah = ?
                GROUP BY k.id, k.kateg
                ORDER BY k.kateg";

        $data['list_rumah'] = $this->db->query($sql, [$id_rumah])->result();
        $this->load->view('admin/lap_out_total_perumah_view', $data);
    }

    public function lap_out_total_perumah_detail()
    {
        $id_rumah = (int) $this->input->post('id_rumah');
        $id_kateg = (int) $this->input->post('id_kateg');

        $sql = "SELECT tanggal, keterangan, nominal
                FROM trx_transaksi
                WHERE tipe_transaksi = 'keluar'
                    AND peruntukan = 'rumah'
                    AND id_rumah = ?
                    AND id_kateg = ?
                ORDER BY tanggal";

        $data = $this->db->query($sql, [$id_rumah, $id_kateg])->result();

        // Hitung total nominal
        $total = 0;
        foreach ($data as $row) {
            $total += $row->nominal;
        }

        echo json_encode(['status' => 'success', 'data' => $data, 'total' => $total]);
    }
}
