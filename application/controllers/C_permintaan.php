<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_permintaan extends CI_Controller { 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_permintaan');
		$this->load->model('m_admin');
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
		//body
		$data['data']    = "";
		$data['teknisi'] = $this->m_permintaan->data_teknisi()->result();
		$this->load->view('pages/permintaan/f_permintaan',$data);
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/permintaan/vue_permintaan');

	}




	//old

	//detail  permintaan
	public function detail_permintaan() 
	{

		$this->load->view('template/css/css');
		$this->load->view('template/menu_bar/top_bar');
		$this->load->view('template/menu_bar/sidebar');
		//body
		//$data['data'] = $this->m_permintaan->data_inventaris()->result();
		$this->load->view('pages/permintaan/f_detail_permintaan');
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		$this->load->view('template/js/js');
		$this->load->view('pages/permintaan/vue_permintaan');

	}

	//daata detail permintaan
	public function data_detail_permintaan($id_permintaan)
	{
		$data = array();
		$data=$this->m_permintaan->detail_permintaan($id_permintaan);
		echo json_encode($data);
	}

	//view detail

	public function vw_detail_permintaan($id_permintaan)
	{
		$data = array();
		$data=$this->m_permintaan->detail_approve($id_permintaan);
		echo json_encode($data);
	}

	public function data_permintaan()
	{
		$data = array();
		$data=$this->m_permintaan->tampil_data()->result();
		echo json_encode($data);
	}

	public function simpan_data(){
		$id_permintaan 	= $this->m_permintaan->id_permintaan();
		$id_user		= $this->session->userdata['id_user'];
		$id_inventaris	= $this->input->post('id_inventaris');
		$tgl			= date('Y-m-d');
		$keterangan		= $this->input->post('keterangan');
		$tujuan			= $this->input->post('tujuan');
		$status			= 'BARU';
		$diajukan		= $this->session->userdata['id_user'];
		$config = array(
			'upload_path'   => 'assets/img/permintaan/',
			'allowed_types' => 'jpeg|jpg|png',
			'max_size'      => '2048',
			'max_width'     => '2000',
			'max_height'    => '2000'
 		);
		  $this->load->library('upload', $config);
		  $this->upload->initialize($config);
	     if (!$this->upload->do_upload('gambar')) {
			$this->session->set_flashdata('msg', "<div style='color:#ff0000;'>" . $this->upload->display_errors() . "</div>");
	          redirect(base_url('C_permintaan'));
	      } else {
	      	$file = $this->upload->data();
			$data=array(
				'id_permintaan'		=> $id_permintaan,
				'id_inventaris' 	=> $id_inventaris,
				'tgl_permintaan' 	=> $tgl,
				'ket_permintaan' 	=> $keterangan,
				'ket_tujuan' 		=> $tujuan,
				'status'			=> $status,
				'di_ajukan'			=> $diajukan,
				'gambar' 			=> $file['file_name']
		);
		//kirim email ke manager
		$filter_email = $this->m_permintaan->cari_email()->result();
		foreach ($filter_email as $email) {
			$email_manager =  $email->email;
			$nama_departemen = $email->nama_departemen;
		}
		//var_dump($email_manager);
		//var_dump($nama_departemen);die();

		$fromEmail = "vinosisfo94@gmail.com";
        $isiEmail = "Approve permintaan pemasangan inventaris atau mesin baru pada departemen ".$nama_departemen." untuk id_mesin ".$id_inventaris." yang diajukan oleh ".$diajukan."";
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


        $simpan_data = $this->db->insert('tb_permintaan', $data);
        if (($mail->Send()) and ($simpan_data)) {
        	$this->session->set_flashdata('msg','
	       	<div class="alert alert-info" role="alert">
	     	<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di tambahan.
	        </div>');
	        redirect('C_permintaan');

        }
	    
	   }
	}

	public function approve_permintaan()
	{
		$id_permintaan 	= $this->input->post('id_permintaan');
		$disetujui 		= $this->session->userdata['id_user'];
		$tgl 			= date('Y-m-d');
		$progres 		= '0';

		//isi email
		$nama_departemen = $this->input->post('nama_departemen');
		$diajukan 		 = $this->input->post('nama_karyawan');
		$nama_inventaris = $this->input->post('nama_inventaris');

		//cari approval
		if($this->session->userdata['level']==='MANAGER DEPT'){
		$cari_approve = $this->m_permintaan->cari_approve($disetujui)->result();
		foreach ($cari_approve as $item) {
			$nama_disetujui = $item->nama_karyawan; 
		}

		$data = array(
			//'id_teknisi'	=> $id_teknisi,
			'app_manager_dept'		=> $disetujui,
			'tgl_app_manager_dept' 	=> $tgl,
			'status'				=> 'APPROVE MANAGER DEPT',
			'progres'				=> $progres
		);

		$where = array(
			'id_permintaan' => $id_permintaan
		);

		//cari email teknisi
		$cari_email = $this->m_permintaan->email_mtn()->result();
		foreach ($cari_email as $mtn) {
			$email_mtn = $mtn->email;
			$nama_mtn = $mtn->nama_karyawan;
		}

		$fromEmail = "vinosisfo94@gmail.com";
        $isiEmail = "Hai ".$nama_mtn."<p> mohon approve permintaan pekerjaan pada departemen ".$nama_departemen." yang diajukan oleh ".$diajukan." untuk memasang ".$nama_inventaris." dan disetujui oleh ".$nama_disetujui."<p>info lebih lanjut silahkan cek pada web dengan id permintaan ".$id_permintaan."<p> terimakasih";
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
        $toEmail = $email_mtn; // siapa yg menerima email ini
        $mail->AddAddress($toEmail);

        // if($mail->Send()) {
        // 	echo "email terkirim";
        // }
	    }
	    if($this->session->userdata['level']==='MANAGER MTN'){
	    $id_teknisi		= $this->input->post('id_teknisi');

		$cari_approve = $this->m_permintaan->cari_approve($disetujui)->result();
		foreach ($cari_approve as $item) {
			$nama_disetujui = $item->nama_karyawan; 
		}

		$data = array(
			'id_teknisi'	=> $id_teknisi,
			'app_manager_mtn'		=> $disetujui,
			'tgl_app_manager_mtn' 	=> $tgl,
			'status'				=> 'APPROVE MANAGER MTN',
			'progres'				=> $progres
		);

		$where = array(
			'id_permintaan' => $id_permintaan
		);

		//cari email teknisi
		$cari_email = $this->m_permintaan->email_teknisi($id_teknisi)->result();
		foreach ($cari_email as $teknisi) {
			$email_teknisi = $teknisi->email;
			$nama_teknisi = $teknisi->nama_teknisi;
		}

		$fromEmail = "vinosisfo94@gmail.com";
        $isiEmail = "Hai ".$nama_teknisi."<p> anda mendapatkan pekerjaan pada departemen ".$nama_departemen." yang diajukan oleh ".$diajukan." untuk memasang ".$nama_inventaris." dan disetujui oleh ".$nama_disetujui."<p>info lebih lanjut silahkan cek pada web dengan id permintaan ".$id_permintaan."<p> terimakasih";
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


        $update_data = $this->db->update('tb_permintaan', $data,$where);
        if (($mail->Send()) and ($update_data)){
        	$status_aksi = TRUE;
        	echo json_encode($status_aksi);
    	}
	}

	public function update_progres()
	{
		$id_permintaan 	= $this->input->post('id_permintaan');
		$id_inventaris 	= $this->input->post('id_inventaris');
		$progres 		= $this->input->post('progres');

		if($progres > 99)
		{
		$progres = array(
			'progres' => $progres,
			'status'  => 'SELESAI',
			'tgl_selesai' => date('Y-m-d')
		);

		$inventaris = array(
			'tgl_operasi' 	=> date('Y-m-d')
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
			'id_permintaan' => $id_permintaan
		);

		$update_progres = $this->db->update('tb_permintaan',$progres,$where);
		if ($update_progres){
        	$status_aksi = TRUE;
        	echo json_encode($status_aksi);
    	}

	}

	function delete_data($id_permintaan)
	{
		$this->m_permintaan->hapus_permintaan($id_permintaan);
	}

}
