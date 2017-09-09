<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	
	class Login extends MY_Controller
	{
		
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Crud_m', 'crud');
		}
		
		
		public function do_login()
		{
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
			
			if ($username and $password) {
				$data = array(
					'username' => $username,
					'password' => md5($password)
				);
				$checkLogin = $this->crud->get('cmsuser', $data);
				if ($checkLogin->num_rows()) {
					$sess = array(
						'username'  => $username,
						'sekolahId' => $checkLogin->row('sekolahId'),
						'roleId'    => $checkLogin->row('roleId')
					);
					$this->session->set_userdata($sess);
					redirect('Main');
				} else {
					$respon = array('STATUS' => FALSE, 'INFO' => 'Username dan Password tidak terdaftar', 'ALERT' => 'danger');
					$this->session->set_flashdata($respon);
					redirect('login');
				}
				
			} else {
				$respon = array('STATUS' => FALSE, 'INFO' => 'Call me 0811-800-2255', 'ALERT' => 'danger');
				$this->session->set_flashdata($respon);
				redirect('login');
			}
		}
		
		
		public function index()
		{
			$this->load->view('login');
		}
		
		
		public function logout()
		{
			$this->session->sess_destroy();
			$respon = array('STATUS' => TRUE, 'INFO' => 'Anda sudah keluar dari aplikasi', 'ALERT' => 'success');
			$this->session->set_flashdata($respon);
			redirect('login');
		}
		
		
	}
