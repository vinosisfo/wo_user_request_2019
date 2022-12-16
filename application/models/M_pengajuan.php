<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengajuan extends CI_Model {	
	public function __construct() 
	{
		parent::__construct();
		
	}

  function id_pengajuan()
  {
    $this->db->select('RIGHT(tb_pengajuan.id_pengajuan,6) as kode', FALSE);
    $this->db->order_by('id_pengajuan','DESC');    
    $this->db->limit(1);    
    $query = $this->db->get('tb_pengajuan');
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
    $kode = "KPG".$kodemax;    // hasilnya ODJ-9921-0001 dst.
    return $kode;  
  }
}
