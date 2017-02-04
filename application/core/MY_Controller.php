<?php
class MY_Controller extends CI_Controller
{

	public function is_school(){
		$sekolahId = $this->session->userdata('sekolahId');
		switch ($sekolahId) {
			case '1':
				$table = array(
					'user'        => 'user2',
					'transaction' => 'transaction');
				# code...
				break;

			case '2':
				$table = array(
					'user'        => 'userSPANPDG2',
					'transaction' => 'transactionSPANPDG');
				break;
			
			default:
				# code...
				break;
		}
		return $table;
	}

}


?>
