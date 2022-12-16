<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_akun extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


    public function get_data()
    {
      if ($this->session->userdata['level']==='ADMIN') {
      $query     = $this->db->from('tb_user')
                            ->get();
      return $query;

      } else {
      $id_user    = $this->session->userdata['id_user'];
      $query      = $this->db->from('tb_user')
                              ->where('id_user', $id_user)
                              ->get();
      return $query;
      }
    }

    public function cek_pass($pass){
          $query=$this->db->from('tb_user')
                          ->where('password',$pass)
                          ->get();
          return $query;
    }

  public function update_data($where,$data)
  {
    $this->db->update('tb_user', $data, $where);
  }
    
}
