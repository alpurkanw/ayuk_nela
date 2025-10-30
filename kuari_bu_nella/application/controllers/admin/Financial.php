<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Financial extends MY_Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memuat model untuk berinteraksi dengan database
        // Anda perlu membuat model ini terlebih dahulu (misalnya Financial_model)
        $this->load->model('M_financial');
        $this->load->library('form_validation'); // Memuat library validasi form
    }

    // public function account()
    // {
    //     // echo "tes Home";
    //     // return;
    //     // $data['menus'] = $this->Menu_model->get_all();
    //     $this->load->view('admin/master_account');
    // }

    public function uangMasuk()
    {
        // Mengambil semua data akun pengeluaran dari model
        $data['accounts'] = $this->M_financial->get_income_accounts();
        $this->load->view('admin/trx_uang_masuk', $data);
    }

    public function uangKeluar()
    {
        // Mengambil semua data akun pengeluaran dari model
        $data['accounts'] = $this->M_financial->get_expense_accounts();

        // Menampilkan form untuk input uang keluar dan mengirimkan data akun
        $this->load->view('admin/trx_uang_keluar', $data);
    }

    /**
     * Memproses data dari formulir uang masuk.
     */
    public function prosesUangMasuk()
    {
        // Aturan validasi
        $this->form_validation->set_rules('tanggalTransaksi', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('jenisPemasukan', 'Jenis Pemasukan', 'required');
        $this->form_validation->set_rules('jumlahUangMasuk', 'Jumlah Uang Masuk', 'required');

        // print_r($_REQUEST);
        // return;

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke formulir dengan error
            $this->load->view('admin/trx_uang_masuk'); // atau view yang sesuai
        } else {
            // Ambil data dari form

            // print_r($_REQUEST);
            // return;
            $tanggalTransaksi = $this->input->post('tanggalTransaksi');
            $jenisPemasukan = $this->input->post('jenisPemasukan');
            $jumlahUangMasuk = $this->input->post('jumlahUangMasuk');
            $keterangan = $this->input->post('keterangan');

            // Persiapan data untuk disimpan ke database
            // Kunci array disesuaikan dengan kolom di tabel `transaksi`
            $data = [
                'tipe_transaksi' => 'masuk', // Menentukan tipe transaksi
                'tanggal' => $tanggalTransaksi,
                'jenis' => $jenisPemasukan,
                'jumlah' => $jumlahUangMasuk,
                'keterangan' => $keterangan,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Panggil model untuk menyimpan data ke database
            $is_success = $this->M_financial->insert_uang_masuk($data);

            if ($is_success) {
                // Set flashdata untuk pesan sukses
                $this->session->set_flashdata('success_message', 'Data uang masuk berhasil disimpan!');
                // Redirect ke halaman uang masuk setelah sukses
                redirect('admin/financial/uangMasuk');
            } else {
                // Set flashdata untuk pesan error
                $this->session->set_flashdata('error_message', 'Gagal menyimpan data uang masuk. Silakan coba lagi.');
                // Redirect kembali ke halaman form
                redirect('admin/financial/uangMasuk');
            }
        }
    }

    public function prosesUangKeluar()
    {
        // Aturan validasi untuk form uang keluar
        $this->form_validation->set_rules('tanggalTransaksi', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('jenisPengeluaran', 'Jenis Pengeluaran', 'required');
        $this->form_validation->set_rules('jumlahUangKeluar', 'Jumlah Uang Keluar', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke formulir dengan error
            $this->session->set_flashdata('error_message', validation_errors());
            $this->load->view('admin/trx_uang_keluar');
        } else {
            // Ambil data dari form uang keluar
            $tanggalTransaksi = $this->input->post('tanggalTransaksi');
            $jenisPengeluaran = $this->input->post('jenisPengeluaran');
            $jumlahUangKeluar = $this->input->post('jumlahUangKeluar');
            $keterangan = $this->input->post('keterangan');

            // Persiapan data untuk disimpan ke database
            $data = [
                'tipe_transaksi' => 'keluar', // Menentukan tipe transaksi sebagai 'keluar'
                'tanggal' => $tanggalTransaksi,
                'jenis' => $jenisPengeluaran,
                'jumlah' => $jumlahUangKeluar,
                'keterangan' => $keterangan,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Panggil model untuk menyimpan data pengeluaran
            $is_success = $this->M_financial->insert_uang_keluar($data);

            if ($is_success) {
                $this->session->set_flashdata('success_message', 'Data uang keluar berhasil disimpan!');
                redirect('admin/financial/uangKeluar');
            } else {
                $this->session->set_flashdata('error_message', 'Gagal menyimpan data uang keluar. Silakan coba lagi.');
                redirect('admin/financial/uangKeluar');
            }
        }
    }
}
