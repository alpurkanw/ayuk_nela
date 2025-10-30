<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Admin_Controller.php';

/**
 * Controller Induk untuk Halaman Admin.
 * Semua controller di dalam folder 'application/controllers/admin/'
 * harus mewarisi kelas ini untuk memastikan otentikasi.
 */
class Cperum extends MY_Admin_Controller

{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_perumahan', 'perum');
    }


    public function index()
    {
        // $data['account_list'] = $this->M_account->getAllAccounts();
        // $data['title'] = 'Manajemen Akun Keuangan';
        // echo "tes";
        // return;
        // perum
        $data['list_perum'] = $this->perum->getAllPerum()->result();
        $this->load->view('admin/perum_list', $data);
    }


    public function tambah()
    {
        // $data['account_list'] = $this->M_account->getAllAccounts();
        // $data['title'] = 'Manajemen Akun Keuangan';
        // echo "tes";
        // return;
        $data = "";
        $this->load->view('admin/perum_add', $data);
    }

    public function tambah_proses()
    {
        // 1. Ambil data dari formulir menggunakan input POST
        $data_perumahan = array(
            // 'id' diabaikan karena biasanya di-generate otomatis (AUTO_INCREMENT)
            'nama' => $this->input->post('nama'),
            'desk' => $this->input->post('deskripsi') // Sesuaikan dengan ID/NAME form
        );

        // 2. Kirim data ke Model untuk disimpan ke tabel tm_perumahan
        $insert = $this->perum->insert_perum($data_perumahan);

        // 3. Beri notifikasi dan redirect
        if ($insert) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data perumahan berhasil ditambahkan!</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menambahkan data perumahan.</div>');
        }

        // Redirect kembali ke halaman list perumahan
        redirect('admin/Cperum/tambah');

        // $data = "";
        // $this->load->view('admin/perum_add', $data);
    }



    // public function add_harga()
    // {
    //     // $data['account_list'] = $this->M_account->getAllAccounts();
    //     // $data['title'] = 'Manajemen Akun Keuangan';
    //     // echo "tes";
    //     // return;
    //     $data = "";
    //     $this->load->view('admin/perum_add_harga', $data);
    // }


    /**
     * Menangani proses penambahan akun baru.
     */
    public function add()
    {
        // Set aturan validasi untuk input form
        $this->form_validation->set_rules('noAkun', 'Nomor Akun', 'required|numeric|is_unique[accounts.no_account]');
        $this->form_validation->set_rules('deskripsiAkun', 'Deskripsi Akun', 'required');
        $this->form_validation->set_rules('kategoriAkun', 'Kategori Akun', 'required');

        // Atur pesan error khusus untuk validasi
        $this->form_validation->set_message('is_unique', '{field} sudah ada, silakan gunakan nomor lain.');
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
            $this->session->set_flashdata('pesan_error', validation_errors());
        } else {
            // Jika validasi berhasil, siapkan data untuk disimpan
            $data = [
                'no_account' => $this->input->post('noAkun'),
                'description_account' => $this->input->post('deskripsiAkun'),
                'category' => $this->input->post('kategoriAkun')
            ];

            $insert = $this->M_account->addAccount($data);

            if ($insert) {
                $this->session->set_flashdata('pesan_sukses', 'Akun berhasil ditambahkan!');
            } else {
                // Tangkap error dari database jika operasi gagal
                $db_error = $this->db->error();
                if (!empty($db_error['code'])) {
                    $this->session->set_flashdata('pesan_error', 'Gagal menambahkan akun. Error: ' . $db_error['message']);
                } else {
                    $this->session->set_flashdata('pesan_error', 'Terjadi kesalahan saat menambahkan akun.');
                }
            }
        }
        redirect('admin/account');
    }

    /**
     * Menangani proses pembaruan data akun.
     */
    public function update()
    {
        // Set aturan validasi
        $this->form_validation->set_rules('id_akun', 'ID Akun', 'required');
        $this->form_validation->set_rules('noAkun', 'Nomor Akun', 'required|numeric');
        $this->form_validation->set_rules('deskripsiAkun', 'Deskripsi Akun', 'required');
        $this->form_validation->set_rules('kategoriAkun', 'Kategori Akun', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('pesan_error', validation_errors());
        } else {
            $id_account = $this->input->post('id_akun');
            $data = [
                'no_account' => $this->input->post('noAkun'),
                'description_account' => $this->input->post('deskripsiAkun'),
                'category' => $this->input->post('kategoriAkun')
            ];

            $update = $this->M_account->updateAccount($id_account, $data);

            if ($update) {
                $this->session->set_flashdata('pesan_sukses', 'Akun berhasil diperbarui!');
            } else {
                $db_error = $this->db->error();
                if (!empty($db_error['code'])) {
                    $this->session->set_flashdata('pesan_error', 'Gagal memperbarui akun. Error: ' . $db_error['message']);
                } else {
                    $this->session->set_flashdata('pesan_error', 'Terjadi kesalahan saat memperbarui akun.');
                }
            }
        }
        redirect('admin/account');
    }

    /**
     * Menangani proses penghapusan akun.
     *
     * @param int $id ID Akun
     */
    public function delete($id = null)
    {
        if ($id === null) {
            $this->session->set_flashdata('pesan_error', 'ID akun tidak ditemukan.');
        } else {
            $delete = $this->M_account->deleteAccount($id);

            if ($delete) {
                $this->session->set_flashdata('pesan_sukses', 'Akun berhasil dihapus!');
            } else {
                $db_error = $this->db->error();
                if (!empty($db_error['code'])) {
                    $this->session->set_flashdata('pesan_error', 'Gagal menghapus akun. Error: ' . $db_error['message']);
                } else {
                    $this->session->set_flashdata('pesan_error', 'Terjadi kesalahan saat menghapus akun.');
                }
            }
        }
        redirect('admin/Account');
    }
}
