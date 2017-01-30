<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){
 		parent::__construct();
 		$this->load->model('Crud_m','crud');
 		// $this->load->model('Absensi_m','absensi');
 	}


	public function index()
	{
		$sekolah_id = '1';
		$kelas      = $this->kelas($sekolah_id);
		$data = array(
			'page'    => 'page/dashboard',
			'menu'    => 'Home',
			'submenu' => $kelas
			);
		$this->parser->parse('lte', $data);
	}


	public function absensi($type, $kelasId)
	{
		error_reporting(0);
		date_default_timezone_set('Asia/Jakarta');

		$kelasJurusan = $this->crud->get_kelas_jurusan(array('kelas.idKelas' => $kelasId))->row('kelas');
		$sekolah_id = '1';
		$kelas      = $this->kelas($sekolah_id);
		
		switch ($type) {
			case '1':
				$date = $_REQUEST['date'];
				if (!$date) {
					$date = date('Y-m-d'); 
				}
				
				$data = array(
					'page'    => 'page/absensiharian',
					'title'   => $kelasJurusan.' ('.$date.')',
					'menu'    => 'Absensi',
					'submenu' => $kelas,
					'absensi' => $this->getAbsensi($type, $kelasId, $date),
					'date'    => $date,
					);
				break;
			
			case '2':
				$date = $_REQUEST['date'];
				if (!$date) {
					$date = date('Y-m'); 
				}
				
				$absensi = $this->getAbsensi($type, $kelasId, $date);
				$data = array(
					'page'     => 'page/absensibulanan',
					'title'    => $kelasJurusan.' ('.$date.')',
					'menu'     => 'Absensi',
					'submenu'  => $kelas,
					'absensi'  => $absensi,
					'date'     => $date,
					'listName' => $absensi['listName']
					);
				break;

			default:
				break;
		}

		$this->parser->parse('lte', $data);
	}


	public function kelas($sekolah_id)
	{
		$getKelas = $this->crud->get_kelas($sekolah_id); 
		$kelas    = array();
		
		if ($getKelas->num_rows() > 0) {
			
			foreach ($getKelas->result_array() as $key) {
				$kelas2    = array();
				$condition = array('kelas.tingkatId' => $key['idTingkat'], 'kelas.sekolahId' => $sekolah_id, 'kelas.status' => '1');
				$jurusan   = $this->crud->get_kelas_jurusan($condition, 'sidebar')->result_array();
				foreach ($jurusan as $key2) {
					$tmp = array('KELAS_JURUSAN' => $key2['kelas'], 'KELAS_ID' => $key2['id']);
					array_push($kelas2, $tmp);
				}
				$tmp2 = array('KELAS' => $key['kelas'], 'DATA' => $kelas2);
				array_push($kelas, $tmp2);
			}
		}

		return $kelas;
	}


	public function pdf()
	{
		error_reporting(0);
		$this->load->library('PdfGenerator');
		$this->load->helper('file');

		$date         = $_REQUEST['date'];
		$kelasId      = $_REQUEST['kelasId'];
		$type         = $_REQUEST['type'];
		$absensi      = $this->getAbsensi($type, $kelasId, $date);
		$kelasJurusan = $this->crud->get_kelas_jurusan(array('kelas.idKelas' => $kelasId))->row('kelas');

		$data = array(
			'keterangan' => $kelasJurusan.' ('.$date.')',
			'absensi'    => $absensi);

		switch ($type) {
			case '1': 
				$this->pdfgenerator->generate($this->load->view('well', $data, true), 'contoh', 'A4', 'portrait');
				break;

			case '2':
				$this->pdfgenerator->generate($this->load->view('well2', $data, true), 'contoh', 'A1', 'landscape');
				break;
			
		}
	}


	public function getAbsensi($type, $kelasId, $date)
	{
		$siswa = $this->crud->get('user2', array('kelasId' => $kelasId, 'status' => '1'), array('user2.nama' => 'ASC'));
		$absensi      = array();

		switch ($type) {
			case '1':
				foreach ($siswa->result_array() as $key) {
					$in = $this->crud->get(
						'transaction',
						array('userId' => $key['absenceId'], 'date(transaction.waktu)' => $date),
						array('transaction.waktu' => 'ASC'),
						'1')->row('waktu');
					
					$out = $this->crud->get(
						'transaction',
						array('userId' => $key['absenceId'], 'date(transaction.waktu)' => $date),
						array('transaction.waktu' => 'DESC'),
						'1')->row('waktu');
					
					$tmp = array('NAMA' => $key['nama'], 'NIS' => $key['nis'] , 'IN' => $in, 'OUT' => $out); 
					array_push($absensi, $tmp);
				}
				break;

			case '2':
				$listDate = $this->crud->getListDate($date,'1');

				foreach ($listDate->result_array() as $key) {
					$tmp  = array(
						'TANGGAL' => $key['tanggal'], 
						'DATA'    => $data);

					$data = array();
					foreach ($siswa->result_array() as $key2) {
						$in = $this->crud->get(
							'transaction',
							array('userId' => $key2['absenceId'], 'date(transaction.waktu)' => $key['tanggal']),
							array('transaction.waktu' => 'ASC'),
							'1')->row('waktu');
						
						$out = $this->crud->get(
							'transaction',
							array('userId' => $key2['absenceId'], 'date(transaction.waktu)' => $key['tanggal']),
							array('transaction.waktu' => 'DESC'),
							'1')->row('waktu');
						
						$tmp2 = array('NAMA' => $key2['nama'], 'NIS' => $key2['nis'] , 'IN' => substr($in, 11), 'OUT' => substr($out, 11));
						array_push($data, $tmp2);
					}

					array_push($absensi, $tmp);
				}
				$absensi['listName'] = $siswa->result_array();
				break;
			
			default:
				# code...
				break;
		}

		return $absensi;
	}


	public function printToXLS($kelasId, $date)
	{
		error_reporting(0);
		$this->load->library('ExcelWriter');
		$absensi = $this->getAbsensi('2', $kelasId, $date);
		$names   = array();

		foreach ($absensi['listName'] as $key) {
			$nama = array($key['nama'] => 'string');
			array_push($names, $nama);
		}
		$array1 = array(
			'No'      => 'integer',
			'Tanggal' => 'date'
			);
		$array2 = array_reduce($names, 'array_merge', array());
		$header = array_merge($array1, $array2);

		$data = array();
		$x = 1;
		foreach ($absensi as $key) {
			$tmp = array($x, $key['TANGGAL']);
			$inOut = array();

			foreach ($key['DATA'] as $key2) {
				$tmp2 = array($key2['IN'].' - '.$key2['OUT']); 
				array_push($inOut, $tmp2);
			} 
			$array3 = array_reduce($inOut, 'array_merge', array());
			$array4 = array_merge($tmp, $array3);
			array_push($data, $array4);
			$x++;
		}

		$kelasJurusan = $this->crud->get_kelas_jurusan(array('kelas.idKelas' => $kelasId))->row('kelas');
		$filename     = 'LIST ABSENSI '.$kelasJurusan.' ('.$date.')';

		$this->excelwriter->writeToXLS($header, $data, $filename);
		exit();
	}
}