<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dash extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_tabel');
		$this->load->library('pdf');
	}

	public function index()
	{
		
		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		//body
		$data['permintaan_baru'] = $this->m_tabel->permintaan_baru()->result();
		$data['app_mng_dept']    = $this->m_tabel->app_mng_dept()->result();
		$data['app_mtn']         = $this->m_tabel->app_mtn()->result();
		$data['dtselesai']       = $this->m_tabel->dtselesai()->result();

		$data['permintaan_baru_pg'] = $this->m_tabel->permintaan_baru_pg()->result();
		$data['app_mng_dept_pg']    = $this->m_tabel->app_mng_dept_pg()->result();
		$data['app_mtn_pg']         = $this->m_tabel->app_mtn_pg()->result();
		$data['dtselesai_pg']       = $this->m_tabel->dtselesai_pg()->result();

		$this->load->view('pages/dashboard',$data);
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');

	}
}
