<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Material extends MY_Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Memuat model yang diperlukan
        $this->load->model('M_material'); // Nama file tanpa .php
        $this->load->library('form_validation');
        // Memuat library session, jika belum dimuat secara autoload
        $this->load->library('session');
    }

    public function index()
    {
        // Mengambil semua data material dari model
        $data['material_list'] = $this->M_material->getAllMaterials();

        // Data yang akan dikirim ke view
        $data['title'] = 'Manajemen Material';

        // Memuat view dengan data
        // echo "tes";
        // return;
        $this->load->view('admin/master_material', $data); // Asumsikan nama view-nya adalah master_material.php
    }

    public function add()
    {

        // Aturan validasi
        $this->form_validation->set_rules('namaMaterial', 'Nama Material', 'required');
        $this->form_validation->set_rules('hargaPerRitaseRaw', 'Harga per Ritase', 'required|numeric');
        $this->form_validation->set_rules('statusMaterial', 'Status', 'required');

        // Array ( [id_material] => [namaMaterial] => terigu [hargaPerRitase] => 30.000 [statusMaterial] => Aktif )
        // print_r($_REQUEST);
        // return;
        // Menjalankan validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
            $this->session->set_flashdata('pesan_error', 'Gagal menambahkan material. Pastikan semua data terisi dengan benar.');
            redirect('admin/material'); // Sesuaikan dengan URL controller
        } else {
            // Jika validasi berhasil, ambil data dari form
            $data = [
                'nama_material' => $this->input->post('namaMaterial'),
                'harga_per_ritase' => $this->input->post('hargaPerRitaseRaw'),
                'status' => $this->input->post('statusMaterial')
            ];

            // Panggil model untuk menyimpan data
            $insert = $this->M_material->addMaterial($data);
            // $db_error = $this->db->error();
            // print_r($db_error);
            // return;

            if ($insert) {
                $this->session->set_flashdata('pesan_sukses', 'Material berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('pesan_error', 'Terjadi kesalahan saat menambahkan material.');
            }
            redirect('admin/material');
        }
    }

    public function update()
    {
        // Aturan validasi
        $this->form_validation->set_rules('id_material', 'ID Material', 'required');
        $this->form_validation->set_rules('namaMaterial', 'Nama Material', 'required');
        $this->form_validation->set_rules('hargaPerRitaseRaw', 'Harga per Ritase', 'required|numeric');
        $this->form_validation->set_rules('statusMaterial', 'Status', 'required');

        // Menjalankan validasi
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan_error', 'Gagal memperbarui material. Pastikan semua data terisi dengan benar.');
        } else {
            // Ambil data dari form
            $id_material = $this->input->post('id_material');
            $data = [
                'nama_material' => $this->input->post('namaMaterial'),
                'harga_per_ritase' => $this->input->post('hargaPerRitaseRaw'),
                'status' => $this->input->post('statusMaterial')
            ];

            // Panggil model untuk memperbarui data
            $update = $this->M_material->updateMaterial($id_material, $data);

            if ($update) {
                $this->session->set_flashdata('pesan_sukses', 'Material berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('pesan_error', 'Terjadi kesalahan saat memperbarui material.');
            }
        }
        redirect('admin/material');
    }

    public function delete($id)
    {
        // Memanggil model untuk menghapus data
        $delete = $this->M_material->deleteMaterial($id);

        if ($delete) {
            $this->session->set_flashdata('pesan_sukses', 'Material berhasil dihapus!');
        } else {
            $this->session->set_flashdata('pesan_error', 'Terjadi kesalahan saat menghapus material.');
        }
        redirect('admin/material');
    }
}
