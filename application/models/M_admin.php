<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


   public function tampil_data(){
   		$query=$this->db->from('tb_admin')
                      ->join('tb_user','tb_user.id_admin=tb_admin.id_admin')
   						        ->get();
   		return $query;
   }

   public function simpan_admin($admin){
      
      $this->db->insert('tb_admin',$admin);
   }

   public function simpan_user($user){
      
      $this->db->insert('tb_user',$user);
   }

   // public function cek_admin($nama_admin){
   //       $query=$this->db->from('tb_admin')
   //                       ->where('nama_admin',$nama_admin)
   //                       ->get();
   //       return $query;
   // }

    public function update_data($where,$data)
  {
    $this->db->update('tb_admin', $data, $where);
  }

  public function hapus_admin($id_admin)
  {
    $this->db->where('id_admin', $id_admin);
    $this->db->delete('tb_admin');
  }

  public function hapus_user($id_admin)
  {
    $this->db->where('id_admin', $id_admin);
    $this->db->delete('tb_user');
  }

  function id_admin()
  {
    $this->db->select('RIGHT(tb_admin.id_admin,6) as kode', FALSE);
    $this->db->order_by('id_admin','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_admin');
    if($query->num_rows() <> 0){      
         //jika kode ternyata sudah ada.      
    $data = $query->row();      
    $kode = intval($data->kode) + 1;    
    }
    else {      
         //jika kode belum ada      
    $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_admin = "ADM".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_admin;  
  }

  function id_user()
  {
    $this->db->select('RIGHT(tb_user.id_user,6) as kode', FALSE);
    $this->db->order_by('id_user','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_user');
    if($query->num_rows() <> 0){      
         //jika kode ternyata sudah ada.      
    $data = $query->row();      
    $kode = intval($data->kode) + 1;    
    }
    else {      
         //jika kode belum ada      
    $kode = 1;    
    }
    $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
    $kode_user = "USR".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_user;  
  }


   
}
