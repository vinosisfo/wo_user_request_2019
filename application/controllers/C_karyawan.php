<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_karyawan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_karyawan');
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
		$data['data'] = $this->m_karyawan->dept()->result();
		$this->load->view('pages/karyawan/f_karyawan',$data);
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/karyawan/vue_karyawan');

	}

	public function data_karyawan()
	{
		$data = array();
		$data=$this->m_karyawan->tampil_data()->result(); 
		echo json_encode($data);
	}

	public function simpan_data(){
		$id_karyawan= $this->m_karyawan->id_karyawan();
		$id_user	= $this->m_karyawan->id_user();
		$nama_kary	= $this->input->post('nama_karyawan');
		$no_tlp		= $this->input->post('no_tlp');
		$alamat		= $this->input->post('alamat');
		$email		= $this->input->post('email');
		$departemen = $this->input->post('departemen');
		$level 		= $this->input->post('level');

		$username	= trim($nama_kary);
		$pass 		= trim(md5($id_karyawan));

		$karyawan=array(
			'id_karyawan'	=> $id_karyawan,
			'id_user' 		=> $id_user,
			'nama_karyawan' => $nama_kary,
			'no_tlp' 		=> $no_tlp,
			'alamat' 		=> $alamat,
			'email'			=> $email,
			'id_departemen' => $departemen
			
		);

		$user=array(
			'id_user'		=> $id_user,
			'username' 		=> $username,
			'password' 		=> $pass,
			'level' 		=> $level,
			'status'		=> 'AKTIF'
			
		);
		$this->m_karyawan->simpan_karyawan($karyawan);
		$this->m_karyawan->simpan_user($user);
			$this->session->set_flashdata('msg','
			<div class="alert alert-info" role="alert">
			<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di tambahan.
			</div>');
			redirect('C_karyawan');
		
	   //}
	}

	public function update_data(){
		$id_karyawan= $this->input->post('id_karyawan');
		$id_user	= $this->input->post('id_user');
		$no_tlp		= $this->input->post('no_tlp');
		$alamat		= $this->input->post('alamat');
		$email		= $this->input->post('email');
		$departemen = $this->input->post('departemen');
		$level 		= $this->input->post('level');

			// $cek_admin=$this->m_admin->cek_admin($nama_admin);
			// 	if($cek_admin->num_rows() > 0){
			// 		$this->session->set_flashdata('msg','
			//        	<div class="alert alert-info" role="alert">
			//      	<b><span class="glyphicon glyphicon-envelope">
			// 		</span></b>data berhasil di tambahan.
			//         </div>');
			//         redirect('c_admin');
			// 	} else {

		$data=array(

			'no_tlp' 		=> $no_tlp,
			'alamat' 		=> $alamat,
			'email'			=> $email,
			'id_departemen' => $departemen
			
		);

		$where_data=array(
			'id_karyawan'	=> $id_karyawan
		);

		$user=array(
			'level' 		=> $level
		);
		$where_user=array(
			'id_user'		=> $id_user
		);
		$this->m_karyawan->update_karyawan($where_data, $data);
		$this->m_karyawan->update_user($where_user, $user);
			$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di update.
	        </div>');
	        redirect('C_karyawan');
	    
	    //}
	}

	function delete_data($id_karyawan)
	{
		$this->m_karyawan->hapus_user($id_karyawan);
		$this->m_karyawan->hapus_karyawan($id_karyawan);
	}

}
