<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'third_party/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class C_laporan_permintaan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("C_login"));
		}
		ini_set('date.timezone', 'Asia/Jakarta');
	}

	public function index()
	{
		
		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		$this->load->view('template/js/js');
		//body
		$id_departemen = $this->session->userdata("id_departemen");
		$level         = $this->session->userdata("level");
		$where_departemen = ($level=="ADMIN") ? "" : " AND A.id_departemen='$id_departemen'";
		$departemen       = $this->db->query("SELECT A.id_departemen,A.nama_departemen 
											FROM tb_departemen A 
											WHERE 1=1
											$where_departemen
											ORDER BY A.nama_departemen");
		$data["dept"]  = $departemen;
		$data["akses"] = ($level=="ADMIN") ? "ok" : "no";
		$this->load->view('pages/laporan_permintaan/f_laporan_permintaan',$data);
		$this->load->view('template/menu_bar/control');
		//body end
		$this->load->view('template/menu_bar/footer');
		
		//$this->load->view('pages/admin/vue_akun');
	}

	function get_laporan(){
		$format = $this->input->post("format");
		if($format=="HARIAN"){
			$this->format_harian();
		} else if($format=="MINGGUAN"){
			$this->format_mingguan();
		} else if($format=="BULANAN"){
			$this->format_bulanan();
		}
	}

	function format_bulanan(){
		$date1 = $this->input->post("date1");
		$date2 = $this->input->post("date2");

		$sql   = $this->sql_format_bulanan();
		
		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
        $options->set("isPhpEnabled", true);
		$pdf = new Dompdf($options);
		$contxt = stream_context_create([ 
			'ssl' => [ 
				'verify_peer'       => FALSE,
				'verify_peer_name'  => FALSE,
				'allow_self_signed' => TRUE
			] 
		]);
		$pdf->setHttpContext($contxt);
		$pdf->filename = "Permintaan_".$date1."-".$date2.".pdf";
		$pdf->setPaper('letter');

		$data["list"] = $sql;
		$data["date1"] = $date1;
		$data["date2"] = $date2;

        $html = $this->load->view("pages/laporan_permintaan/v_laporan_bulan",$data, TRUE);
        $pdf->load_html($html);
		$pdf->render();
		$pdf->stream("Permintaan_".$date1."-".$date2.".pdf",['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,"Attachment" => false]);
	}

	function sql_format_bulanan(){
		$format     = $this->input->post("format");
		$date1      = $this->input->post("date1");
		$date2      = $this->input->post("date2");
		$inventaris = $this->input->post("inventaris");
		$departemen = $this->input->post("departemen");
		$status     = $this->input->post("status");

		$where_inventaris = (empty($inventaris)) ? "" : " AND (D.id_inventaris LIKE '%$inventaris%' OR D.nama_inventaris LIKE '%$inventaris%')";
		$where_departemen = (empty($departemen)) ? "" : " AND H.id_departemen=$departemen''";
		$where_status     = (empty($status)) ? "" : (($status=="BARU") ? " AND (B.status_detail='$status' OR B.status_detail IS NULL)" : " AND B.status_detail='$status'");

		$sql = $this->db->query("SELECT * FROM (
									SELECT A.id_permintaan,B.id_dtpermintaan,MONTH(A.tgl_permintaan) AS BULAN,YEAR(A.tgl_permintaan) AS TAHUN,WEEK(A.tgl_permintaan) AS MINGGU,A.status_permintaan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
									,B.keterangan,B.tujuan,C.nama_karyawan AS user_input,B.tgl_app_manager,E.nama_karyawan AS app_mnger,B.tgl_approved_mtn,F.nama_karyawan AS app_mtn,B.keterangan_mtn,G.nama_karyawan AS teknisi,
									B.keterangan_tkn,B.progres,(CASE WHEN B.status_detail IS NULL THEN 'BARU' ELSE B.status_detail END) AS status_detail,B.tgl_selesai,B.gambar
									
									FROM tb_permintaan A
									INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
									LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
									LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
									LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
									LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
									LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
									LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
									WHERE 1=1 
									AND A.tgl_permintaan BETWEEN '$date1' AND '$date2'
									$where_inventaris
									$where_departemen
									$where_status
								) A1
								ORDER BY A1.nama_departemen,A1.TAHUN,A1.BULAN,A1.MINGGU,A1.nama_inventaris
								");
		
		return $sql;
	}

	function format_mingguan(){
		$date1 = $this->input->post("date1");
		$date2 = $this->input->post("date2");

		$sql   = $this->sql_format_mingguan();
		
		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
        $options->set("isPhpEnabled", true);
		$pdf = new Dompdf($options);
		$contxt = stream_context_create([ 
			'ssl' => [ 
				'verify_peer'       => FALSE,
				'verify_peer_name'  => FALSE,
				'allow_self_signed' => TRUE
			] 
		]);
		$pdf->setHttpContext($contxt);
		$pdf->filename = "Permintaan_".$date1."-".$date2.".pdf";
		$pdf->setPaper('letter');

		$data["list"] = $sql;
		$data["date1"] = $date1;
		$data["date2"] = $date2;

        $html = $this->load->view("pages/laporan_permintaan/v_laporan_mingguan",$data, TRUE);
        $pdf->load_html($html);
		$pdf->render();
		$pdf->stream("Permintaan_".$date1."-".$date2.".pdf",['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,"Attachment" => false]);
	}

	function sql_format_mingguan(){
		$format     = $this->input->post("format");
		$date1      = $this->input->post("date1");
		$date2      = $this->input->post("date2");
		$inventaris = $this->input->post("inventaris");
		$departemen = $this->input->post("departemen");
		$status     = $this->input->post("status");

		$where_inventaris = (empty($inventaris)) ? "" : " AND (D.id_inventaris LIKE '%$inventaris%' OR D.nama_inventaris LIKE '%$inventaris%')";
		$where_departemen = (empty($departemen)) ? "" : " AND H.id_departemen=$departemen''";
		$where_status     = (empty($status)) ? "" : (($status=="BARU") ? " AND (B.status_detail='$status' OR B.status_detail IS NULL)" : " AND B.status_detail='$status'");

		$sql = $this->db->query("SELECT * FROM (
									SELECT A.id_permintaan,B.id_dtpermintaan,WEEK(A.tgl_permintaan) AS MINGGU,A.tgl_permintaan,A.status_permintaan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
									,B.keterangan,B.tujuan,C.nama_karyawan AS user_input,B.tgl_app_manager,E.nama_karyawan AS app_mnger,B.tgl_approved_mtn,F.nama_karyawan AS app_mtn,B.keterangan_mtn,G.nama_karyawan AS teknisi,
									B.keterangan_tkn,B.progres,(CASE WHEN B.status_detail IS NULL THEN 'BARU' ELSE B.status_detail END) AS status_detail,B.tgl_selesai,B.gambar
									
									FROM tb_permintaan A
									INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
									LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
									LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
									LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
									LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
									LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
									LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
									WHERE 1=1 
									AND A.tgl_permintaan BETWEEN '$date1' AND '$date2'
									$where_inventaris
									$where_departemen
									$where_status
								) A1
								ORDER BY A1.nama_departemen,A1.MINGGU,A1.tgl_permintaan,A1.nama_inventaris
								");
		
		return $sql;
	}

	function format_harian(){
		$date1 = $this->input->post("date1");
		$date2 = $this->input->post("date2");

		$sql   = $this->sql_format_harian();
		
		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
        $options->set("isPhpEnabled", true);
		$pdf = new Dompdf($options);
		$contxt = stream_context_create([ 
			'ssl' => [ 
				'verify_peer'       => FALSE,
				'verify_peer_name'  => FALSE,
				'allow_self_signed' => TRUE
			] 
		]);
		$pdf->setHttpContext($contxt);
		$pdf->filename = "Permintaan_".$date1."-".$date2.".pdf";
		$pdf->setPaper('letter');

		$data["list"] = $sql;
		$data["date1"] = $date1;
		$data["date2"] = $date2;

        $html = $this->load->view("pages/laporan_permintaan/v_laporan_harian",$data, TRUE);
        $pdf->load_html($html);
		$pdf->render();
		$pdf->stream("Permintaan_".$date1."-".$date2.".pdf",['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,"Attachment" => false]);
	}

	function sql_format_harian(){
		$format     = $this->input->post("format");
		$date1      = $this->input->post("date1");
		$date2      = $this->input->post("date2");
		$inventaris = $this->input->post("inventaris");
		$departemen = $this->input->post("departemen");
		$status     = $this->input->post("status");

		$where_inventaris = (empty($inventaris)) ? "" : " AND (D.id_inventaris LIKE '%$inventaris%' OR D.nama_inventaris LIKE '%$inventaris%')";
		$where_departemen = (empty($departemen)) ? "" : " AND H.id_departemen=$departemen''";
		$where_status     = (empty($status)) ? "" : (($status=="BARU") ? " AND (B.status_detail='$status' OR B.status_detail IS NULL)" : " AND B.status_detail='$status'");

		$sql = $this->db->query("SELECT A.id_permintaan,B.id_dtpermintaan,A.tgl_permintaan,A.status_permintaan,B.id_dtpermintaan,D.id_inventaris,D.nama_inventaris,H.nama_departemen
                                ,B.keterangan,B.tujuan,C.nama_karyawan AS user_input,B.tgl_app_manager,E.nama_karyawan AS app_mnger,B.tgl_approved_mtn,F.nama_karyawan AS app_mtn,B.keterangan_mtn,G.nama_karyawan AS teknisi,
                                B.keterangan_tkn,B.progres,(CASE WHEN B.status_detail IS NULL THEN 'BARU' ELSE B.status_detail END) AS status_detail,B.tgl_selesai,B.gambar
                                
                                FROM tb_permintaan A
                                INNER JOIN tb_dtpermintaan B ON B.id_permintaan=A.id_permintaan
                                LEFT JOIN tb_karyawan C ON C.id_user=A.di_ajukan
                                LEFT JOIN tb_inventaris D ON D.id_inventaris=B.id_inventaris
                                LEFT JOIN tb_karyawan E ON E.id_user=B.approved_manager
                                LEFT JOIN tb_karyawan F ON F.id_user=B.approved_mtn
                                LEFT JOIN tb_karyawan G ON G.id_user=B.id_teknisi
                                LEFT JOIN tb_departemen H ON H.id_departemen=D.id_departemen
                                WHERE 1=1 
								AND A.tgl_permintaan BETWEEN '$date1' AND '$date2'
								$where_inventaris
								$where_departemen
								$where_status
								ORDER BY H.nama_departemen,A.tgl_permintaan,D.nama_inventaris
								");
		
		return $sql;
	}
	

	
}