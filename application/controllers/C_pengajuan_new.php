<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'third_party/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class C_pengajuan_new extends CI_Controller { 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_admin');
        $this->load->model("m_pengajuan");
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
		$this->load->view('pages/pengajuan/f_pengajuan_new',$data);
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
        $this->load->view("pages/pengajuan/v_input_pengajuan",$data);
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

    function simpan_data(){
        $this->load->library('upload');
        $id_pengajuan = $this->m_pengajuan->id_pengajuan();
        $user_id       = $this->session->userdata("id_user");
        $tanggal       = $this->input->post("tanggal");
        $status        = 'BARU';

        $inventaris = $this->input->post("inventaris");
        $masalah    = $this->input->post("masalah");
        $tujuan     = $this->input->post("tujuan");
        $gambar     = $this->input->post("gambar");

        $this->db->trans_start();
        $simpan_header = [
            "id_pengajuan"     => $id_pengajuan,
            "tgl_pengajuan"    => $tanggal,
            "di_ajukan"        => $user_id,
            "status_pengajuan" => $status,
        ];

        $this->db->insert("tb_pengajuan",$simpan_header);
        $files = $_FILES;
        $cpt   = $_FILES['gambar']['name'];
        $no    = 0;
        foreach ($inventaris as $key => $value) {
            $no++;
            $file_name = $cpt[$key];
            $nama_foto = '';
            if(!empty($cpt[$key])){

                $config['upload_path']   = 'assets/img/pengajuan/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '5120';
                $config['overwrite']     = TRUE;
                $config['file_name']     = $id_pengajuan.'_foto_'.$no;

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
				$nama_foto = $id_pengajuan.'_foto_'.$no.'.'.$ext;
            }

            $sql = $this->db->query("INSERT INTO tb_dtpengajuan(id_pengajuan,id_inventaris,masalah,gambar)
                                    VALUES('$id_pengajuan','$inventaris[$key]','$masalah[$key]','$nama_foto')");
            
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
            $row   = array();
            $level = $this->session->userdata("level");
            $tolak = strpos($field->status_detail, "TOLAK");

            $row [] = $no;
            if((strlen($field->app_mnger) < 5) AND ($level=="ADMIN")){
                $row [] = '<button type="button" class="btn btn-info btn-xs" onclick="edit_data(\''.$field->id_pengajuan.'\',\''.$level.'\')">Edit</button>';
            } else {
                $row[]="";    
            }
            if((($level=="MANAGER DEPT") AND (strlen($field->app_mtn) < 1)) OR (($level=="MANAGER MTN") AND (strlen($field->app_mnger) > 1) AND (strlen($field->app_mtn) < 1) AND (strlen($tolak) < 1))){
                $row[]='<button type="button" class="btn btn-success btn-xs" onclick="approve_data(\''.$field->id_pengajuan.'\',\''.$level.'\')">Approve</button>';
            } else {
                $row[]="";
            }
            if(($field->progres <=99) AND (strlen($field->tgl_selesai) < 5) AND ($level=="TEKNISI") AND (strlen($tolak) < 1) AND (strlen($field->tgl_approve_mtn) > 5)){
                $row[]  ='<button type="button" class="btn btn-primary btn-xs" onclick="approve_data(\''.$field->id_pengajuan.'\',\''.$level.'\')">Progress</button>';
            } else {
                $row[] ='';
            }
            if($level=="ADMIN"){
                $row [] = '<button type="button" class="btn btn-danger btn-xs" onclick="hapus_data(\''.$field->id_pengajuan.'\',\''.$level.'\')">Hapus</button>';
            } else {
                $row[] = '';
            }
            $row [] = '<button type="button" class="btn btn-primary btn-xs" onclick="detail_data(\''.$field->id_pengajuan.'\',\''.$level.'\')">Detail</button>';
            $row [] = $field->id_pengajuan;
            $row [] = $field->tgl_pengajuan;
            $row [] = $field->nama_departemen;
            // $row [] = $field->id_inventaris;
            $row [] = $field->nama_inventaris;
            $row [] = $field->user_input;
            $row [] = $field->masalah;
            $row [] = $field->penanganan;
            $row [] = $field->app_mnger;
            $row [] = $field->tgl_approve_manager;
            $row [] = $field->app_mtn;
            $row [] = $field->tgl_approve_mtn;
            $row [] = $field->teknisi;
            $row [] = $field->keterangan_tkn;
            $row [] = $field->progres;
            $row [] = $field->status_detail;
            $row [] = $field->tgl_perbaikan;
            $row [] = $field->tgl_selesai;
            // $row [] = '<img src="'.base_url('assets/img/pengajuan/'.$field->gambar).'" onclick="view_gambar(thisWW)" class="img-responsive" id="foto_barang_'.$no.'" onerror="this.onerror=null;this.src=\''.base_url('assets/img/not_found.png').'\'">';
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
        
        $where_nomor_cari      = (empty($nomor_cari)) ? "" : " AND A.id_pengajuan LIKE '%$nomor_cari%'";
        $where_departemen_cari = (empty($departemen_cari)) ? "" : " AND H.id_departemen='$departemen_cari'";
        $where_inventaris_cari = (empty($inventaris_cari)) ? "" : " AND D.nama_inventaris LIKE '%$inventaris_cari%'";
        $where_status_cari     = (empty($status_cari)) ? "" : " AND B.status_detail='$status_cari'";
        $where_departemen_set  = ($level=="ADMIN") ? "" : " AND H.id_departemen='$id_departemen'";

        $sql = "(SELECT A.id_pengajuan,A.tgl_pengajuan,A.status_pengajuan,B.id_dtpengajuan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                ,B.masalah,B.penanganan,C.nama_karyawan AS user_input,B.tgl_approve_manager,E.nama_karyawan AS app_mnger,B.tgl_approve_mtn,F.nama_karyawan AS app_mtn,G.nama_karyawan AS teknisi,
                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_perbaikan,B.tgl_selesai,B.gambar
                
                FROM tb_pengajuan A
                INNER JOIN tb_dtpengajuan B ON B.id_pengajuan=A.id_pengajuan
                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                WHERE 1=1
                AND A.tgl_pengajuan BETWEEN '$date1_cari' AND '$date2_cari'
                $where_nomor_cari
                $where_departemen_cari
                $where_inventaris_cari
                $where_status_cari
                $where_departemen_set
                ) A1
                ORDER BY A1.nama_departemen,A1.tgl_pengajuan";
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

        $sql = "(SELECT A.id_pengajuan
                FROM tb_pengajuan A
                INNER JOIN tb_dtpengajuan B ON B.id_pengajuan=A.id_pengajuan
                WHERE 1=1) A1";
        $this->db->from($sql);
        return $this->db->count_all_results();
    }  

    function edit_data(){
        $id_pengajuan = $this->input->post("id_pengajuan");
        $level         = $this->input->post("level");

        $id_departemen = $this->session->userdata("id_departemen");
        $inv           = $this->db->query("SELECT DISTINCT A.id_inventaris,A.nama_inventaris 
                                        FROM tb_inventaris A
                                        WHERE A.id_departemen='$id_departemen'
                                        ORDER BY A.nama_inventaris ASC");
        
        $sql = $this->db->query("SELECT A.id_pengajuan,A.tgl_pengajuan,A.status_pengajuan,B.id_dtpengajuan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                                ,B.masalah,B.penanganan,C.nama_karyawan AS user_input,B.tgl_approve_manager,E.nama_karyawan AS app_mnger,B.tgl_approve_mtn,F.nama_karyawan AS app_mtn,G.nama_karyawan AS teknisi,
                                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_perbaikan,B.tgl_selesai,B.gambar
                                
                                FROM tb_pengajuan A
                                INNER JOIN tb_dtpengajuan B ON B.id_pengajuan=A.id_pengajuan
                                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                                WHERE 1=1 AND A.id_pengajuan='$id_pengajuan'");

        $data["list"]  = $sql;
        $data["inv"]   = $inv;
        $data["level"] = $level;

        $this->load->view("pages/pengajuan/v_edit_pengajuan",$data);
    }

    function update_data(){
        $this->load->library('upload');
        $id_pengajuan = $this->input->post("id_pengajuan");
        $user_id       = $this->session->userdata("id_user");
        $tanggal       = $this->input->post("tanggal");
        $status        = 'BARU';

        $id_detail  = $this->input->post("id_detail");
        $inventaris = $this->input->post("inventaris");
        $masalah    = $this->input->post("masalah");
        $gambar     = $this->input->post("gambar");

        $this->db->trans_start();
        $simpan_header = [
            "tgl_pengajuan"    => $tanggal,
            "di_ajukan"        => $user_id,
            "status_pengajuan" => $status,
        ];

        $this->db->update("tb_pengajuan",$simpan_header,["id_pengajuan"     => $id_pengajuan,]);
        $files = $_FILES;
        $cpt   = $_FILES['gambar']['name'];
        $no    = 0;
        foreach ($inventaris as $key => $value) {
            $no++;
            $file_name = $cpt[$key];
            $nama_foto = '';
            if(!empty($cpt[$key])){

                $config['upload_path']   = 'assets/img/pengajuan/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '5120';
                $config['overwrite']     = TRUE;
                $config['file_name']     = $id_pengajuan.'_foto_'.$no;

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
				$nama_foto = $id_pengajuan.'_foto_'.$no.'.'.$ext;
            }

            $id_detail_set = $id_detail[$key];

            if($id_detail_set > 0){
                $foto_update = (empty($cpt[$key])) ? "" : " ,A.gambar='$nama_foto'";
                $sql = $this->db->query("UPDATE tb_dtpengajuan A SET A.id_inventaris='$inventaris[$key]',A.masalah='$masalah[$key]' $foto_update
                                        WHERE A.id_pengajuan='$id_pengajuan' AND A.id_dtpengajuan='$id_detail_set'");
            } else {
                $sql = $this->db->query("INSERT INTO tb_dtpengajuan(id_pengajuan,id_inventaris,masalah,gambar)
                                    VALUES('$id_pengajuan','$inventaris[$key]','$masalah[$key]','$nama_foto')");
            }
            
            // var_dump($id,$id_detail_set);
        }
        // $this->db->trans_rollback();
        $this->db->trans_complete();

        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);

    }

    function hapus_baris(){
        $id_pengajuan = $this->input->post("id_pengajuan");
        $id_detail     = $this->input->post("id_detail");

        $this->db->trans_start();
            $get_gambar  = $this->db->query("SELECT A.gambar FROm tb_dtpengajuan A WHERE id_pengajuan='$id_pengajuan' AND id_dtpengajuan='$id_detail'");
            $sql         = $this->db->query("DELETE FROM tb_dtpengajuan WHERE id_pengajuan='$id_pengajuan' AND id_dtpengajuan='$id_detail'");
            $nama_gambar = ($get_gambar->num_rows() > 0) ? ($get_gambar->row()->gambar) : "";
            $file        = 'assets/img/permintaan/'.$nama_gambar;
            unlink($file);
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);
    }

    function approve_data(){
        $id_pengajuan = $this->input->post("id_pengajuan");
        $level         = $this->input->post("level");

        $id_departemen = $this->session->userdata("id_departemen");
        $inv           = $this->db->query("SELECT DISTINCT A.id_inventaris,A.nama_inventaris 
                                        FROM tb_inventaris A
                                        WHERE A.id_departemen='$id_departemen'
                                        ORDER BY A.nama_inventaris ASC");
        
        $where_level = "";
        if($level=="MANAGER DEPT"){
            $wehre_level = " AND IFNULL(B.approved_mtn,'')=''";
        } else if($level=="MANAGER MTN"){
            $wehre_level = " AND A.status_pengajuan='APPROVE MANAGER DEPT' AND B.status_detail NOT LIKE '%TOLAK%'";
        } else if($level=="TEKNISI"){
            $wehre_level = " AND (A.status_pengajuan='APPROVE MANAGER MTN' OR A.status_pengajuan='PROSES TEKNISI') AND B.status_detail NOT LIKE '%TOLAK%'";
        }
        
        $sql = $this->db->query("SELECT A.id_pengajuan,A.tgl_pengajuan,A.status_pengajuan,B.id_dtpengajuan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                                ,B.masalah,B.penanganan,C.nama_karyawan AS user_input,B.tgl_approve_manager,E.nama_karyawan AS app_mnger,B.tgl_approve_mtn,F.nama_karyawan AS app_mtn,G.nama_karyawan AS teknisi,
                                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_perbaikan,B.tgl_selesai,B.gambar
                                
                                FROM tb_pengajuan A
                                INNER JOIN tb_dtpengajuan B ON B.id_pengajuan=A.id_pengajuan
                                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                                WHERE 1=1 AND A.id_pengajuan='$id_pengajuan' $wehre_level");

        $data["list"]  = $sql;
        $data["inv"]   = $inv;
        $data["level"] = $level;

        $this->load->view("pages/pengajuan/v_approve_pengajuan",$data);
    }

    function approve_data_proses(){
        $id_pengajuan = $this->input->post("id_pengajuan");
        $level         = $this->input->post("level");
        $user_id       = $this->session->userdata("id_user");
        $now           = date("Y-m-d");

        $id_detail     = $this->input->post("id_detail");
        $status_detail = $this->input->post("status_detail");
        $penanganan    = $this->input->post("penanganan");

        $status_head = ($level=="MANAGER DEPT") ? "APPROVE MANAGER DEPT" : "APPROVE MANAGER MTN";
        $update_head = $this->db->query("UPDATE tb_pengajuan A SET A.status_pengajuan='$status_head' WHERE A.id_pengajuan='$id_pengajuan'");

        $this->db->trans_start();
            foreach ($id_detail as $key => $value) {
                $status_detail_set = ($level=="MANAGER MTN") ? ($status_detail[$key].' MTN') : ($status_detail[$key].' DEPT');
                $update_set = ($level=="MANAGER MTN") ? " A.approved_mtn='$user_id', A.tgl_approve_mtn='$now', A.penanganan='$penanganan[$key]', A.status_detail='$status_detail_set'" :
                " A.approved_manager='$user_id', A.tgl_approve_manager='$now', A.status_detail='$status_detail_set'";
                $sql = $this->db->query("UPDATE tb_dtpengajuan A SET $update_set WHERE A.id_pengajuan='$id_pengajuan' AND A.id_dtpengajuan='$id_detail[$key]'");

            }

            $status_detail_unique = array_unique($status_detail);
            $jml_status = count($status_detail_unique);
            
            if(($jml_status==1) AND ($status_detail_unique[0] =="TOLAK")){
                $update_head = $this->db->query("UPDATE tb_permintaan A SET A.status_permintaan='DITOLAK' WHERE A.id_pengajuan='$id_pengajuan'");
            }
        // $this->db->trans_rollback();
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);


    }

    function approve_data_progres(){
        $id_pengajuan = $this->input->post("id_pengajuan");
        $level         = $this->input->post("level");
        $user_id       = $this->session->userdata("id_user");
        $now           = date("Y-m-d");

        $id_detail      = $this->input->post("id_detail");
        $progres        = $this->input->post("progres");
        $keterangan_tkn = $this->input->post("keterangan_tkn");

        $status_head = "PROSES TEKNISI";
        $update_head = $this->db->query("UPDATE tb_pengajuan A SET A.status_pengajuan='$status_head' WHERE A.id_pengajuan='$id_pengajuan'");

        $this->db->trans_start();
            foreach ($id_detail as $key => $value) {
                $status_detail = ($progres[$key] <= 99) ? "PROSES TEKNISI" : "SELESAI";
                $tgl_selesai   = ($progres[$key] <= 99) ? " ,A.tgl_perbaikan='$now'" : " ,A.tgl_selesai='$now'";
                $sql           = $this->db->query("UPDATE tb_dtpengajuan A SET A.id_teknisi='$user_id',A.keterangan_tkn='$keterangan_tkn[$key]',A.progres='$progres[$key]',A.status_detail='$status_detail' $tgl_selesai 
                                        WHERE A.id_pengajuan='$id_pengajuan' AND A.id_dtpengajuan='$id_detail[$key]'");

            }
            $status_detail_unique = array_unique($progres);
            $jml_status = count($status_detail_unique);
            // var_dump($status_detail_unique,$jml_status);
            if(($jml_status==1) AND ($status_detail_unique[0] =="100")){
                $update_head = $this->db->query("UPDATE tb_pengajuan A SET A.status_pengajuan='SELESAI' WHERE A.id_pengajuan='$id_pengajuan'");
            }
        // $this->db->trans_rollback();
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);
    }

    function detail_data(){
        $id_pengajuan = $this->input->post("id_pengajuan");
        $level         = $this->input->post("level");

        $id_departemen = $this->session->userdata("id_departemen");
        
        $where_level = "";
        $sql = $this->db->query("SELECT A.id_pengajuan,A.tgl_pengajuan,A.status_pengajuan,B.id_dtpengajuan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                                ,B.masalah,B.penanganan,C.nama_karyawan AS user_input,B.tgl_approve_manager,E.nama_karyawan AS app_mnger,B.tgl_approve_mtn,F.nama_karyawan AS app_mtn,G.nama_karyawan AS teknisi,
                                B.keterangan_tkn,B.progres,B.status_detail,B.tgl_perbaikan,B.tgl_selesai,B.gambar
                                
                                FROM tb_pengajuan A
                                INNER JOIN tb_dtpengajuan B ON B.id_pengajuan=A.id_pengajuan
                                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                                WHERE 1=1 AND A.id_pengajuan='$id_pengajuan'");

        $data["list"]  = $sql;
        $data["level"] = $level;

        $this->load->view("pages/pengajuan/v_detail_pengajuan",$data);
    }

    function hapus_data(){
        $id_pengajuan = $this->input->post("id_pengajuan");

        $this->db->trans_start();
            $sql = $this->db->query("DELETE FROM tb_pengajuan where id_pengajuan='$id_pengajuan'");
            $sql = $this->db->query("DELETE FROM tb_dtpengajuan where id_pengajuan='$id_pengajuan'");
        // $this->db->trans_rollback();
        $this->db->trans_complete();
        $hasil["hasil"] = ($this->db->trans_status()) ? "ok" : "gagal";
        echo json_encode($hasil);
    }

}
