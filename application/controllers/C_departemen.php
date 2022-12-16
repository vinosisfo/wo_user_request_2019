<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_departemen extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_departemen');
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
		$this->load->view('pages/departemen/f_dept');
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/departemen/vue_departemen');

	}

	public function data_departemen()
	{
		$data = array();
		$data=$this->m_departemen->tampil_data()->result();
		echo json_encode($data);
	}

	public function simpan_data(){
		$id_dept 	= $this->m_departemen->id_departemen();
		$departemen	= strtoupper($this->input->post('departemen'));
		$id_user	= $this->session->userdata["id_user"];

			$cek_admin=$this->m_departemen->cek_dept($departemen);
				if($cek_admin->num_rows() > 0){
					$this->session->set_flashdata('msg','
					<div class="alert alert-danger" role="alert">
					<b><span class="glyphicon glyphicon-envelope">
					</span></b>Data departemen '.$departemen.' sudah ada
					</div>');
					redirect('C_departemen');
				} else {

		$data=array(
			'id_departemen'   => $id_dept,
			'nama_departemen' => $departemen
		);

		
		$this->m_departemen->simpan_departemen($data);
		$this->session->set_flashdata('msg','
		<div class="alert alert-info" role="alert">
		<b><span class="glyphicon glyphicon-envelope">
		</span></b>data berhasil di tambahan.
		</div>');
		redirect('C_departemen');
	
		}
	}

	public function update_data(){
		$id_dept 	= $this->input->post('id_departemen');
		$departemen	= strtoupper($this->input->post('departemen'));
		$id_user	= $this->session->userdata["id_user"];

			$cek_admin=$this->m_departemen->cek_dept($departemen);
				if($cek_admin->num_rows() > 0){
					$this->session->set_flashdata('msg','
			       	<div class="alert alert-danger" role="alert">
			     	<b><span class="glyphicon glyphicon-envelope">
					</span></b>Data departemen '.$departemen.' sudah ada
			        </div>');
			        redirect('C_departemen');
				} else {


		$data=array(

			'id_user' 			=> $id_user,
			'nama_departemen' 	=> $departemen			
		);

		$where_data=array(
			'id_departemen'	=> $id_dept
		);

		$this->m_departemen->update_departemen($where_data, $data);
		
			$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di update.
	        </div>');
	        redirect('C_departemen');
	    
	    }
	}

	function delete_data($id_departemen)
	{
		$this->m_departemen->hapus_data($id_departemen);
	}

}
