<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_inventaris extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_inventaris');
		$this->load->model('m_departemen');
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
		$data["departemen"] = $this->m_departemen->tampil_data()->result();
		$this->load->view('pages/inventaris/f_inventaris',$data);
		$this->load->view('template/menu_bar/control');
		//foot

		$this->load->view('template/menu_bar/footer');
		
		$this->load->view('pages/inventaris/vue_inventaris');

	}

	public function data_inventaris()
	{
		$data = array(); 
		$data=$this->m_inventaris->tampil_data()->result();
		echo json_encode($data);
	}

	public function simpan_data(){
		$id_inventaris = $this->m_inventaris->id_inventaris();
		$id_user       = $this->session->userdata["id_user"];
		$id_departemen = $this->input->post('id_departemen');
		$nama          = $this->input->post('nama_inventaris');
		$keterangan    = $this->input->post('keterangan');
		$tgl_operasi   = $this->input->post('tgl_operasi');
		$tgl_beli      = $this->input->post('tgl_beli');

		// $id_inventaris 	= $this->m_inventaris->id_permintaan();
		// $id_teknisi		= $this->input->post('id_teknisi');
		// $ket_permintaan  = $this->input->post('ket_permintaan');
		// $ket_tujuan		= $this->input->post('ket_tujuan');
		// $gambar			= $this->input->post('gambar');

		// $config['upload_path'] = './assets/img/inventaris/';
		// $config['allowed_types'] = 'gif|jpg|png';
		// $config['max_size']	= '1000';
		// $config['max_width']  = '2000';
		// $config['max_height']  = '1024';

		$cek_inventaris=$this->m_inventaris->cek_inv($id_departemen,$nama);
			if($cek_inventaris->num_rows() > 0){
				$this->session->set_flashdata('msg','
				<div class="alert alert-danger" role="alert">
				<b><span class="glyphicon glyphicon-envelope">
				</span></b>Data departemen '.$nama.' di '.$id_departemen.' sudah ada
				</div>');
				redirect('C_inventaris');
		} else {

			$inventaris=array(
				'id_inventaris'   => $id_inventaris,
				'create_by'       => $id_user,
				'id_departemen'   => $id_departemen,
				'nama_inventaris' => $nama,
				'keterangan'      => $keterangan,
				'tgl_operasi'     => $tgl_operasi,
				'tgl_beli'        => $tgl_beli,
			);
			// $this->upload->initialize($config);
			// $this->upload->do_upload('gambar')
			// $permintaaan=array(
			// 	'id_inventaris'		=> $id_inventaris,
			// 	'id_user' 			=> $id_user,
			// 	'id_departemen' 	=> $id_departemen,
			// 	'nama_inventaris' 	=> $nama,
			// 	'keterangan'		=> $keterangan
			// );

			
			$this->m_inventaris->simpan_inventaris($inventaris);
			$this->session->set_flashdata('msg','
			<div class="alert alert-info" role="alert">
			<b><span class="glyphicon glyphicon-envelope">
			</span></b>data berhasil di tambahan.
			</div>');
			redirect('C_inventaris');
	
		}
	}

	public function update_data(){
		$id_inventaris = $this->input->post('id_inventaris');
		$id_user       = $this->session->userdata["id_user"];
		$id_departemen = $this->input->post('id_departemen');
		$nama          = $this->input->post('nama_inventaris');
		$keterangan    = $this->input->post('keterangan');
		$tgl_operasi   = $this->input->post('tgl_operasi');
		$tgl_beli      = $this->input->post('tgl_beli');

		$data=array(

			'create_by'       => $id_user,
			'id_departemen'   => $id_departemen,
			'nama_inventaris' => $nama,
			'keterangan'      => $keterangan,
			'tgl_operasi'     => $tgl_operasi,
			'tgl_beli'        => $tgl_beli,
		);

		$where_data=array(
			'id_inventaris'	=> $id_inventaris
		);

		$this->m_inventaris->update_inventarsi($where_data, $data);
		
		$this->session->set_flashdata('msg','
		<div class="alert alert-info" role="alert">
		<b><span class="glyphicon glyphicon-envelope">
		</span></b>data berhasil di update.
		</div>');
		redirect('C_inventaris');
	}

	function delete_data($id_inventaris)
	{
		$this->m_inventaris->hapus_data($id_inventaris);
	}

}
