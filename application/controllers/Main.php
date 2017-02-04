<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller  {


	public function __construct(){
 		parent::__construct();
 		$this->load->model('Crud_m','crud');
 		// $this->load->model('Absensi_m','absensi');
 	}


	public function index()
	{
		$sekolah_id = '2';
		$kelas      = $this->kelas($sekolah_id);
		$data       = array(
			'page'    => 'page/dashboard',
			'menu'    => 'Home',
			'submenu' => $kelas
			);
		$this->parser->parse('lte', $data);
	}


	public function absensi($type, $kelasId)
	{
		date_default_timezone_set('Asia/Jakarta');

		$kelasJurusan = $this->crud->get_kelas_jurusan(array('kelas.idKelas' => $kelasId))->row('kelas');
		$sekolah_id   = '2';
		$kelas        = $this->kelas($sekolah_id);
		
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


	public function absensiGuru($type)
	{
		date_default_timezone_set('Asia/Jakarta');

		$sekolah_id = '2';
		$kelas      = $this->kelas($sekolah_id);
		
		switch ($type) {
			case '1':
				$date = $_REQUEST['date'];
				if (!$date) {
					$date = date('Y-m-d'); 
				}
				
				$data = array(
					'page'    => 'page/absensiguruharian',
					'title'   => 'Absensi Guru ('.$date.')',
					'menu'    => 'Absensi',
					'submenu' => $kelas,
					'absensi' => $this->getAbsensiGuru($type, $date),
					'date'    => $date,
					);
				break;

			case '2':
				$date = $_REQUEST['date'];
				if (!$date) {
					$date = date('Y-m'); 
				}
				
				$data = array(
					'page'    => 'page/absensigurubulanan',
					'title'   => 'Absensi Guru ('.$date.')',
					'menu'    => 'Absensi',
					'submenu' => $kelas,
					'absensi' => $this->getAbsensiGuru($type, $date),
					'date'    => $date,
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
		$kelas        = $this->crud->get_kelas_jurusan(array('kelas.idKelas' => $kelasId));
		$kelasJurusan = $kelas->row('kelas');
		$absensi      = $this->getAbsensi($type, $kelasId, $date);

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


	public function pdfGuru()
	{
		error_reporting(0);
		$this->load->library('PdfGenerator');
		$this->load->helper('file');

		$date         = $_REQUEST['date'];
		$type         = $_REQUEST['type'];
		$absensi      = $this->getAbsensiGuru($type, $date);

		$data = array(
			'keterangan' => 'Absensi Guru ('.$date.')',
			'absensi'    => $absensi);

		switch ($type) {
			case '1': 
				$this->pdfgenerator->generate($this->load->view('wellGuru', $data, true), 'contoh', 'A4', 'portrait');
				break;

			case '2':
				$this->pdfgenerator->generate($this->load->view('wellGuru2', $data, true), 'contoh', 'A1', 'landscape');
				break;
			
		}
	}


	public function getAbsensi($type, $kelasId, $date)
	{
		$table            = $this->is_school();
		$tableUser        = $table['user'];
		$tableTransaction = $table['transaction'];
		$siswa = $this->crud->get($tableUser, array('kelasId' => $kelasId, 'status' => '1', 'typeUser' => 'S'), array($tableUser.'.nama' => 'ASC'));
		
		$absensi = array();
		$data    = array();

		switch ($type) {
			case '1':
				foreach ($siswa->result_array() as $key) {
					$in = $this->crud->get(
						$tableTransaction,
						array('userId' => $key['absenceId'], 'date(waktu)' => $date),
						array('waktu' => 'ASC'),
						'1')->row('waktu');
					
					$out = $this->crud->get(
						$tableTransaction,
						array('userId' => $key['absenceId'], 'date(waktu)' => $date),
						array('waktu' => 'DESC'),
						'1')->row('waktu');
					
					$tmp = array('NAMA' => $key['nama'], 'NIS' => $key['nis'] , 'IN' => $in, 'OUT' => $out); 
					array_push($absensi, $tmp);
				}
				break;

			case '2':
				$listDate = $this->crud->getListDate($date,'1', $tableUser, $tableTransaction);

				foreach ($listDate->result_array() as $key) {
					$tmp  = array(
						'TANGGAL' => $key['tanggal'], 
						'DATA'    => $data);

					$data = array();
					foreach ($siswa->result_array() as $key2) {
						$in = $this->crud->get(
							$tableTransaction,
							array('userId' => $key2['absenceId'], 'date('.$tableTransaction.'.waktu)' => $key['tanggal']),
							array($tableTransaction.'.waktu' => 'ASC'),
							'1')->row('waktu');
						
						$out = $this->crud->get(
							$tableTransaction,
							array('userId' => $key2['absenceId'], 'date('.$tableTransaction.'.waktu)' => $key['tanggal']),
							array($tableTransaction.'.waktu' => 'DESC'),
							'1')->row('waktu');
						
						$tmp2 = array('NAMA' => $key2['nama'], 'NIS' => $key2['nis'] , 'IN' => substr($in, 11), 'OUT' => substr($out, 11));
						array_push($tmp['DATA'], $tmp2);
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


	public function getAbsensiGuru($type, $date)
	{
		$table            = $this->is_school();
		$tableUser        = $table['user'];
		$tableTransaction = $table['transaction'];
		$Guru = $this->crud->get($tableUser, array('status' => '1', 'typeUser' => 'G'), array($tableUser.'.nama' => 'ASC'));
		$absensi = array();
		$data    = array();

		switch ($type) {
			case '1':
				foreach ($Guru->result_array() as $key) {
					$in = $this->crud->get(
						$tableTransaction,
						array('userId' => $key['absenceId'], 'date('.$tableTransaction.'.waktu)' => $date),
						array($tableTransaction.'.waktu' => 'ASC'),
						'1')->row('waktu');
					
					$out = $this->crud->get(
						$tableTransaction,
						array('userId' => $key['absenceId'], 'date('.$tableTransaction.'.waktu)' => $date),
						array($tableTransaction.'.waktu' => 'DESC'),
						'1')->row('waktu');
					
					$tmp = array('NAMA' => $key['nama'], 'NIS' => $key['nis'] , 'IN' => $in, 'OUT' => $out); 
					array_push($absensi, $tmp);
				}
				break;

			case '2':
				$listDate = $this->crud->getListDate($date,'2', $tableUser, $tableTransaction);

				foreach ($listDate->result_array() as $key) {
					$tmp  = array(
						'TANGGAL' => $key['tanggal'], 
						'DATA'    => $data);

					$data = array();
					foreach ($Guru->result_array() as $key2) {
						
						$in = $this->crud->get(
							$tableTransaction,
							array('userId' => $key2['absenceId'], 'date('.$tableTransaction.'.waktu)' => $key['tanggal']),
							array($tableTransaction.'.waktu' => 'ASC'),
							'1')->row('waktu');

						$out = $this->crud->get(
							$tableTransaction,
							array('userId' => $key2['absenceId'], 'date('.$tableTransaction.'.waktu)' => $key['tanggal']),
							array($tableTransaction.'.waktu' => 'DESC'),
							'1')->row('waktu');

						$tmp2 = array('NAMA' => $key2['nama'], 'NIS' => $key2['nis'] , 'IN' => substr($in, 11), 'OUT' => substr($out, 11));

						array_push($tmp['DATA'], $tmp2);

					}
					array_push($absensi, $tmp);
				}
				$absensi['listName'] = $Guru->result_array();
				break;

			
			default:
				# code...
				break;
		}

		return $absensi;
	}


	public function printToXLS($date, $type, $kelasId = null)
	{
		error_reporting(0);
		$this->load->library('ExcelWriter');

		switch ($type) {
			case 'S':
				$absensi      = $this->getAbsensi('2', $kelasId, $date);
				$kelasJurusan = $this->crud->get_kelas_jurusan(array('kelas.idKelas' => $kelasId))->row('kelas');
				$filename     = 'LIST ABSENSI '.$kelasJurusan.' ('.$date.')';
				break;
			
			case 'G':
				$absensi      = $this->getAbsensiGuru('2', $date);
				$filename     = 'LIST ABSENSI GURU ('.$date.')';
				break;
		}

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


		$this->excelwriter->writeToXLS($header, $data, $filename);
		exit();
	}


	public function readExcel($value='')
	{
		// Load the spreadsheet reader library
		$this->load->library('excel_reader');
		$this->excel_reader->read('./uploads/spanpadangguru.xls');

		// Get the contents of the first worksheet
		$worksheet = $this->excel_reader->sheets[0];
		foreach ($worksheet['cells'] as $key) {
			$data = array(
				'nama'        => trim($key['1']),
				'absenceId'   => trim($key['2']),
				'typeUser'    => 'G',
				'dateCreated' => date('Y-m-d H:i:s'),
				'dateUpdated' => date('Y-m-d H:i:s'));
			$this->crud->insert($data ,'userSPANPDG4');
		}
		// print_r($worksheet['cells']);
	}
}
