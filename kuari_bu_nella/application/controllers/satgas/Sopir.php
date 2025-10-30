<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Satgas_Controller.php';

class Sopir extends MY_Satgas_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_sopir');
    }

    public function tambah()
    {
        // Fungsi ini bisa digunakan untuk menampilkan form penjualan
        // Jika form ada di view terpisah, Anda bisa muat view di sini
        $data['title'] = 'Input Data Sopir';
        $this->load->view('satgas/f_pend_sopir', $data); // Sesuaikan path view Anda
    }

    public function add()
    {
        // Aturan validasi
        $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required|trim|is_unique[sopir.nama_lengkap]');
        $this->form_validation->set_rules('nomorTelepon', 'Nomor Telepon', 'required|trim|numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('nomorPlat', 'Nomor Plat Kendaraan', 'required|trim|is_unique[sopir.no_plat]'); // Menambahkan is_unique agar nomor plat juga unik

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi GAGAL, muat kembali view form secara langsung.
            // Ini memastikan fungsi form_error() dapat menampilkan pesan kesalahan.
            $param['judul'] = "Pendaftaran Sopir";
            $this->load->view('satgas/f_pend_sopir', $param); // Ganti dengan nama view Anda yang benar
        } else {
            // Jika validasi BERHASIL, proses penyimpanan data
            $data = [
                'nama_lengkap'    => $this->input->post('namaLengkap', TRUE),
                'no_telp'         => $this->input->post('nomorTelepon', TRUE),
                'alamat'          => $this->input->post('alamat', TRUE),
                'no_plat'         => $this->input->post('nomorPlat', TRUE),
                'keterangan_lain' => $this->input->post('keteranganLain', TRUE),
            ];

            $insert_id = $this->M_sopir->insert_sopir($data);
            if ($insert_id) {
                $this->session->set_flashdata('pesan_sukses', 'Data sopir berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('pesan_error', 'Gagal menambahkan data sopir.');
            }
            // Redirect hanya jika proses BERHASIL
            redirect('satgas/Sopir/tambah');
        }
    }
}
