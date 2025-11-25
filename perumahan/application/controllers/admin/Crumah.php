<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Perbaikan: Tambahkan baris ini untuk memuat kelas induk secara manual.
require_once APPPATH . 'core/MY_Admin_Controller.php';


class Crumah extends MY_Admin_Controller

{
    public function __construct()
    {
        parent::__construct();
        // Memuat model M_account untuk berinteraksi dengan tabel 'accounts'
        $this->load->model('M_rumah', 'rmh');
        $this->load->model('M_perumahan', 'perum');

        $this->load->model('M_jns_harga', 'jns_hrg');

        $this->load->model('M_trx_penj_rumah_harga', 'harga');

        // // Memuat library yang dibutuhkan
        $this->load->library('form_validation');
        // $this->load->library('session');
        // print_r($_SESSION);
        // return;
    }


    public function index()
    {
        // $data['account_list'] = $this->M_account->getAllAccounts();
        // $data['title'] = 'Manajemen Akun Keuangan';
        // echo "tes";
        // return;
        $data["judul"] = "List Rumah";
        $data["list_rumah"] = $this->rmh->getAllRumah()->result_array();

        $this->load->view('admin/rumah_list', $data);
    }

    public function all()
    {
        // $data['account_list'] = $this->M_account->getAllAccounts();
        // $data['title'] = 'Manajemen Akun Keuangan';
        // echo "tes";
        // return;
        $data["judul"] = "List Semua Rumah";
        $data["list_rumah"] = $this->rmh->getAllRumah()->result_array();

        $this->load->view('admin/rumah_list_all', $data);
    }


    public function tambah()
    {
        // $data['account_list'] = $this->M_account->getAllAccounts();
        // $data['title'] = 'Manajemen Akun Keuangan';
        // print_r($_REQUEST);
        // return;
        $data['list_perum'] = $this->perum->getAllPerum()->result();

        // $data = "";
        $this->load->view('admin/rumah_tambah', $data);
    }
    public function tambah_proses()
    {

        // cek duplikasi rumah 


        $id_perumahan = $this->input->post('id_perumahan');
        $no_rumah = strtoupper($this->input->post('no_rumah'));

        // sudah ada atau belum rumah itu  
        $is_duplicate = $this->rmh->cek_duplikasi_rumah($id_perumahan, $no_rumah);

        if (!$is_duplicate) {
            $data_rumah = array(
                'id_perumahan' => $this->input->post('id_perumahan'),
                'norumah'     => strtoupper($this->input->post('no_rumah')),
                'keterangan'    => $this->input->post('deskripsi'),
                'harga_jual'   => $this->input->post('harga_jual')

            );

            $insert = $this->rmh->addRumah($data_rumah);

            if ($insert) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data Rumah **' . $this->input->post('no_rumah') . '** berhasil ditambahkan!</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Terjadi kesalahan database saat mencoba menyimpan Data Rumah.</div>');
            }

            redirect('admin/Crumah/tambah');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Rumah **' . $this->input->post('no_rumah') . '** Sudah pernah didaftarkan</div>');
            redirect('admin/Crumah/tambah');
        }
    }


    public function get_rumah_by_perum()
    {
        $id_perum = $this->input->post('id_perum');

        if ($id_perum) {
            // Panggil Model untuk mengambil data rumah

            $list_rumah = $this->rmh->get_rumah_by_perum_id($id_perum)->result();
            echo json_encode($list_rumah);
        } else {
            echo json_encode([]);
        }
    }
    public function get_rumah_by_perum_blm_terjual()
    {
        $id_perum = $this->input->post('id_perum');

        if ($id_perum) {
            // Panggil Model untuk mengambil data rumah

            $list_rumah = $this->rmh->get_rumah_by_perum_blm_terjual($id_perum)->result();
            echo json_encode($list_rumah);
        } else {
            echo json_encode([]);
        }
    }

    public function get_rumah_terjual_by_perum()
    {
        $id_perum = $this->input->post('id_perum');

        if ($id_perum) {
            // Panggil Model untuk mengambil data rumah

            $list_rumah = $this->rmh->get_rumah_terjual_by_perum($id_perum)->result();
            echo json_encode($list_rumah);
        } else {
            echo json_encode([]);
        }
    }





    public function rumah_add_item_harga()
    {

        $data["judul"] = "Tambahkan Item Harga Rumah";
        // return;
        $data['list_perum'] = $this->perum->getAllPerum()->result();
        $data["list_harga"] = $this->jns_hrg->getAllJns_harga()->result();

        // $data = "";
        $this->load->view('admin/rumah_add_item_harga_form', $data);
    }

    public function rumah_add_item_harga_proses()
    {


        $nominal = $this->input->post('nominal');
        $id_jual = $this->input->post('id_jual');
        $id_jenis = explode("|", $this->input->post('id_jenis')); // ID Kategori Pengeluaran



        $dataharga = array(
            'id_penj_rumah'       => $id_jual,
            'id_jns'       => $id_jenis[0],
            'nama_harga'       => $id_jenis[1],
            'nominal'       => $nominal
        );

        // 3. Simpan data ke Model (Asumsi fungsi Model adalah addTrx)
        $insert = $this->harga->addharga($dataharga);

        // 4. Beri notifikasi dan redirect
        if ($insert) {

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success">Penambahan Harga  Berhasil Diinput </div>'
            );
        } else {
            // Gagal menyimpan
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger">Penambahan Harga Gagal Diinput !!! </div>'
            );
        }

        // Redirect kembali ke form pengeluaran (atau ke halaman list transaksi)
        redirect('admin/Crumah/rumah_add_item_harga');
    }

    public function getListHarga($id_perum, $id_rumah)
    {

        $list_harga = $this->rmh->getAllHarga($id_perum, $id_rumah)->result();

        echo json_encode($list_harga);
    }
}
