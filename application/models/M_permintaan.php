<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_permintaan extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}

  public function hapus_permintaan($id_permintaan)
  {
    $this->db->where('id_permintaan', $id_permintaan);
    $this->db->delete('tb_permintaan');
  }

  function id_permintaan()
  {
    $this->db->select('RIGHT(tb_permintaan.id_permintaan,6) as kode', FALSE);
    $this->db->order_by('id_permintaan','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_permintaan');
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
    $kode = "KPR".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode;  
  }
}
