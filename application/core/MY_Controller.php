<?php
class MY_Controller extends CI_Controller
{

	public function is_school(){
		$table = array(
			'user'        => 'userSPANPDG2',
			'transaction' => 'transactionSPANPDG');
		return $table;
	}

}


?>
