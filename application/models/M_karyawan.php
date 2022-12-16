<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_karyawan extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}

 
   public function tampil_data(){
   		$query=$this->db->select('tb_karyawan.id_karyawan,tb_karyawan.nama_karyawan,tb_karyawan.no_tlp,tb_karyawan.email,tb_karyawan.id_user,tb_departemen.nama_departemen,tb_karyawan.alamat,tb_user.level,tb_departemen.id_departemen')
                      ->from('tb_karyawan')
                      ->join('tb_user','tb_user.id_user=tb_karyawan.id_user')
                      ->join('tb_departemen', 'tb_departemen.id_departemen=tb_karyawan.id_departemen')
   						        ->get();
   		return $query;
   }

   public function dept()
   {
    $query=$this->db->from('tb_departemen')
                      ->get();
      return $query;
   }

   public function simpan_karyawan($karyawan){
      
      $this->db->insert('tb_karyawan',$karyawan);
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

  public function update_karyawan($where_data,$data)
  {
    $this->db->update('tb_karyawan', $data, $where_data);
  }

  public function update_user($where_user,$user)
  {
    $this->db->update('tb_user', $user, $where_user);
  }

  public function hapus_karyawan($id_karyawan)
  {
    $this->db->where('id_karyawan', $id_karyawan);
    $this->db->delete('tb_karyawan');
  }

  public function hapus_user($id_karyawan)
  {
    $cari=$this->db->from('tb_karyawan')
                   ->where('id_karyawan',$id_karyawan)
                   ->get();
    foreach ($cari->result() as $item) {

    
    $this->db->where('id_user', $item->id_user);
    $this->db->delete('tb_user');
    }
  }

  function id_karyawan()
  {
    $this->db->select('RIGHT(tb_karyawan.id_karyawan,6) as kode', FALSE);
    $this->db->order_by('id_karyawan','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_karyawan');
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
    $kode_admin = "KRY".$kodemax;    // hasilnya ODJ-9921-0001 dst.
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
