<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Sopir extends MY_Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Memuat model sopir
        $this->load->model('M_sopir');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Manajemen Sopir';
        $data['sopir_list'] = $this->M_sopir->get_all_sopir();

        $this->load->view('admin/master_sopir', $data); // Pastikan nama view sudah benar
    }

    public function add()
    {
        $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required|trim|is_unique[sopir.nama_lengkap]');
        $this->form_validation->set_rules('nomorTelepon', 'Nomor Telepon', 'required|trim|numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('nomorPlat', 'Nomor Plat Kendaraan', 'required|trim'); // Aturan is_unique dihapus

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan_error', validation_errors());
        } else {
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
        }
        redirect('admin/Sopir/index');
    }

    // Tambahkan fungsi ini di dalam class Sopir extends CI_Controller
    public function getSopirById($id)
    {
        $sopir = $this->M_sopir->get_sopir_by_id($id);
        if ($sopir) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($sopir));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Data sopir tidak ditemukan.']));
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('id_sopir', 'ID Sopir', 'required|numeric');
        $this->form_validation->set_rules('namaLengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nomorTelepon', 'Nomor Telepon', 'required|trim|numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('nomorPlat', 'Nomor Plat Kendaraan', 'required|trim'); // Aturan is_unique dihapus

        $id = $this->input->post('id_sopir');
        $original_no_plat = $this->M_sopir->get_sopir_by_id($id)->no_plat;
        if ($this->input->post('nomorPlat') != $original_no_plat) {
            $this->form_validation->set_rules('nomorPlat', 'Nomor Plat Kendaraan', 'is_unique[sopir.no_plat]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan_error', validation_errors());
        } else {
            $data = [
                'nama_lengkap'    => $this->input->post('namaLengkap', TRUE),
                'no_telp'         => $this->input->post('nomorTelepon', TRUE),
                'alamat'          => $this->input->post('alamat', TRUE),
                'no_plat'         => $this->input->post('nomorPlat', TRUE),
                'keterangan_lain' => $this->input->post('keteranganLain', TRUE),
            ];
            $affected_rows = $this->M_sopir->update_sopir($id, $data);
            if ($affected_rows > 0) {
                $this->session->set_flashdata('pesan_sukses', 'Data sopir berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('pesan_error', 'Tidak ada perubahan pada data sopir.');
            }
        }
        redirect('admin/Sopir/index');
    }

    public function delete($id = null)
    {
        if ($id === null || !is_numeric($id)) {
            $this->session->set_flashdata('pesan_error', 'ID sopir tidak valid.');
        } else {
            $affected_rows = $this->M_sopir->delete_sopir($id);
            if ($affected_rows > 0) {
                $this->session->set_flashdata('pesan_sukses', 'Data sopir berhasil dihapus!');
            } else {
                $this->session->set_flashdata('pesan_error', 'Gagal menghapus data sopir atau data tidak ditemukan.');
            }
        }
        redirect('admin/Sopir/index');
    }
}
