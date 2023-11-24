<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

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
        $data['produk'] = $this->db->select(['produk.*', 'kategori.nama_kategori', 'status.nama_status'])
            ->from('produk')
            ->join('kategori', 'kategori.id_kategori = produk.kategori_id', 'left')
            ->join('status', 'status.id_status = produk.status_id', 'left')
            ->get()->result_array();

		$this->load->view('layouts/header');
		$this->load->view('produk', $data);
		$this->load->view('layouts/footer');
	}
    public function tambah() {
        $data['kategori'] = $this->db->get('kategori')->result_array(); 
        $data['status'] = $this->db->get('status')->result_array(); 

		$this->load->view('layouts/header');
		$this->load->view('tambah_produk', $data);
		$this->load->view('layouts/footer');
    }
    public function create() {
        $post = $this->input->post();

        echo "<pre>";
        print_r($post);
        $data = array(
            'nama_produk' => $post['nama_produk'],
            'harga' => $post['harga_produk'],
            'kategori_id' => $post['kategori'],
            'status_id' => $post['status']
        );

        $this->db->insert('produk', $data);

        redirect(base_url('/produk'));

    }
    public function edit($id) {
        $data['kategori'] = $this->db->get('kategori')->result_array();
        $data['status'] = $this->db->get('status')->result_array();
        $data['produk'] = $this->db->select('*')->from('produk')->where('id_produk', $id)->get()->row();

        $this->load->view('layouts/header');
        $this->load->view('edit_produk', $data);
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
