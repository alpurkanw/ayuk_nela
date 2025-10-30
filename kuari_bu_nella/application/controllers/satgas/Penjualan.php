<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Satgas_Controller.php';

class Penjualan extends MY_Satgas_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Memuat model yang diperlukan
        $this->load->model('M_transaksi'); // Ganti 'M_transaksi' jika nama model Anda berbeda
        $this->load->model('M_sopir');
        $this->load->model('M_material');

        // Ganti 'M_transaksi' jika nama model Anda berbeda
        $this->load->library('form_validation'); // Memuat library form validation
        $this->load->helper('url'); // Memuat helper URL
        // $this->load->helper('form'); // Memuat helper form (opsional, jika Anda menggunakan fungsi form CI)
    }

    public function index()
    {
        // Fungsi ini bisa digunakan untuk menampilkan form penjualan
        // Jika form ada di view terpisah, Anda bisa muat view di sini
        $data['title'] = 'Input Data Penjualan Material';

        $data['sopirs'] = $this->M_sopir->get_all_sopir();
        $data['materials'] = $this->M_material->getAllMaterials();

        $this->load->view('satgas/penjualan', $data);
    }

    public function proses_transaksi()
    {
        // 1. Atur aturan validasi form
        $this->form_validation->set_rules('tanggalTransaksi', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('id_sopir', 'Nama Sopir', 'required');
        $this->form_validation->set_rules('id_material', 'Jenis Material', 'required');
        $this->form_validation->set_rules('hargaPenjualanRaw', 'Harga Penjualan', 'required|numeric'); // Validasi harga murni
        $this->form_validation->set_rules('jumlahRitase', 'Jumlah Ritase', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('totalHargaRaw', 'Total Harga', 'required|numeric'); // Validasi total harga murni
        $this->form_validation->set_rules('jenisPenjualan', 'Jenis Penjualan', 'required');
        $this->form_validation->set_rules('tujuanPengangkutan', 'Tujuan Pengangkutan', 'required');

        // // Mengatur pesan error kustom (opsional)
        // $this->form_validation->set_message('required', '{field} wajib diisi.');
        // $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        // $this->form_validation->set_message('greater_than', '{field} harus lebih besar dari {param}.');

        // 2. Jalankan validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke form dengan error
            // Gunakan flashdata untuk pesan error jika Anda me-redirect
            $this->session->set_flashdata('pesan_error', validation_errors());
            redirect('satgas/penjualan'); // Arahkan kembali ke halaman form
        } else {
            // 3. Ambil data dari form
            $data_transaksi = array(
                'tanggal_transaksi'    => $this->input->post('tanggalTransaksi'),
                'id_sopir'           => $this->input->post('id_sopir'),

                'id_material'       => $this->input->post('id_material'),
                'harga_per_unit'       => $this->input->post('hargaPenjualanRaw'), // Ambil nilai numerik asli
                'jumlah_ritase'        => $this->input->post('jumlahRitase'),
                'total_harga'          => $this->input->post('totalHargaRaw'), // Ambil nilai numerik asli
                'jenis_penjualan'      => $this->input->post('jenisPenjualan'),
                'tujuan_pengangkutan'  => $this->input->post('tujuanPengangkutan'),
                'created_at'           => date('Y-m-d H:i:s'), // Opsional: Tambahkan timestamp
                'user_inp'             => $_SESSION["usernm"] // Opsional: Tambahkan timestamp
            );

            // 4. Panggil model untuk menyimpan data
            $insert_id = $this->M_transaksi->insert_data('transaksi_penjualan_material', $data_transaksi); // Sesuaikan nama tabel Anda

            if ($insert_id) {
                // Jika berhasil disimpan
                $this->session->set_flashdata('pesan_sukses', 'Data penjualan berhasil disimpan dengan ID: ' . $insert_id);
                redirect('satgas/penjualan/sukses/' . $insert_id); // Arahkan ke halaman sukses atau daftar transaksi
            } else {
                // Jika gagal disimpan
                $this->session->set_flashdata('pesan_error', 'Gagal menyimpan data penjualan. Silakan coba lagi.');
                redirect('satgas/penjualan'); // Arahkan kembali ke form
            }
        }
    }

    public function sukses($id)
    {
        // Halaman ini bisa menampilkan pesan sukses atau daftar transaksi terbaru
        $data['title'] = 'Transaksi Berhasil';


        $sql = " 
                SELECT * from transaksi_penjualan_material a
                LEFT JOIN sopir b on a.id_sopir = b.id_sopir
                LEFT JOIN materials c on a.id_material = c.id_material
                where id_transaksi = $id
            ";



        // echo $sql;
        // return;
        $data["trx"] =  $this->db->query($sql)->result();



        $this->load->view('satgas/trx_sukses', $data); // Sesuaikan path view Anda
    }
}



// <?php
// defined('BASEPATH') or exit('No direct script access allowed');

// class Penjualan extends CI_Controller
// {
//     public function __construct()
//     {
//         parent::__construct();
//         // Pastikan Anda memiliki 'Penjualan_model' di folder 'application/models/'
//         // Jika nama model Anda berbeda, sesuaikan di sini.
//         // $this->load->model('Penjualan_model');
//         $this->load->library('form_validation'); // Memuat library validasi form
//     }

//     public function index()
//     {
//         // Ini adalah tampilan form penjualan
//         $this->load->view('satgas/penjualan');
//     }

//     public function proses_transaksi()
//     {

//         $this->load->view('satgas/trx_sukses');
//         return;
//         // 1. Atur aturan validasi untuk setiap field
//         $this->form_validation->set_rules('tanggalTransaksi', 'Tanggal Transaksi', 'required');
//         $this->form_validation->set_rules('namaSopir', 'Nama Sopir', 'required');
//         $this->form_validation->set_rules('jenisMaterial', 'Jenis Material', 'required');
//         $this->form_validation->set_rules('hargaPenjualan', 'Harga Penjualan', 'required|numeric');
//         $this->form_validation->set_rules('tujuanPengangkutan', 'Tujuan Pengangkutan', 'required');

//         // Opsional: Atur pesan error kustom (jika diperlukan)
//         $this->form_validation->set_message('required', '%s harus diisi.');
//         $this->form_validation->set_message('numeric', '%s harus berupa angka.');

//         // 2. Jalankan validasi
//         if ($this->form_validation->run() == FALSE) {
//             // Jika validasi gagal, kembalikan ke form penjualan dengan error
//             $this->load->view('satgas/penjualan');
//         } else {
//             // Jika validasi berhasil, ambil data dari form
//             $data_transaksi = [
//                 'tanggal_transaksi' => $this->input->post('tanggalTransaksi'),
//                 'nama_sopir' => $this->input->post('namaSopir'),
//                 'jenis_material' => $this->input->post('jenisMaterial'),
//                 'harga_penjualan' => $this->input->post('hargaPenjualan'),
//                 'tujuan_pengangkutan' => $this->input->post('tujuanPengangkutan'),
//                 // Tambahkan field lain jika ada (misal: created_at, user_id, dll.)
//                 'id_transaksi' => 'TRX-' . date('YmdHis') . rand(100, 999) // Contoh ID transaksi sederhana
//             ];

//             // 3. Simpan data ke database melalui model
//             $insert_id = $this->Penjualan_model->simpan_transaksi($data_transaksi);

//             if ($insert_id) {
//                 // Jika penyimpanan berhasil, arahkan ke halaman sukses
//                 // Anda bisa mengirimkan data transaksi yang baru disimpan ke view sukses
//                 $data['transaksi'] = $data_transaksi; // Kirimkan data transaksi ke view
//                 $this->load->view('satgas/transaksi_sukses', $data); // Arahkan ke view transaksi_sukses
//             } else {
//                 // Jika penyimpanan gagal (misalnya ada masalah DB)
//                 $data['error_message'] = 'Gagal menyimpan transaksi ke database.';
//                 $this->load->view('satgas/penjualan', $data); // Kembali ke form dengan pesan error
//             }
//         }
//     }

//     // Fungsi checkout ini mungkin sudah tidak diperlukan jika semua proses ada di proses_transaksi
//     // Jika Anda punya flow checkout yang berbeda, silakan pertahankan.
//     public function checkout()
//     {
//         // $cart = $this->input->post('cart');
//         // Proses simpan ke database, dsb.
//         // echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil']);
//     }
// }
