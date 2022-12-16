<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_inventaris extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


    public function tampil_data(){
      $level         = $this->session->userdata("level");
      $id_departemen = $this->session->userdata("id_departemen");
      $where_departemen = ($level=="ADMIN") ? "" : " AND tb_departemen.id_departemen='$id_departemen'";
      $query         = $this->db->from('tb_inventaris')
                      // ->join('tb_user','tb_user.id_user=tb_inventaris.create_by')
                      ->join('tb_departemen','tb_departemen.id_departemen=tb_inventaris.id_departemen')
                      ->where("1=1 $where_departemen")
                      ->get();
      return $query; 
    }


   public function simpan_inventaris($inventaris){
      
      $this->db->insert('tb_inventaris',$inventaris);
   }


  public function cek_inv($id_departemen,$nama){
         $query=$this->db->from('tb_inventaris')
                         ->where('id_departemen',$id_departemen)
                         ->where('nama_inventaris',$nama)
                         ->get();
         return $query;
   }

  public function update_inventarsi($where_data,$data)
  {
    $this->db->update('tb_inventaris', $data, $where_data);
  }


  public function hapus_data($id_inventaris)
  {
    $this->db->where('id_inventaris', $id_inventaris);
    $this->db->delete('tb_inventaris');
  }


  function id_inventaris()
  {
    $this->db->select('RIGHT(tb_inventaris.id_inventaris,6) as kode', FALSE);
    $this->db->order_by('id_inventaris','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_inventaris');
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
    $kode_inv = "INV".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_inv;  
  }

   
}
