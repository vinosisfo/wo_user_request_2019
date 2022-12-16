<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_akun extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_akun');
		$this->load->model('M_admin');
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
		$this->load->view('pages/admin/f_akun');
		$this->load->view('template/menu_bar/control');
		//body end
		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/admin/vue_akun');
	}

	public function data_akun()
	{
		$data = array();
		$data=$this->M_akun->get_data()->result();
		echo json_encode($data);
	}

	public function update_data(){
		$id_user = $this->input->post('id_user');
		$pass    = md5(trim($this->input->post('password')));
		$level   = $this->input->post("level");

		$cekpass		= $this->M_akun->cek_pass($pass);
			if($cekpass->num_rows() > 0 ){
				$this->session->set_flashdata('msg','
				<div class="alert alert-danger" role="alert">
				<b><span class="glyphicon glyphicon-envelope">
				</span></b> Pass sudah terpakai silahkan masukan password lain.
				</div>');
				redirect('C_akun');
			} else {

			$data=array(
				'password' => $pass,
				'level'    => $level,
			);

			$where=array(
				'id_user'	=> $id_user
			);
			$this->M_akun->update_data($where,$data);

			$this->session->set_flashdata('msg','
				<div class="alert alert-info" role="alert">
				<b><span class="glyphicon glyphicon-envelope">
				</span></b>Data Berhasil Diupdate.
				</div>');
				redirect('C_akun');
		}
	}


	function delete_data($id_admin)
	{
		$this->M_akun->hapus($id_admin);
	}

	function input_data(){
		$format = $this->input->post("format");

		$this->load->view("pages/admin/v_input_akun");
	}

	function simpan_data(){
		$id_user  = $this->M_admin->id_user();
		$username = $this->input->post("username");
		$password = md5($this->input->post("password"));
		$level    = $this->input->post("level");

		$this->db->trans_start();
		$data = [
				"id_user"  => $id_user,
				"username" => $username,
				"password" => $password,
				"level"    => $level,
				"status"   => "Aktif"
			];
		$this->db->insert("tb_user",$data);
		$this->db->trans_complete();

		$hasil["pesan"] = ($this->db->trans_status()) ? "ok" : "gagal";
		echo json_encode($hasil);


	}
}