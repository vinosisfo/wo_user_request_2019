<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


	public function proses($user,$get_pass){
		$query=$this->db->select("A.*,B.id_departemen,C.nama_departemen")
						->from('tb_user A')
						->join("tb_karyawan B","B.id_user=A.id_user","inner")
						->join("tb_departemen C","C.id_departemen=B.id_departemen","left")
						->where('username',$user)
						->where('password',$get_pass)
						->get();
		return $query;
	}


}
