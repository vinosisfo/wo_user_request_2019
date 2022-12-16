<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_login');
		$this->load->library('pdf');
	}

	public function index()
	{
		
		$this->load->view('template/css/css');
		//$this->load->view('template/menu_bar/top_bar');
		//$this->load->view('template/menu_bar/sidebar');
		//body
		$this->load->view('login');
		//$this->load->view('template/menu_bar/control');
		//foot

		//$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');

	}

	public function login()
	{
		$user=(trim($this->input->post('usernanme')));
		$pass=(trim($this->input->post('pass')));

		$get_pass=md5($pass);

		$cek=$this->m_login->proses($user,$get_pass);
			if($cek->num_rows() > 0){
				foreach ($cek->result() as $set_sess) {
					$sess_data['id_user']         = $set_sess->id_user;
					$sess_data['username']        = $set_sess->username;
					$sess_data['level']           = $set_sess->level;
					$sess_data['id_departemen']   = $set_sess->id_departemen;
					$sess_data['nama_departemen'] = $set_sess->nama_departemen;
					
					$this->session->set_userdata($sess_data);
				}
						//cek level
						if ($this->session->userdata('level')==='ADMIN'){
							redirect(base_url('c_dash'));
						}
						if (($this->session->userdata('level')==='ADMIN DEPT') or ($this->session->userdata('level')==='MANAGER DEPT') or  ($this->session->userdata('level')==='TEKNISI') or ($this->session->userdata('level')==='MANAGER MTN')){
							redirect(base_url('c_dash'));
						}
			}else{
				// var_dump($this->session->userdata('level'));die();
				$this->session->set_flashdata('msg', '<br> Username atau Password yang anda masukkan salah.');
				redirect(base_url('C_login'));
			}
	}

	public function logout()
	{
		$this->session->sess_destroy();
    	redirect(base_url('c_login'));
	}
}
