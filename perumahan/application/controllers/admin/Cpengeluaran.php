<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Cpengeluaran extends MY_Admin_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kategori_pengeluaran', 'kateg');
        $this->load->model('M_transaksi', 'trx');
    }


    public function list_kateg()
    {
        $data["judul"] = "Kategori Pengeluaran";
        $data["ketegs"] = $this->kateg->getAllKategs()->result_array();
        $this->load->view('admin/kategori_list', $data);
    }

    public function add_kateg_form()
    {
        $data["judul"] = "Kategori Pengeluaran";
        $this->load->view('admin/kategori_add_form', $data);
    }


    public function add_kateg_proses()
    {
        // Set aturan validasi untuk input form
        $this->form_validation->set_rules('kategori', 'Jenis Kategori', 'required|is_unique[tm_kategori_pengeluaran.kateg]');


        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
            $this->session->set_flashdata('pesan', validation_errors());
        } else {
            // Jika validasi berhasil, siapkan data untuk disimpan
            $data = [
                'kateg' => $this->input->post('kategori'),
            ];

            $insert = $this->kateg->addKategori($data);

            if ($insert) {
                // $this->session->set_flashdata('pesan', 'Akun berhasil ditambahkan!');
                $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil ditambahkan!</div>');
            }
        }
        redirect('admin/Cpengeluaran/add_kateg_form');
    }

    public function trx_out_rmh_form()
    {
        $data["judul"] = "TRX Pengeluaran";
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $data["ketegs"] = $this->kateg->getAllkategs()->result();

        $this->load->view('admin/trx_out_rmh_form', $data);
    }


    public function trx_out_rmh_proses()
    {
        // 1. Ambil data dari POST
        // print_r($_REQUEST);
        // return;


        $rumah = explode("|", $this->input->post('norumah'));
        $jenis_harga = explode("|", $this->input->post('jns_harga'));

        $perumahan = explode("|", $this->input->post('id_perumahan'));
        // print_r($rumah);


        // $id_perumahan = $this->input->post('id_perumahan');
        // $id_rumah     = $this->input->post('norumah'); // Nama field di form adalah 'norumah', ini adalah ID unit rumah
        // $id_kateg     = $this->input->post('jns_harga'); // ID Kategori Pengeluaran
        $nominal      = $this->input->post('nominal'); // Sudah dibersihkan dari format ribuan oleh jQuery sebelum submit
        $keterangan   = $this->input->post('keterangan');

        // 2. Siapkan data untuk tabel trx_transaksi
        $data_transaksi = array(
            'tipe_transaksi' => 'keluar', // Pengeluaran
            'id_perum'       => $perumahan[0],
            'nama_perum'       => $perumahan[1],
            'peruntukan'     => 'rumah', // Pengeluaran khusus untuk Rumah
            'id_rumah'       => $rumah[0],
            'norumah'       => $rumah[1],
            'id_kateg'       => $jenis_harga[0],
            'nama_kateg'       => $jenis_harga[1],
            'tanggal'        => date('Ymd'), // Menggunakan tanggal hari ini
            'keterangan'     => $keterangan,
            'nominal'        => $nominal
        );

        // 3. Simpan data ke Model (Asumsi fungsi Model adalah addTrx)
        // $insert = $this->trx->addOutPerRumah($data_transaksi);
        $insert = $this->trx->insertTrx($data_transaksi);

        // 4. Beri notifikasi dan redirect
        if ($insert) {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success">Transaksi Pengeluaran sebesar **Rp ' . number_format($nominal) . '** berhasil dicatat!</div>'
            );
        } else {
            // Gagal menyimpan
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger">Terjadi kesalahan database saat mencoba menyimpan Transaksi Pengeluaran.</div>'
            );
        }

        // Redirect kembali ke form pengeluaran (atau ke halaman list transaksi)
        redirect('admin/Cpengeluaran/trx_out_rmh_form');
    }


    public function trx_out_perum_form()
    {
        $data["judul"] = "TRX Pengeluaran";
        $data['list_perum'] = $this->db->get('tm_perumahan')->result();
        $data["ketegs"] = $this->kateg->getAllkategs()->result();

        $this->load->view('admin/trx_out_perum_form', $data);
    }

    public function trx_out_perum_proses()
    {

        // print_r($_REQUEST);
        // return;
        $jenis_harga = explode("|", $this->input->post('jns_harga'));
        // echo $jenis_harga[1];
        // return;
        $perumahan = explode("|", $this->input->post('id_perumahan'));
        // print_r($rumah);
        $nominal      = $this->input->post('nominal'); // Sudah dibersihkan dari format ribuan oleh jQuery sebelum submit
        $keterangan   = $this->input->post('keterangan');

        // 2. Siapkan data untuk tabel trx_transaksi
        $data_transaksi = array(
            'tipe_transaksi' => 'keluar', // Pengeluaran
            'id_perum'       => $perumahan[0],
            'nama_perum'       => $perumahan[1],
            'peruntukan'     => 'umum', // Pengeluaran khusus untuk Rumah
            'id_rumah'       => 0,
            'norumah'       => '',
            'id_kateg'       => $jenis_harga[0],
            'nama_kateg'       => $jenis_harga[1],
            'tanggal'        => date('Ymd'), // Menggunakan tanggal hari ini
            'keterangan'     => $keterangan,
            'nominal'        => $nominal
        );

        // 3. Simpan data ke Model (Asumsi fungsi Model adalah addTrx)
        // $insert = $this->trx->addOutPerRumah($data_transaksi);

        $insert = $this->trx->insertTrx($data_transaksi);

        // 4. Beri notifikasi dan redirect
        if ($insert) {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success">Transaksi Pengeluaran sebesar **Rp ' . number_format($nominal) . '** berhasil dicatat!</div>'
            );
        } else {
            // Gagal menyimpan
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger">Terjadi kesalahan database saat mencoba menyimpan Transaksi Pengeluaran.</div>'
            );
        }

        // Redirect kembali ke form pengeluaran (atau ke halaman list transaksi)
        redirect('admin/Cpengeluaran/trx_out_perum_form');
    }
}
