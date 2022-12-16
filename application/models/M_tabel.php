<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tabel extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


	public function permintaan_baru()
	{
	$query=$this->db->select('count(status_permintaan) as status_baru')
					->from('tb_permintaan')
					->where('status_permintaan','BARU')
					->get();
	return $query;
	}

	public function app_mng_dept()
	{
	$query=$this->db->select('count(status_permintaan) as dept')
					->from('tb_permintaan')
					->where('status_permintaan','APPROVE MANAGER DEPT')
					->get();
	return $query;
	}

	public function app_mtn()
	{
	$query=$this->db->select('count(status_permintaan) as app_mtn')
					->from('tb_permintaan')
					->where('status_permintaan','APPROVE MANAGER MTN')
					->get();
	return $query;
	}

	public function dtselesai()
	{
	$query=$this->db->select('count(status_permintaan) as data_selesai')
					->from('tb_permintaan')
					->where('status_permintaan','SELESAI')
					->get();
	return $query;
	}

	//pengajuan
	public function permintaan_baru_pg()
	{
	$query=$this->db->select('count(status_pengajuan) as status_baru')
					->from('tb_pengajuan')
					->where('status_pengajuan','BARU')
					->get();
	return $query;
	}

	public function app_mng_dept_pg()
	{
	$query=$this->db->select('count(status_pengajuan) as dept')
					->from('tb_pengajuan')
					->where('status_pengajuan','APPROVE MANAGER DEPT')
					->get();
	return $query;
	}

	public function app_mtn_pg()
	{
	$query=$this->db->select('count(status_pengajuan) as app_mtn')
					->from('tb_pengajuan')
					->where('status_pengajuan','APPROVE MANAGER MTN')
					->get();
	return $query;
	}

	public function dtselesai_pg()
	{
	$query=$this->db->select('count(status_pengajuan) as data_selesai')
					->from('tb_pengajuan')
					->where('status_pengajuan','SELESAI')
					->get();
	return $query;
	}



}
