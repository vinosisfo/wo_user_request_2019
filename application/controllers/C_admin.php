<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_admin');
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
		$this->load->view('pages/admin/f_admin');
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/admin/vue_admin');

	}

	public function data_admin()
	{
		$data = array();
		$data=$this->m_admin->tampil_data()->result();
		echo json_encode($data);
	}

	public function simpan_data(){
		$id_admin	= $this->m_admin->id_admin();
		$id_user	= $this->m_admin->id_user();
		$nama_admin	= $this->input->post('nama_admin');
		$no_tlp		= $this->input->post('no_tlp');
		$alamat		= $this->input->post('alamat');

		$username	= trim($nama_admin);
		$pass 		= trim(md5($id_user));

			// $cek_admin=$this->m_admin->cek_admin($nama_admin);
			// 	if($cek_admin->num_rows() > 0){
			// 		$this->session->set_flashdata('msg','
			//        	<div class="alert alert-info" role="alert">
			//      	<b><span class="glyphicon glyphicon-envelope">
			// 		</span></b>data berhasil di tambahan.
			//         </div>');
			//         redirect('c_admin');
			// 	} else {

		$admin=array(
			'id_admin'		=> $id_admin,
			'id_user'		=> $id_user,
			'nama_admin' 	=> $nama_admin,
			'no_tlp' 		=> $no_tlp,
			'alamat' 		=> $alamat
			
		);

		$user=array(
			'id_user'		=> $id_user,
			'id_admin'		=> $id_admin,
			'username' 		=> $username,
			'password' 		=> $pass,
			'level' 		=> 'ADMIN',
			'status'		=> 'AKTIF'
			
		);
		$this->m_admin->simpan_admin($admin);
		$this->m_admin->simpan_user($user);
			$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di tambahan.
	        </div>');
	        redirect('c_admin');
	    
	   //}
	}

	public function update_data(){
		$id_admin 		= $this->input->post('id_admin');
		$no_tlp			= $this->input->post('no_tlp');
		$alamat			= $this->input->post('alamat');
		
		
		$data=array(
			
			'no_tlp' 		=> $no_tlp,
			'alamat'		=> $alamat
		);

		$where=array(
			'id_admin'		=> $id_admin
		);
		$this->m_admin->update_data($where,$data);
			$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di update.
	        </div>');
	        redirect('C_admin');
	    //}
	}

	function delete_data($id_admin)
	{
		$this->m_admin->hapus_admin($id_admin);
		$this->m_admin->hapus_user($id_admin);
	}

}
