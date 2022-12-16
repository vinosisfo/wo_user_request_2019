<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_front extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_tabel');
		$this->load->library('pdf');
	}

	public function index()
	{
		
		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_navbar');
		//$this->load->view('template/menu_bar/sidebar');
		//body
		$this->load->view('pages/layout/top-nav');
		//$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');

	}
}
