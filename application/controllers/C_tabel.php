<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_tabel extends CI_Controller {

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
		$this->load->view('pages/tables/data');
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');

	}
}
