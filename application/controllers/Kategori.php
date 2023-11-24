<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at πhttp://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
    function __construct() {
        parent::__construct();
    }
	public function index()
	{
        $data['kategori'] = $this->db->select('*')
            ->from('kategori')
            ->get()->result_array();

		$this->load->view('layouts/header');
		$this->load->view('kategori', $data);
		$this->load->view('layouts/footer');
	}
    public function tambah() {
		$this->load->view('layouts/header');
		$this->load->view('tambah_kategori');
		$this->load->view('layouts/footer');
    }
    public function create() {
        $post = $this->input->post();

        $data = array(
            'nama_kategori' => $post['nama_kategori'],
        );

        $this->db->insert('kategori', $data);

        redirect(base_url('/kategori'));

    }
    public function edit($id) {
        $data['kategori'] = $this->db->select('*')->from('kategori')->where('id_kategori', $id)->get()->row();

        $this->load->view('layouts/header');
        $this->load->view('edit_kategori', $data);
        $this->load->view('layouts/footer');
    }
    public function update($id) {
        $post = $this->input->post();

        $set = array(
            'nama_produk' => $post['nama_produk'],
            'harga' => $post['harga_produk'],
            'kategori_id' => $post['kategori'],
            'status_id' => $post['status']
        );

        $this->db->set($set)->where('id_produk', $id)->update('produk');

        redirect(base_url('/produk'));
    }
    public function delete($id) {
        $this->db->delete('produk', array('id_produk' => $id));

        redirect(base_url('/produk'));
    }
    public function getDataFromAPI() {
        $curl = curl_init();

        $username = "tesprogrammer".date('dmy')."C".date('H', strtotime('+1 hour'));
        $passwordString = "bisacoding-".date('d-m-y');
        $password = md5($passwordString);
        $dataString = "username=".$username."&password=".$password;

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://recruitment.fastprint.co.id/tes/api_tes_programmer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $dataString,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $responseArray = json_decode($response, true);

        $dataKategori = [];
        $dataStatus = [];
        foreach ($responseArray['data'] as $key => $value) {
            $kategoriCheck = $this->db->select('*')->from('kategori')->like('nama_kategori', $value["kategori"])->get()->num_rows();
            $statusCheck = $this->db->select('*')->from('status')->like('nama_status', $value["status"])->get()->num_rows();
            if($kategoriCheck == 0) {
                $dataKategori[] = $value["kategori"];
                $dataKategoriInsert = array(
                    'nama_kategori' => $value["kategori"]
                );
                $this->db->insert('kategori', $dataKategoriInsert);
            }
            if($statusCheck == 0) {
                $dataStatus[] = $value['status'];
                $dataStatusInsert = array(
                    'nama_status' => $value["status"]
                );
                $this->db->insert('status', $dataStatusInsert);
            }

            $kategoriInsert = $this->db->select('*')->from('kategori')->like('nama_kategori', $value["kategori"])->get()->row();
            $statusInsert = $this->db->select('*')->from('status')->like('nama_status', $value["status"])->get()->row();
            $dataProduk = array(
                'nama_produk' => $value['nama_produk'],
                'harga' => $value['harga'],
                'kategori_id' => $kategoriInsert->id_kategori,
                'status_id'	 => $statusInsert->id_status
            );
            $this->db->insert('produk', $dataProduk);
        }

        echo json_encode(array('message' => 'success'));
    }
}
