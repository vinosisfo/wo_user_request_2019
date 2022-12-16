<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_departemen extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


   public function tampil_data(){
    $level            = $this->session->userdata("level");
    $id_departemen    = $this->session->userdata("id_departemen");
    $where_departemen = ($level=="ADMIN") ? "" : " AND tb_departemen.id_departemen='$id_departemen'";
   		$query=$this->db->from('tb_departemen')
                    ->where("1=1 $where_departemen")
   						        ->get();
   		return $query;
   }

 
   public function simpan_departemen($data){
      
      $this->db->insert('tb_departemen',$data);
   }


  public function cek_dept($departemen){
         $query=$this->db->from('tb_departemen')
                         ->where('nama_departemen',$departemen)
                         ->get();
         return $query;
   }

  public function update_departemen($where_data,$data)
  {
    $this->db->update('tb_departemen', $data, $where_data);
  }


  public function hapus_data($id_departemen)
  {
    $this->db->where('id_departemen', $id_departemen);
    $this->db->delete('tb_departemen');
  }


  function id_departemen()
  {
    $this->db->select('RIGHT(tb_departemen.id_departemen,6) as kode', FALSE);
    $this->db->order_by('id_departemen','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_departemen');
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
    $kode_dept = "DP".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_dept;  
  }

   
}
