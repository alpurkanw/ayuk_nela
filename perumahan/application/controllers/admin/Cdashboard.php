<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Admin_Controller.php';

class Cdashboard extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_perumahan', 'perum');
    }

    public function per_perumahan()
    {
        $data['judul'] = 'Dashboard Per Perumahan';
        $data['list_perum'] = $this->db->order_by('nama', 'ASC')->get('tm_perumahan')->result();
        $this->load->view('admin/dsh_per_perumahan_form', $data);
    }

    public function per_perumahan_view()
    {
        $id_perum = (int) $this->input->post('id_perumahan');
        if (!$id_perum) $id_perum = (int) $this->input->get('id_perumahan');
        if (!$id_perum) {
            redirect('admin/Cdashboard/per_perumahan');
            return;
        }

        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        if (!$perum) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Perumahan tidak ditemukan.</div>');
            redirect('admin/Cdashboard/per_perumahan');
            return;
        }

        $waktu_jakarta = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $data = [
            'judul' => 'Dashboard Per Perumahan',
            'perum' => $perum,
            'id_perum' => $id_perum,
            'report_date' => $waktu_jakarta->format('d/m/Y H:i:s') . ' WIB'
        ];
        $data['total_rumah'] = (int) $this->db->where('id_perumahan', $id_perum)->count_all_results('tm_rumah');
        $data['total_terjual'] = (int) $this->db->where('id_perum', $id_perum)->count_all_results('trx_penj_rumah');
        $data['total_belum_terjual'] = max(0, $data['total_rumah'] - $data['total_terjual']);
        $data['persen_terjual'] = $data['total_rumah'] ? ($data['total_terjual'] / $data['total_rumah']) * 100 : 0;

        $row = $this->db->query("SELECT COALESCE(SUM(harga_jual), 0) nominal FROM tm_rumah r WHERE r.id_perumahan = ? AND NOT EXISTS (SELECT 1 FROM trx_penj_rumah p WHERE p.id_rumah = r.id AND p.id_perum = ?)", [$id_perum, $id_perum])->row();
        $data['potensi_belum_terjual'] = $row ? (float) $row->nominal : 0;
        $row = $this->db->query("SELECT COALESCE(SUM(r.harga_jual), 0) nominal FROM trx_penj_rumah p JOIN tm_rumah r ON r.id = p.id_rumah WHERE p.id_perum = ?", [$id_perum])->row();
        $data['nilai_harga_jual_terjual'] = $row ? (float) $row->nominal : 0;
        $row = $this->db->query("SELECT COALESCE(SUM(h.nominal), 0) nominal FROM trx_penj_rumah_harga h JOIN trx_penj_rumah p ON p.id = h.id_penj_rumah WHERE p.id_perum = ?", [$id_perum])->row();
        $data['total_tagihan'] = $row ? (float) $row->nominal : 0;
        $row = $this->db->query("SELECT COALESCE(SUM(nominal), 0) nominal FROM trx_transaksi WHERE id_perum = ? AND tipe_transaksi = 'masuk'", [$id_perum])->row();
        $data['total_pembayaran'] = $row ? (float) $row->nominal : 0;
        $data['total_piutang'] = max(0, $data['total_tagihan'] - $data['total_pembayaran']);

        $row = $this->db->query("SELECT COALESCE(SUM(nominal), 0) nominal FROM trx_transaksi WHERE id_perum = ? AND tipe_transaksi = 'masuk'", [$id_perum])->row();
        $data['penerimaan_periode'] = $row ? (float) $row->nominal : 0;
        $row = $this->db->query("SELECT COALESCE(SUM(nominal), 0) nominal FROM trx_transaksi WHERE id_perum = ? AND tipe_transaksi = 'keluar'", [$id_perum])->row();
        $data['total_pengeluaran'] = $row ? (float) $row->nominal : 0;
        $row = $this->db->query("SELECT COALESCE(SUM(nominal), 0) nominal FROM trx_transaksi WHERE id_perum = ? AND tipe_transaksi = 'keluar' AND peruntukan = 'rumah'", [$id_perum])->row();
        $data['pengeluaran_rumah'] = $row ? (float) $row->nominal : 0;
        $row = $this->db->query("SELECT COALESCE(SUM(nominal), 0) nominal FROM trx_transaksi WHERE id_perum = ? AND tipe_transaksi = 'keluar' AND peruntukan = 'umum'", [$id_perum])->row();
        $data['pengeluaran_umum'] = $row ? (float) $row->nominal : 0;
        $data['saldo_kas'] = $data['penerimaan_periode'] - $data['total_pengeluaran'];
        $data['biaya_rata_rata_per_rumah'] = $data['total_rumah'] ? $data['total_pengeluaran'] / $data['total_rumah'] : 0;

        $data['pengeluaran_kategori'] = $this->db->query("SELECT COALESCE(NULLIF(nama_kateg, ''), 'Tanpa Kategori') AS nama_kateg,
                    SUM(nominal) AS nominal
                FROM trx_transaksi
                WHERE id_perum = ? AND tipe_transaksi = 'keluar'
                GROUP BY nama_kateg
                ORDER BY nominal DESC
                LIMIT 10", [$id_perum])->result();
        $data['penjualan_bulanan'] = $this->db->query("SELECT LEFT(p.tanggal, 6) bulan, COUNT(*) jumlah FROM trx_penj_rumah p WHERE p.id_perum = ? GROUP BY LEFT(p.tanggal, 6) ORDER BY bulan", [$id_perum])->result();
        $data['pengeluaran_bulanan'] = $this->db->query("SELECT LEFT(tanggal, 6) bulan, SUM(nominal) nominal FROM trx_transaksi WHERE id_perum = ? AND tipe_transaksi = 'keluar' GROUP BY LEFT(tanggal, 6) ORDER BY bulan", [$id_perum])->result();
        $data['penjualan_terbaru'] = $this->db->query("SELECT p.norumah, p.nama_cust, p.tanggal, r.mtd_jual, r.harga_jual FROM trx_penj_rumah p LEFT JOIN tm_rumah r ON r.id = p.id_rumah WHERE p.id_perum = ? ORDER BY p.tanggal DESC, p.id DESC LIMIT 5", [$id_perum])->result();
        $data['piutang_terbesar'] = $this->db->query("SELECT p.norumah, p.nama_cust,
                    COALESCE(SUM(h.nominal), 0) AS tagihan,
                    COALESCE(bayar.terbayar, 0) AS terbayar
                FROM trx_penj_rumah p
                JOIN trx_penj_rumah_harga h ON h.id_penj_rumah = p.id
                LEFT JOIN (
                    SELECT id_perum, id_rumah, SUM(nominal) AS terbayar
                    FROM trx_transaksi
                    WHERE tipe_transaksi = 'masuk'
                    GROUP BY id_perum, id_rumah
                ) bayar ON bayar.id_perum = p.id_perum AND bayar.id_rumah = p.id_rumah
                WHERE p.id_perum = ?
                GROUP BY p.id, p.norumah, p.nama_cust, bayar.terbayar
                HAVING SUM(h.nominal) > COALESCE(bayar.terbayar, 0)
                ORDER BY (SUM(h.nominal) - COALESCE(bayar.terbayar, 0)) DESC
                LIMIT 5", [$id_perum])->result();
        $data['status_rumah'] = $this->db->query("SELECT r.id, r.norumah, r.harga_jual, r.mtd_jual, MAX(p.nama_cust) nama_cust, MAX(p.tanggal) tanggal_jual, COALESCE((SELECT SUM(h.nominal) FROM trx_penj_rumah_harga h JOIN trx_penj_rumah ph ON ph.id = h.id_penj_rumah WHERE ph.id_perum = r.id_perumahan AND ph.id_rumah = r.id), 0) tagihan, COALESCE((SELECT SUM(t.nominal) FROM trx_transaksi t WHERE t.tipe_transaksi = 'masuk' AND t.id_perum = r.id_perumahan AND t.id_rumah = r.id), 0) terbayar, COALESCE((SELECT SUM(t.nominal) FROM trx_transaksi t WHERE t.tipe_transaksi = 'keluar' AND t.peruntukan = 'rumah' AND t.id_perum = r.id_perumahan AND t.id_rumah = r.id), 0) biaya_rumah FROM tm_rumah r LEFT JOIN trx_penj_rumah p ON p.id_rumah = r.id AND p.id_perum = r.id_perumahan WHERE r.id_perumahan = ? GROUP BY r.id, r.norumah, r.harga_jual, r.mtd_jual ORDER BY r.norumah", [$id_perum])->result();
        $this->load->view('admin/dsh_per_perumahan_view', $data);
    }

    public function laporan_pengeluaran($id_perum = null)
    {
        $id_perum = (int) $id_perum;
        if (!$id_perum) {
            redirect('admin/Cdashboard/per_perumahan');
            return;
        }

        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        if (!$perum) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Perumahan tidak ditemukan.</div>');
            redirect('admin/Cdashboard/per_perumahan');
            return;
        }

        $data['judul'] = 'Laporan Pengeluaran';
        $data['perum'] = $perum;
        $data['report_date'] = date('d/m/Y H:i:s') . ' WIB';
        $data['pengeluaran_kategori'] = $this->db->query("SELECT COALESCE(NULLIF(nama_kateg, ''), 'Tanpa Kategori') AS nama_kateg,
                    SUM(nominal) AS nominal
                FROM trx_transaksi
                WHERE id_perum = ? AND tipe_transaksi = 'keluar'
                GROUP BY nama_kateg
                ORDER BY nominal DESC", [$id_perum])->result();

        $total = $this->db->query("SELECT COALESCE(SUM(nominal), 0) AS nominal
            FROM trx_transaksi WHERE id_perum = ? AND tipe_transaksi = 'keluar'", [$id_perum])->row();
        $data['total_nominal'] = $total ? (float) $total->nominal : 0;

        $this->load->view('admin/lap_pengeluaran_per_kategori_view', $data);
    }

    public function laporan_monitoring_unit($id_perum = null)
    {
        $id_perum = (int) $id_perum;
        if (!$id_perum) {
            redirect('admin/Cdashboard/per_perumahan');
            return;
        }

        $perum = $this->db->get_where('tm_perumahan', ['id' => $id_perum])->row();
        if (!$perum) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Perumahan tidak ditemukan.</div>');
            redirect('admin/Cdashboard/per_perumahan');
            return;
        }

        $data['judul'] = 'Monitoring Seluruh Unit Rumah';
        $data['perum'] = $perum;
        $data['id_perum'] = $id_perum;
        $data['report_date'] = date('d/m/Y H:i:s') . ' WIB';
        $data['status_rumah'] = $this->db->query("SELECT r.id, r.norumah, r.harga_jual, r.mtd_jual,
                    MAX(p.nama_cust) nama_cust, MAX(p.tanggal) tanggal_jual,
                    COALESCE((SELECT SUM(h.nominal) FROM trx_penj_rumah_harga h JOIN trx_penj_rumah ph ON ph.id = h.id_penj_rumah WHERE ph.id_perum = r.id_perumahan AND ph.id_rumah = r.id), 0) tagihan,
                    COALESCE((SELECT SUM(t.nominal) FROM trx_transaksi t WHERE t.tipe_transaksi = 'masuk' AND t.id_perum = r.id_perumahan AND t.id_rumah = r.id), 0) terbayar,
                    COALESCE((SELECT SUM(t.nominal) FROM trx_transaksi t WHERE t.tipe_transaksi = 'keluar' AND t.peruntukan = 'rumah' AND t.id_perum = r.id_perumahan AND t.id_rumah = r.id), 0) biaya_rumah
                FROM tm_rumah r
                LEFT JOIN trx_penj_rumah p ON p.id_rumah = r.id AND p.id_perum = r.id_perumahan
                WHERE r.id_perumahan = ?
                GROUP BY r.id, r.norumah, r.harga_jual, r.mtd_jual
                ORDER BY r.norumah", [$id_perum])->result();

        $this->load->view('admin/lap_monitoring_unit_view', $data);
    }
}
