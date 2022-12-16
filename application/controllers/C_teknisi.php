<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_teknisi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_teknisi');
		$this->load->model('m_departemen');
		$this->load->model('m_karyawan');
		$this->load->library('pdf');
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("C_login"));
		}
	}

	public function index()
	{

		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		//body
		$data["departemen"] = $this->m_departemen->tampil_data()->result();
		$this->load->view('pages/teknisi/f_teknisi',$data);
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/teknisi/vue_teknisi');

	}

	public function data_teknisi()
	{
		$data = array();
		$data=$this->m_teknisi->tampil_data()->result();
		echo json_encode($data);
	}

	public function simpan_data(){
		$id_teknisi 	= $this->m_teknisi->id_teknisi();
		$id_users	 	= $this->m_karyawan->id_user();
		$id_user		= $this->session->userdata["id_user"];
		$id_departemen	= $this->input->post('id_departemen');
		$nama			= $this->input->post('nama_teknisi');
		$email 			= $this->input->post('email');
		$no_tlp 		= $this->input->post('no_tlp');

		$username	= trim($nama);
		$pass 		= trim(md5($id_teknisi));

		// $id_inventaris 	= $this->m_inventaris->id_permintaan();
		// $id_teknisi		= $this->input->post('id_teknisi');
		// $ket_permintaan  = $this->input->post('ket_permintaan');
		// $ket_tujuan		= $this->input->post('ket_tujuan');
		// $gambar			= $this->input->post('gambar');

		// $config['upload_path'] = './assets/img/inventaris/';
		// $config['allowed_types'] = 'gif|jpg|png';
		// $config['max_size']	= '1000';
		// $config['max_width']  = '2000';
		// $config['max_height']  = '1024';

			// $cek_inventaris=$this->m_inventaris->cek_inv($id_departemen,$nama);
			// 	if($cek_inventaris->num_rows() > 0){
			// 		$this->session->set_flashdata('msg','
			//        	<div class="alert alert-danger" role="alert">
			//      	<b><span class="glyphicon glyphicon-envelope">
			// 		</span></b>Data departemen '.$nama.' di '.$id_departemen.' sudah ada
			//         </div>');
			//         redirect('C_inventaris'); 
			// 	} else {

		$teknisi=array(
			'id_teknisi'		=> $id_teknisi,
			'id_user' 			=> $id_users,
			'id_departemen' 	=> $id_departemen,
			'nama_teknisi' 		=> $nama,
			'email'				=> $email,
			'no_tlpn'			=> $no_tlp
		);

		$user=array(
			'id_user'		=> $id_users,
			'username' 		=> $username,
			'password' 		=> $pass,
			'level' 		=> 'TEKNISI',
			'status'		=> 'AKTIF'
			
		);
		// $this->upload->initialize($config);
		// $this->upload->do_upload('gambar')
		// $permintaaan=array(
		// 	'id_inventaris'		=> $id_inventaris,
		// 	'id_user' 			=> $id_user,
		// 	'id_departemen' 	=> $id_departemen,
		// 	'nama_inventaris' 	=> $nama,
		// 	'keterangan'		=> $keterangan
		// );

		
		$this->m_teknisi->simpan_teknisi($teknisi);
		$this->db->insert('tb_user',$user);
			$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di tambahan.
	        </div>');
	        redirect('C_teknisi');
	    
	   //}
	}

	public function update_data(){
		$id_teknisi 	= $this->input->post('id_teknisi');
		$id_user		= $this->session->userdata["id_user"];
		$id_departemen	= $this->input->post('id_departemen');
		$nama			= $this->input->post('nama_teknisi');
		$email 			= $this->input->post('email');
		$no_tlp 		= $this->input->post('no_tlp');


			// $cek_teknisi=$this->m_inventaris->cek_inv($id_departemen,$nama);
			// 	if($cek_inventaris->num_rows() > 0){
			// 		$this->session->set_flashdata('msg','
			//        	<div class="alert alert-danger" role="alert">
			//      	<b><span class="glyphicon glyphicon-envelope">
			// 		</span></b>Data departemen '.$nama.' di '.$id_departemen.' sudah ada
			//         </div>');
			//         redirect('C_inventaris');
			// 	} else {


		$data=array(

			'id_user' 			=> $id_user,
			'id_departemen' 	=> $id_departemen,
			'email'				=> $email,
			'no_tlpn'			=> $no_tlp
		);

		$where_data=array(
			'id_teknisi'	=> $id_teknisi
		);

		$this->m_teknisi->update_teknisi($where_data, $data);
		
			$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di update.
	        </div>');
	        redirect('C_teknisi');
	    
	    //}
	}

	function delete_data($id_teknisi)
	{
		$this->m_teknisi->hapus_data($id_teknisi);
	}

}
