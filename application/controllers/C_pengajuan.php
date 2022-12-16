<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_pengajuan extends CI_Controller { 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_pengajuan');
		$this->load->model('m_admin');
		$this->load->model('m_permintaan');
		$this->load->library('pdf');
		$this->load->library('MyPHPMailer');
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("C_login")); 
		}
	}

	public function index() 
	{

		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		//body
		$data['data'] = $this->m_pengajuan->data_inventaris()->result();
		$data['teknisi'] = $this->m_pengajuan->data_teknisi()->result();
		$this->load->view('pages/pengajuan/f_pengajuan',$data);
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/pengajuan/vue_pengajuan');

	}

	//daata detail pengajuan
	public function data_detail_pengajuan($id_pengajuan)
	{
		$data = array();
		$data=$this->m_pengajuan->detail_pengajuan($id_pengajuan);
		echo json_encode($data);
	}

	//view detail

	public function vw_detail_pengajuan($id_pengajuan)
	{
		$data = array();
		$data=$this->m_pengajuan->detail_approve($id_pengajuan);
		echo json_encode($data);
	}

	public function data_pengajuan()
	{
		$data = array();
		$data=$this->m_pengajuan->tampil_data()->result();
		echo json_encode($data);
	}

	public function simpan_data(){
		$id_pengajuan 	= $this->m_pengajuan->id_pengajuan();
		$id_user		= $this->session->userdata['id_user'];
		$id_inventaris	= $this->input->post('id_inventaris');
		$tgl			= date('Y-m-d');
		$masalah		= $this->input->post('masalah');
		$penanganan		= $this->input->post('penanganan');
		$status			= 'BARU';
		$diajukan		= $this->session->userdata['id_user'];
		// $config = array(
		// 	'upload_path' => 'img/',
		// 	'allowed_types' => 'jpeg|jpg|png',
		// 	'max_size' => '2048',
		// 	'max_width' => '2000',
		// 	'max_height' => '2000'
 		// 	);
		//   $this->load->library('upload', $config);
		//   $this->upload->initialize($config);
	 	//     if (!$this->upload->do_upload('gambar')) {
		// 	$this->session->set_flashdata('msg', "<div style='color:#ff0000;'>" . $this->upload->display_errors() . "</div>");
	 	//          redirect(base_url('C_pengajuan'));
	 	//      } else {
	    //$file = $this->upload->data();
			$data=array(
				'id_pengajuan'		=> $id_pengajuan,
				'id_inventaris' 	=> $id_inventaris,
				'tgl_pengajuan' 	=> $tgl,
				'masalah' 			=> $masalah,
				'status'			=> $status,
				'di_ajukan'			=> $diajukan
		);
		//kirim email ke manager 
		$filter_email = $this->m_pengajuan->cari_email()->result();
		foreach ($filter_email as $email) {
			$email_manager =  $email->email;
			$nama_departemen = $email->nama_departemen;
		}
		//var_dump($email_manager);
		//var_dump($nama_departemen);die();

		$fromEmail = "vinosisfo94@gmail.com";
        $isiEmail = "Approve pengajuan / perbaikan inventaris atau mesin pada departemen ".$nama_departemen." dengan id ".$id_inventaris." yang diajukan oleh ".$diajukan." selengkapnya silahkan cek pada aplikasi dengan id pengajuan ".$id_pengajuan."";
        $mail = new PHPMailer();
        $mail->IsHTML(true);    // set email format to HTML
        $mail->IsSMTP();   // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port       = 465;                   // SMTP port to connect to GMail
        $mail->Username   = $fromEmail;  // alamat email kamu
        $mail->Password   = "qw12345678";            // password GMail
        $mail->SetFrom('vinosisfo94@gmail.com', 'noreply');  //Siapa yg mengirim email
        $mail->Subject    = "info approval";
        $mail->Body       = $isiEmail;
        $toEmail = $email_manager; // siapa yg menerima email ini
        $mail->AddAddress($toEmail);

        // if($mail->Send()) {
        // 	echo "email terkirim";
        // }


        $simpan_data = $this->db->insert('tb_pengajuan', $data);
        if (($mail->Send()) and ($simpan_data)) {
        	$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di tambahan.
	        </div>');
	        redirect('C_pengajuan');

        }
	}

	public function approve_pengajuan()
	{
		$id_pengajuan 	= $this->input->post('id_pengajuan');
		$disetujui 		= $this->session->userdata['id_user'];
		$tgl 			= date('Y-m-d');
		$progres 		= '0';
		$penanganan 	= $this->input->post('penanganan');

		//isi email
		$nama_departemen = $this->input->post('nama_departemen');
		$diajukan 		 = $this->input->post('nama_karyawan');
		$nama_inventaris = $this->input->post('nama_inventaris');

		//cari approval
		if($this->session->userdata['level']==='MANAGER DEPT'){
		$cari_approve = $this->m_pengajuan->cari_approve($id_pengajuan)->result();
		foreach ($cari_approve as $item) {
			$nama_disetujui = $item->nama_karyawan; 
		}

		$data = array(
			'id_teknisi'	=> $id_teknisi,
			'app_manager_dept'=> $disetujui,
			'tgl_app_manager_dept' => $tgl,
			'status'		=> 'APPROVE MANAGER DEPT',
			'progres'		=> $progres,
			'penanganan'	=> $penanganan
		);

		$where = array(
			'id_pengajuan' => $id_pengajuan
		);

		//cari email teknisi
		$cari_email = $this->m_permintaan->email_mtn()->result();
		foreach ($cari_email as $manager) {
			$email_manager_mtn = $manager->email;
			$nama_manager_mtn = $manager->nama_karyawan;
		}

		$fromEmail = "vinosisfo94@gmail.com";
        $isiEmail = "Hai ".$nama_manager_mtn."<p> mohon approve pengajuan pada departemen ".$nama_departemen." yang diajukan oleh ".$diajukan." untuk memperbaiki ".$nama_inventaris." dan disetujui oleh ".$nama_disetujui."<p>info lebih lanjut silahkan cek pada web dengan id pengajuan ".$id_pengajuan."<p> terimakasih";
        $mail = new PHPMailer();
        $mail->IsHTML(true);    // set email format to HTML
        $mail->IsSMTP();   // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port       = 465;                   // SMTP port to connect to GMail
        $mail->Username   = $fromEmail;  // alamat email kamu
        $mail->Password   = "qw12345678";            // password GMail
        $mail->SetFrom('vinosisfo94@gmail.com', 'noreply');  //Siapa yg mengirim email
        $mail->Subject    = "info approval";
        $mail->Body       = $isiEmail;
        $toEmail = $email_manager_mtn; // siapa yg menerima email ini
        $mail->AddAddress($toEmail);

        // if($mail->Send()) {
        // 	echo "email terkirim";
        // }
    	}
		if($this->session->userdata['level']==='MANAGER MTN'){
		$id_teknisi		= $this->input->post('id_teknisi');
		$cari_approve = $this->m_pengajuan->cari_approve($disetujui)->result();
		foreach ($cari_approve as $item) {
			$nama_disetujui = $item->nama_karyawan; 
		}

		$data = array(
			'id_teknisi'	=> $id_teknisi,
			'app_manager_mtn'	=> $disetujui,
			'tgl_app_manager_mtn' => $tgl,
			'status'		=> 'APPROVE MANAGER MTN',
			'progres'		=> $progres,
			'penanganan'	=> $penanganan
		);

		$where = array(
			'id_pengajuan' => $id_pengajuan
		);

		//cari email teknisi
		$cari_email = $this->m_pengajuan->email_teknisi($id_teknisi)->result();
		foreach ($cari_email as $teknisi) {
			$email_teknisi = $teknisi->email;
			$nama_teknisi = $teknisi->nama_teknisi;
		}

		$fromEmail = "vinosisfo94@gmail.com";
        $isiEmail = "Hai ".$nama_teknisi."<p> Anda mendapatkan job pada departemen ".$nama_departemen." yang diajukan oleh ".$diajukan." untuk memperbaiki ".$nama_inventaris." dan disetujui oleh ".$nama_disetujui." mohon secepatnya dikerjakan<p>info lebih lanjut silahkan cek pada web dengan id pengajuan ".$id_pengajuan."<p> terimakasih";
        $mail = new PHPMailer();
        $mail->IsHTML(true);    // set email format to HTML
        $mail->IsSMTP();   // we are going to use SMTP
        $mail->SMTPAuth   = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
        $mail->Port       = 465;                   // SMTP port to connect to GMail
        $mail->Username   = $fromEmail;  // alamat email kamu
        $mail->Password   = "qw12345678";            // password GMail
        $mail->SetFrom('vinosisfo94@gmail.com', 'noreply');  //Siapa yg mengirim email
        $mail->Subject    = "info approval";
        $mail->Body       = $isiEmail;
        $toEmail = $email_teknisi; // siapa yg menerima email ini
        $mail->AddAddress($toEmail);

        // if($mail->Send()) {
        // 	echo "email terkirim";
        // }
    	}



        $update_data = $this->db->update('tb_pengajuan', $data,$where);
        if (($mail->Send()) and ($update_data)){
        	$status_aksi = TRUE;
        	echo json_encode($status_aksi);
    	}
	}

	public function update_progres()
	{
		$id_pengajuan 	= $this->input->post('id_pengajuan');
		$id_inventaris 	= $this->input->post('id_inventaris');
		$progres 		= $this->input->post('progres');
		$masalah 		= $this->input->post('masalah');
		$penanganan 	= $this->input->post('penanganan');

		if($progres > 99)
		{
		$progres = array(
			'progres' => $progres,
			'status'  => 'SELESAI',
			'tgl_selesai' => date('Y-m-d'),
			'masalah'	=> $masalah,
			'penanganan' => $penanganan
		);

		$inventaris = array(
			'tgl_perbaikan' => date('Y-m-d'),
			'keterangan'	=> $penanganan
		);

		$where_inventaris = array(
			'id_inventaris' => $id_inventaris
		);

		$operasi = $this->db->update('tb_inventaris',$inventaris,$where_inventaris);

		} else {
		$progres = array(
		'progres' => $progres
		);
		}
		$where = array(
			'id_pengajuan' => $id_pengajuan
		);

		$update_progres = $this->db->update('tb_pengajuan',$progres,$where);
		if ($update_progres){
        	$status_aksi = TRUE;
        	echo json_encode($status_aksi);
    	}

	}

	function delete_data($id_pengajuan)
	{
		$this->m_pengajuan->hapus_pengajuan($id_pengajuan);
	}

}
