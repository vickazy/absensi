<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_m extends CI_Model {

	public function get($table, $condition, $order = array(), $limit = null)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($condition);
		if ($order) {
			$count = count($order);
			$key   = array_keys($order);
			for ($i=0; $i < $count ; $i++) {
				$this->db->order_by($key[$i], $order[$key[$i]]);
			}
		}
		
		if ($limit) {
			$this->db->limit($limit); 
		}

		$sql = $this->db->get();

		return $sql;
	}


	public function getListDate($month, $type, $tableUser, $tableTransaction)
	{
		switch ($type) {
			case '1':
				$sql = "SELECT DISTINCT
						    (DATE(".$tableTransaction.".waktu)) as tanggal
						FROM
						    ".$tableTransaction."
						        JOIN
						    ".$tableUser." ON ".$tableUser.".absenceId = ".$tableTransaction.".userId
						WHERE
						    ".$tableTransaction.".waktu LIKE '%".$month."%'
						        AND ".$tableUser.".typeUser = 'S'";
				break;

			case '2':
				$sql = "SELECT DISTINCT
						    (DATE(".$tableTransaction.".waktu)) as tanggal
						FROM
						    ".$tableTransaction."
						        JOIN
						    ".$tableUser." ON ".$tableUser.".absenceId = ".$tableTransaction.".userId
						WHERE
						    ".$tableTransaction.".waktu LIKE '%".$month."%'
						        AND ".$tableUser.".typeUser = 'G'";
				break;
		}
		
		
		$query = $this->db->query($sql);
		return $query;
	}


	public function get_kelas_jurusan($condition, $type = null)
	{
		if (!$type) {
			$this->db->select('CONCAT_WS(" ", tingkat.nama, jurusan.nama, kelas.rombel) as kelas, kelas.idKelas as id, kelas.sekolahId as sekolahId');
		} else {
			$this->db->select('CONCAT_WS(" ", jurusan.aliasName, kelas.rombel) as kelas, kelas.idKelas as id, kelas.sekolahId as sekolahId');
		}
		$this->db->from('kelas');
		$this->db->join('jurusan', 'kelas.jurusanId = jurusan.idJurusan');
		$this->db->join('tingkat', 'tingkat.idTingkat = kelas.tingkatId');
		$this->db->where($condition);
		$sql = $this->db->get();
		return $sql;
	}


	public function get_kelas($sekolah_id)
	{
		$this->db->select('tingkat.nama as kelas, tingkat.idTingkat');
		$this->db->from('tingkat');
		$sql = $this->db->get();
		return $sql;
	}
	

	public function login($condition)
	{
		$this->db->select('username, sekolah_id, cms_user.id as cms_user_id, pic.privilege as privilege, pic.id as privilege_id');
		$this->db->from('cms_user');
		$this->db->join('pic', 'cms_user.pic_id=pic.id');
		$this->db->where($condition);
		$sql = $this->db->get();
		return $sql;
	}
	

	public function update($data, $table, $condition)
	{
		$this->db->update($table, $data, $condition);
	}


	public function delete($table, $condition)
	{
		$this->db->delete($table, $condition); 
	}


	public function insert($data ,$table)
	{
		$this->db->insert($table, $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */