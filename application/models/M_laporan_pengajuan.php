<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan_pengajuan extends CI_Model {	
	public function __construct()
	{
		parent::__construct();
		
	}


   public function data_departemen()
   {
      $query      = $this->db->from('tb_departemen')
                             ->get();
      return $query;
   }

  public function data_status()
   {
      $query = $this->db->from('tb_pengajuan')
                        ->group_by('status')
                        ->get();
      return $query;
   }

   public function data_gen_laporan($id_departemen,$t_awal,$t_akhir,$status){
    
    if(empty($status)){
       $query=$this->db->select('a.id_pengajuan,b.nama_inventaris,a.tgl_pengajuan,a.status,a.tgl_selesai,c.nama_departemen')
                         ->from('tb_pengajuan a')
                         ->join('tb_inventaris b','a.id_inventaris=b.id_inventaris')
                         ->join('tb_departemen c','c.id_departemen=b.id_departemen')
                         ->where('c.id_departemen',$id_departemen)
                         ->where('a.tgl_pengajuan >=', $t_awal)
                         ->where('a.tgl_pengajuan <=', $t_akhir)
                         ->get();
      }
      if(!empty($status))
      {
        $query=$this->db->select('a.id_pengajuan,b.nama_inventaris,a.tgl_pengajuan,a.status,a.tgl_selesai,c.nama_departemen')
                         ->from('tb_pengajuan a')
                         ->join('tb_inventaris b','a.id_inventaris=b.id_inventaris')
                         ->join('tb_departemen c','c.id_departemen=b.id_departemen')
                         ->where('c.id_departemen',$id_departemen)
                         ->where('a.status',$status)
                         ->where('a.tgl_pengajuan >=', $t_awal)
                         ->where('a.tgl_pengajuan <=', $t_akhir)
                         ->get();
      }
         
    return $query;
   }

   public function lap_detail($id_pengajuan)
   {
    $query = $this->db->select('d.nama_karyawan,a.tgl_pengajuan,a.tgl_app_manager_dept,a.tgl_selesai,e.nama_departemen,b.nama_inventaris,a.masalah,a.penanganan,a.status,a.progres,a.id_pengajuan,f.nama_teknisi,b.id_inventaris')
                         ->from('tb_pengajuan a')
                         ->join('tb_inventaris b','b.id_inventaris=a.id_inventaris')
                         ->join('tb_user c','c.id_user=a.di_ajukan')
                         ->join('tb_karyawan d','d.id_user=c.id_user')
                         ->join('tb_departemen e','e.id_departemen=d.id_departemen')
                         ->join('tb_teknisi f','f.id_teknisi=a.id_teknisi')
                         ->where('a.id_pengajuan',$id_pengajuan)
                         ->get();
          $detail=array();
          if ($query->num_rows() > 0){
            foreach ($query->result() as $setuju) {
              $setuju->item=array();
              $data_setuju=$this->db->select('a.nama_karyawan')
                                  ->from('tb_karyawan a')
                                  ->join('tb_user b','a.id_user=b.id_user')
                                  ->join('tb_pengajuan c','c.app_manager_dept=b.id_user')
                                  ->where('c.id_pengajuan',$setuju->id_pengajuan)
                                  ->group_by('a.id_karyawan')
                                  ->get();
            if($data_setuju->num_rows() > 0){
              $setuju->item=$data_setuju->result();
            array_push($detail, $setuju);
            }
          }
        }
        return $detail;
   }
   
}
