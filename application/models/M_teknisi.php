<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_teknisi extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


   public function tampil_data(){
    $level            = $this->session->userdata("level");
    $id_departemen    = $this->session->userdata("id_departemen");
    $where_departemen = ($level=="ADMIN") ? "" : " AND tb_departemen.id_departemen='$id_departemen'";
    $query            = $this->db->from('tb_teknisi')
                      ->join('tb_user','tb_user.id_user=tb_teknisi.id_user')
                      ->join('tb_departemen','tb_departemen.id_departemen=tb_teknisi.id_departemen')
                      ->where("1=1 $where_departemen")
   						        ->get();
   		return $query;
   }


   public function simpan_teknisi($teknisi){
      
      $this->db->insert('tb_teknisi',$teknisi);
   }


  // public function cek_inv($id_departemen,$nama){
  //        $query=$this->db->from('tb_inventaris')
  //                        ->where('id_departemen',$id_departemen)
  //                        ->where('nama_inventaris',$nama)
  //                        ->get();
  //        return $query;
  //  }

  public function update_teknisi($where_data,$data)
  {
    $this->db->update('tb_teknisi', $data, $where_data);
  }


  public function hapus_data($id_teknisi)
  {
    $this->db->where('id_teknisi', $id_teknisi);
    $this->db->delete('tb_teknisi');
  }


  function id_teknisi()
  {
    $this->db->select('RIGHT(tb_teknisi.id_teknisi,6) as kode', FALSE);
    $this->db->order_by('id_teknisi','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_teknisi');
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
    $kode_tkn = "TKN".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode_tkn;  
  }

   
}
