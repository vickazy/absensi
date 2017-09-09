<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	
	class UploadImport extends MY_Controller
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Crud_m', 'crud');
		}
		
		
		function index()
		{
			$listSekolah = $this->db->get('sekolah')->result_array();
			$data = array(
				'page'        => 'page/import',
				'title'       => 'Import Data Absensi',
				'menu'        => 'Import Data Absensi',
				'listSekolah' => $listSekolah
			);
			$this->parser->parse('admin', $data);
		}
		
		
		function doImport($sekolah)
		{
			switch ($sekolah){
				case 'smknasional':
					$mainTable = 'transaction';
					$logTable = 'transaction2';
					break;
					
				case 'spanpadang':
					$mainTable = 'transactionSPANPDG';
					$logTable = 'transactionspanpdg2';
					break;
					
				case 'spanmedan':
					$mainTable = 'transactionSPANMEDAN';
					$logTable = 'transactionspanmedan2';
					break;
					
				default:
					$mainTable = '';
					$logTable = '';
					break;
			}
			
			$sql = "insert into ".$mainTable." (userId,waktu,verifikasi,status,dateCreated,dateUpdated) select userId,waktu,verifikasi,status,dateCreated,dateUpdated from ".$logTable;
			$this->db->query($sql);
			
			if ($this->db->affected_rows()) {
				$sql = "truncate ".$logTable;
				$this->db->query($sql);
			}
			
			echo $this->db->last_query();
		}
		
	}