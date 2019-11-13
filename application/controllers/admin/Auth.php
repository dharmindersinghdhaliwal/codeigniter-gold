<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		if($this->session->userdata('admin_loggedin')) {
			redirect('admin/dashboard','refresh');
		}

		$data['page_title'] = 'Admin Login';

		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		$data['email'] = $this->input->post('email');

		if ($this->form_validation->run()) {
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));
			$rememberme = $this->input->post('rememberme');

			$this->db->where('email',$email);
			$this->db->where('type','admin');
			$adminData = $this->db->get('users');

			if($adminData->num_rows() != 0){
				$admin = $adminData->row();
				if($admin->password == $password){
					$data = array(
						'id' => $admin->id,
						'email' => $admin->email,
						'full_name' => $admin->full_name,
						'type' => $admin->type,
						'admin_loggedin' => TRUE
					);
					$this->session->set_userdata($data);

					if($rememberme == 1){
						$cookie = array(
							'name'	 => 'admin',
							'value'	 => $admin->id . "-" . session_id(),
							'expire' => 60*60*24*7,
							'path'	 => '/',
						);
						$this->input->set_cookie($cookie);
					}
					$this->session->set_flashdata('success', 'Login Successfully.');
					redirect('admin/dashboard','refresh');
				} else {
					$this->session->set_flashdata('error', 'Incorrect Password.');
				}
			} else {
				$this->session->set_flashdata('error', 'User Not Found.');
			}
		}

		$this->load->view('admin/login',$data);
	}

	public function logout()
	{
		$this->db->where('id',$this->session->userdata('id'));
		$this->session->sess_destroy();
		redirect('admin/login','refresh');
	}
}