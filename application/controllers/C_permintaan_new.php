<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'third_party/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class C_permintaan_new extends CI_Controller { 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_admin');
        $this->load->model("m_permintaan");
		$this->load->library('pdf');
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("C_login"));
		}
	}

	public function index() 
	{

		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
        $this->load->view('template/js/js');
		//body
		$id_departemen    = $this->session->userdata("id_departemen");
		$level            = $this->session->userdata("level");
		$where_departemen = ($level=="ADMIN") ? "" : " AND A.id_departemen='$id_departemen'";
		$departemen       = $this->db->query("SELECT A.id_departemen,A.nama_departemen 
											FROM tb_departemen A 
											WHERE 1=1
											$where_departemen
											ORDER BY A.nama_departemen");
		$data["dept"]  = $departemen;
		$data["akses"] = ($level=="ADMIN") ? "ok" : "no";
		$this->load->view('pages/permintaan/f_permintaan_new',$data);
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');

	}

    function input_data(){
        $format        = $this->input->post("format");
        $id_departemen = $this->session->userdata("id_departemen");
        $inv           = $this->db->query("SELECT DISTINCT A.id_inventaris,A.nama_inventaris 
                                        FROM tb_inventaris A
                                        WHERE A.id_departemen='$id_departemen'
                                        ORDER BY A.nama_inventaris ASC");
        $data["inv"] = $inv;
        $this->load->view("pages/permintaan/v_input_permintaan",$data);
    }

    function cek_double(){
        $inventaris = $this->input->post("inventaris");
        // var_dump($inventaris);
        $cek_data   = [];
        foreach ($inventaris as $key => $value) {
            $get_data = $inventaris[$key];
            if(strlen($get_data) > 0){
                $cek_data[] = strtoupper($get_data);
            }
        }

        $hasil     = array_diff_key($cek_data, array_unique($cek_data));
        $hasil_set = (empty($hasil)) ? "ok" : "ada";
        
        $data["hasil"] = $hasil_set;
        echo json_encode($data);
    }

//     function do_upload()
// {       
//     $this->load->library('upload');

//     $files = $_FILES;
//     $cpt = count($_FILES['gambar']['name']);
//     for($i=0; $i<$cpt; $i++)
//     {           
//         $_FILES['gambar']['name']= $files['gambar']['name'][$i];
//         $_FILES['gambar']['type']= $files['gambar']['type'][$i];
//         $_FILES['gambar']['tmp_name']= $files['gambar']['tmp_name'][$i];
//         $_FILES['gambar']['error']= $files['gambar']['error'][$i];
//         $_FILES['gambar']['size']= $files['gambar']['size'][$i];    

//         $this->upload->initialize($this->set_upload_options());
//         $this->upload->do_upload();
//     }
// }

private function set_upload_options()
{   
    //upload an image options
    $config = array();
    $config['upload_path'] = './Images/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']      = '5120';
    $config['overwrite']     = TRUE;

    return $config;
}

    function simpan_data(){
        $this->load->library('upload');
        $id_permintaan = $this->m_permintaan->id_permintaan();
        $user_id       = $this->session->userdata("id_user");
        $tanggal       = $this->input->post("tanggal");
        $status        = 'BARU';

        $inventaris = $this->input->post("inventaris");
        $keterangan = $this->input->post("keterangan");
        $tujuan     = $this->input->post("tujuan");
        $gambar     = $this->input->post("gambar");

        $this->db->trans_start();
        $simpan_header = [
            "id_permintaan"     => $id_permintaan,
            "tgl_permintaan"    => $tanggal,
            "di_ajukan"         => $user_id,
            "status_permintaan" => $status,
        ];

        $this->db->insert("tb_permintaan",$simpan_header);
        $files = $_FILES;
        $cpt   = $_FILES['gambar']['name'];
        $no    = 0;
        foreach ($inventaris as $key => $value) {
            $no++;
            $file_name = $cpt[$key];
            $nama_foto = '';
            if(!empty($cpt[$key])){

                $config['upload_path']   = 'assets/img/permintaan/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '5120';
                $config['overwrite']     = TRUE;
                $config['file_name']     = $id_permintaan.'_foto_'.$no;

                $_FILES['gambar']['name']     = $files['gambar']['name'][$key];
                $_FILES['gambar']['type']     = $files['gambar']['type'][$key];
                $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$key];
                $_FILES['gambar']['error']    = $files['gambar']['error'][$key];
                $_FILES['gambar']['size']     = $files['gambar']['size'][$key];

                $this->upload->initialize($config);
                $this->upload->do_upload('gambar');
                $file = $this->upload->data();
                $ext  = pathinfo($file_name, PATHINFO_EXTENSION);
                // $this->upload->do_upload('gambar');
                // $file = $this->upload->data();
				$nama_foto = $id_permintaan.'_foto_'.$no.'.'.$ext;
            }

            $sql = $this->db->query("INSERT INTO tb_dtpermintaan(id_permintaan,id_inventaris,keterangan,tujuan,gambar)
                                    VALUES('$id_permintaan','$inventaris[$key]','$keterangan[$key]','$tujuan[$key]','$nama_foto')");
            
        }
        $this->db->trans_complete();

        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);

    }

    function get_data()
    {
        $list = $this->get_list();
        $data = array();
        $no = $_POST['start']; 
        foreach ($list as $field) { 
            $no++;
            $row = array();
            $level = $this->session->userdata("level");

            $row [] = $no;
            if(strlen($field->app_mnger) > 0){
                $row[]="";
            } else {
                $row [] = '<button type="button" class="btn btn-info btn-xs" onclick="edit_data(\''.$field->id_permintaan.'\',\''.$level.'\')">Edit</button>';    
            }
            if((($level=="MANAGER DEPT") AND (strlen($field->app_mtn) < 1)) OR (($level=="MANAGER MTN") AND (strlen($field->app_mnger) > 1) AND (strlen($field->app_mtn) < 1))){
                $row[]='<button type="button" class="btn btn-success btn-xs" onclick="approve_data(\''.$field->id_permintaan.'\',\''.$level.'\')">Approve</button>';
            } else {
                $row[]="";
            }
            if(($field->progres <=99) AND (strlen($field->tgl_selesai) < 5) AND ($level=="TEKNISI")){
                $row[]  ='<button type="button" class="btn btn-primary btn-xs" onclick="approve_data(\''.$field->id_permintaan.'\',\''.$level.'\')">Progress</button>';
            } else {
                $row[] ='';
            }
            if($level=="ADMIN"){
                $row [] = '<button type="button" class="btn btn-danger btn-xs" onclick="hapus_data(\''.$field->id_permintaan.'\',\''.$level.'\')">Hapus</button>';
            } else {
                $row[] = '';
            }
            $row [] = '<button type="button" class="btn btn-primary btn-xs" onclick="detail_data(\''.$field->id_permintaan.'\',\''.$level.'\')">Detail</button>';
            $row [] = $field->id_permintaan;
            $row [] = $field->tgl_permintaan;
            $row [] = $field->nama_departemen;
            // $row [] = $field->id_inventaris;
            $row [] = $field->nama_inventaris;
            $row [] = $field->user_input;
            $row [] = $field->keterangan;
            $row [] = $field->tujuan;
            $row [] = $field->app_mnger;
            $row [] = $field->tgl_app_manager;
            $row [] = $field->app_mtn;
            $row [] = $field->tgl_approved_mtn;
            $row [] = $field->keterangan_mtn;
            $row [] = $field->teknisi;
            $row [] = $field->keterangan_tkn;
            $row [] = $field->progres;
            $row [] = $field->status_detail;
            $row [] = $field->tgl_selesai;
            $row [] = '<img src="'.base_url('assets/img/permintaan/'.$field->gambar).'" onclick="view_gambar(thisWW)" class="img-responsive" id="foto_barang_'.$no.'" onerror="this.onerror=null;this.src=\''.base_url('assets/img/not_found.png').'\'">';
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    function get_list()
    {
        $this->query_data();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function query_data()
    {
        $id_user         = $this->session->userdata("id_user");
        $level           = $this->session->userdata("level");
        $id_departemen   = $this->session->userdata("id_departemen");
        $nomor_cari      = $this->input->post("nomor_cari");
        $departemen_cari = $this->input->post("departemen_cari");
        $inventaris_cari = $this->input->post("inventaris_cari");
        $status_cari     = $this->input->post("status_cari");
        $date1_cari      = $this->input->post("date1_cari");
        $date2_cari      = $this->input->post("date2_cari");
        
        $where_nomor_cari      = (empty($nomor_cari)) ? "" : " AND A.id_permintaan LIKE '%$nomor_cari%'";
        $where_departemen_cari = (empty($departemen_cari)) ? "" : " AND H.id_departemen='$departemen_cari'";
        $where_inventaris_cari = (empty($inventaris_cari)) ? "" : " AND D.nama_inventaris LIKE '%$inventaris_cari%'";
        $where_status_cari     = (empty($status_cari)) ? "" : " AND B.status_detail='$status_cari'";
        $where_departemen_set  = ($level=="ADMIN") ? "" : " AND H.id_departemen='$id_departemen'";

        $sql = "(SELECT A.id_permintaan,A.tgl_permintaan,A.status_permintaan,B.id_dtpermintaan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                ,B.keterangan,B.tujuan,C.nama_karyawan AS user_input,B.tgl_app_manager,E.nama_karyawan AS app_mnger,B.tgl_approved_mtn,F.nama_karyawan AS app_mtn,B.keterangan_mtn,G.nama_karyawan AS teknisi,
                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_selesai,B.gambar
                
                FROM tb_permintaan A
                INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                WHERE 1=1
                AND A.tgl_permintaan BETWEEN '$date1_cari' AND '$date2_cari'
                $where_nomor_cari
                $where_departemen_cari
                $where_inventaris_cari
                $where_status_cari
                $where_departemen_set
                ) A1
                ORDER BY A1.nama_departemen,A1.tgl_permintaan";
        $this->db->from($sql);
    }

    function count_filtered()
    {
        $this->query_data();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $kode_pegawai = $this->session->userdata("kode_pegawai");
        $akses_admin  = $this->session->userdata("akses_admin");
        $kode_user    = $this->input->post("kode_user");

        $sql = "(SELECT A.id_permintaan
                FROM tb_permintaan A
                INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
                WHERE 1=1) A1";
        $this->db->from($sql);
        return $this->db->count_all_results();
    }  

    function edit_data(){
        $id_permintaan = $this->input->post("id_permintaan");
        $level         = $this->input->post("level");

        $id_departemen = $this->session->userdata("id_departemen");
        $inv           = $this->db->query("SELECT DISTINCT A.id_inventaris,A.nama_inventaris 
                                        FROM tb_inventaris A
                                        WHERE A.id_departemen='$id_departemen'
                                        ORDER BY A.nama_inventaris ASC");
        
        $sql = $this->db->query("SELECT A.id_permintaan,B.id_dtpermintaan,A.tgl_permintaan,A.status_permintaan,B.id_dtpermintaan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                                ,B.keterangan,B.tujuan,C.nama_karyawan AS user_input,E.nama_karyawan AS app_mnger,F.nama_karyawan AS app_mtn,B.keterangan_mtn,G.nama_karyawan AS teknisi,
                                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_selesai,B.gambar
                                
                                FROM tb_permintaan A
                                INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
                                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                                WHERE 1=1 AND A.id_permintaan='$id_permintaan'");

        $data["list"]  = $sql;
        $data["inv"]   = $inv;
        $data["level"] = $level;

        $this->load->view("pages/permintaan/v_edit_permintaan",$data);
    }

    function update_data(){
        $this->load->library('upload');
        $id_permintaan = $this->input->post("id_permintaan");
        $user_id       = $this->session->userdata("id_user");
        $tanggal       = $this->input->post("tanggal");
        $status        = 'BARU';

        $id_detail  = $this->input->post("id_detail");
        $inventaris = $this->input->post("inventaris");
        $keterangan = $this->input->post("keterangan");
        $tujuan     = $this->input->post("tujuan");
        $gambar     = $this->input->post("gambar");

        $this->db->trans_start();
        $simpan_header = [
            "tgl_permintaan"    => $tanggal,
            "di_ajukan"         => $user_id,
            "status_permintaan" => $status,
        ];

        $this->db->update("tb_permintaan",$simpan_header,["id_permintaan"     => $id_permintaan,]);
        $files = $_FILES;
        $cpt   = $_FILES['gambar']['name'];
        $no    = 0;
        foreach ($inventaris as $key => $value) {
            $no++;
            $file_name = $cpt[$key];
            $nama_foto = '';
            if(!empty($cpt[$key])){

                $config['upload_path']   = 'assets/img/permintaan/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '5120';
                $config['overwrite']     = TRUE;
                $config['file_name']     = $id_permintaan.'_foto_'.$no;

                $_FILES['gambar']['name']     = $files['gambar']['name'][$key];
                $_FILES['gambar']['type']     = $files['gambar']['type'][$key];
                $_FILES['gambar']['tmp_name'] = $files['gambar']['tmp_name'][$key];
                $_FILES['gambar']['error']    = $files['gambar']['error'][$key];
                $_FILES['gambar']['size']     = $files['gambar']['size'][$key];

                $this->upload->initialize($config);
                $this->upload->do_upload('gambar');
                $file = $this->upload->data();
                $ext  = pathinfo($file_name, PATHINFO_EXTENSION);
                // $this->upload->do_upload('gambar');
                // $file = $this->upload->data();
				$nama_foto = $id_permintaan.'_foto_'.$no.'.'.$ext;
            }

            $id_detail_set = $id_detail[$key];

            if($id_detail_set > 0){
                $foto_update = (empty($cpt[$key])) ? "" : " ,A.gambar='$nama_foto'";
                $sql = $this->db->query("UPDATE tb_dtpermintaan A SET A.id_inventaris='$inventaris[$key]',A.keterangan='$keterangan[$key]',A.tujuan='$tujuan[$key]' $foto_update
                                        WHERE A.id_permintaan='$id_permintaan' AND A.id_dtpermintaan='$id_detail_set'");
            } else {
                $sql = $this->db->query("INSERT INTO tb_dtpermintaan(id_permintaan,id_inventaris,keterangan,tujuan,gambar)
                                    VALUES('$id_permintaan','$inventaris[$key]','$keterangan[$key]','$tujuan[$key]','$nama_foto')");
            }
            
            // var_dump($id,$id_detail_set);
        }
        // $this->db->trans_rollback();
        $this->db->trans_complete();

        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);

    }

    function hapus_baris(){
        $id_permintaan = $this->input->post("id_permintaan");
        $id_detail     = $this->input->post("id_detail");

        $this->db->trans_start();
            $get_gambar  = $this->db->query("SELECT A.gambar FROm tb_dtpermintaan A WHERE id_permintaan='$id_permintaan' AND id_dtpermintaan='$id_detail'");
            $sql         = $this->db->query("DELETE FROM tb_dtpermintaan WHERE id_permintaan='$id_permintaan' AND id_dtpermintaan='$id_detail'");
            $nama_gambar = ($get_gambar->num_rows() > 0) ? ($get_gambar->row()->gambar) : "";
            $file        = 'assets/img/permintaan/'.$nama_gambar;
            unlink($file);
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);
    }

    function approve_data(){
        $id_permintaan = $this->input->post("id_permintaan");
        $level         = $this->input->post("level");

        $id_departemen = $this->session->userdata("id_departemen");
        $inv           = $this->db->query("SELECT DISTINCT A.id_inventaris,A.nama_inventaris 
                                        FROM tb_inventaris A
                                        WHERE A.id_departemen='$id_departemen'
                                        ORDER BY A.nama_inventaris ASC");
        
        $where_level = "";
        if($level=="MANAGER DEPT"){
            $wehre_level = " AND B.approved_mtn IS NULL";
        } else if($level=="MANAGER MTN"){
            $wehre_level = " AND A.status_permintaan='APPROVE MANAGER DEPT' AND B.status_detail='APPROVE DEPT'";
        } else if($level=="TEKNISI"){
            $wehre_level = " AND A.status_permintaan='APPROVE MANAGER MTN' AND B.status_detail='APPROVE MTN'";
        }
        $sql = $this->db->query("SELECT A.id_permintaan,B.id_dtpermintaan,A.tgl_permintaan,A.status_permintaan,B.id_dtpermintaan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                                ,B.keterangan,B.tujuan,C.nama_karyawan AS user_input,E.nama_karyawan AS app_mnger,F.nama_karyawan AS app_mtn,B.keterangan_mtn,G.nama_karyawan AS teknisi,
                                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_selesai,B.gambar
                                
                                FROM tb_permintaan A
                                INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
                                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                                WHERE 1=1 AND A.id_permintaan='$id_permintaan'
                                $where_level");

        $data["list"]  = $sql;
        $data["inv"]   = $inv;
        $data["level"] = $level;

        $this->load->view("pages/permintaan/v_approve_permintaan",$data);
    }

    function approve_data_proses(){
        $id_permintaan = $this->input->post("id_permintaan");
        $level         = $this->input->post("level");
        $user_id       = $this->session->userdata("id_user");
        $now           = date("Y-m-d");

        $id_detail      = $this->input->post("id_detail");
        $status_detail  = $this->input->post("status_detail");
        $keterangan_mtn = $this->input->post("keterangan_mtn");

        $status_head = ($level=="MANAGER DEPT") ? "APPROVE MANAGER DEPT" : "APPROVE MANAGER MTN";
        $update_head = $this->db->query("UPDATE tb_permintaan A SET A.status_permintaan='$status_head' WHERE A.id_permintaan='$id_permintaan'");

        $this->db->trans_start();
            foreach ($id_detail as $key => $value) {
                $status_detail_set = ($level=="MANAGER MTN") ? ($status_detail[$key].' MTN') : ($status_detail[$key].' DEPT');
                $update_set = ($level=="MANAGER MTN") ? " A.approved_mtn='$user_id', A.tgl_approved_mtn='$now', A.keterangan_mtn='$keterangan_mtn[$key]', A.status_detail='$status_detail_set'" :
                " A.approved_manager='$user_id', A.tgl_app_manager='$now', A.status_detail='$status_detail_set'";
                $sql = $this->db->query("UPDATE tb_dtpermintaan A SET $update_set WHERE A.id_permintaan='$id_permintaan' AND A.id_dtpermintaan='$id_detail[$key]'");

            }

            $status_detail_unique = array_unique($status_detail);
            $jml_status = count($status_detail_unique);
            
            if(($jml_status==1) AND ($status_detail_unique[0] =="TOLAK")){
                $update_head = $this->db->query("UPDATE tb_permintaan A SET A.status_permintaan='DITOLAK' WHERE A.id_permintaan='$id_permintaan'");
            }
        // $this->db->trans_rollback();
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);


    }

    function approve_data_progres(){
        $id_permintaan = $this->input->post("id_permintaan");
        $level         = $this->input->post("level");
        $user_id       = $this->session->userdata("id_user");
        $now           = date("Y-m-d");

        $id_detail      = $this->input->post("id_detail");
        $progres        = $this->input->post("progres");
        $keterangan_tkn = $this->input->post("keterangan_tkn");

        $status_head = "PROSES TEKNISI";
        $update_head = $this->db->query("UPDATE tb_permintaan A SET A.status_permintaan='$status_head' WHERE A.id_permintaan='$id_permintaan'");

        $this->db->trans_start();
            foreach ($id_detail as $key => $value) {
                $status_detail = ($progres[$key] <= 99) ? "PROSES TEKNISI" : "SELESAI";
                $tgl_selesai   = ($progres[$key] <= 99) ? "" : " ,A.tgl_selesai='$now'";
                $sql           = $this->db->query("UPDATE tb_dtpermintaan A SET A.id_teknisi='$user_id',A.keterangan_tkn='$keterangan_tkn[$key]'
                                        ,A.progres='$progres[$key]',A.status_detail='$status_detail' $tgl_selesai 
                                        WHERE A.id_permintaan='$id_permintaan' AND A.id_dtpermintaan='$id_detail[$key]'");

            }
            $status_detail_unique = array_unique($progres);
            $jml_status = count($status_detail_unique);
            // var_dump($status_detail_unique,$jml_status);
            if(($jml_status==1) AND ($status_detail_unique[0] =="100")){
                $update_head = $this->db->query("UPDATE tb_permintaan A SET A.status_permintaan='SELESAI' WHERE A.id_permintaan='$id_permintaan'");
            }
        // $this->db->trans_rollback();
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);
    }

    function detail_data(){
        $id_permintaan = $this->input->post("id_permintaan");
        $level         = $this->input->post("level");

        $id_departemen = $this->session->userdata("id_departemen");
        
        $where_level = "";
        $sql = $this->db->query("SELECT A.id_permintaan,B.id_dtpermintaan,A.tgl_permintaan,A.status_permintaan,B.id_dtpermintaan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                                ,B.keterangan,B.tujuan,C.nama_karyawan AS user_input,B.tgl_app_manager,E.nama_karyawan AS app_mnger,B.tgl_approved_mtn,F.nama_karyawan AS app_mtn,B.keterangan_mtn,G.nama_karyawan AS teknisi,
                                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_selesai,B.gambar
                                
                                FROM tb_permintaan A
                                INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
                                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                                WHERE 1=1 AND A.id_permintaan='$id_permintaan'
                                $where_level");

        $data["list"]  = $sql;
        $data["level"] = $level;

        $this->load->view("pages/permintaan/v_detail_permintaan",$data);
    }

    function hapus_data(){
        $id_permintaan = $this->input->post("id_permintaan");

        $this->db->trans_start();
            $sql = $this->db->query("DELETE FROM tb_permintaan where id_permintaan='$id_permintaan'");
            $sql = $this->db->query("DELETE FROM tb_dtpermintaan where id_permintaan='$id_permintaan'");
        // $this->db->trans_rollback();
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);
    }

}
