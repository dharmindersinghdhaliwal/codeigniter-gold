<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}
	}

	public function index()
	{

		$data['page_title'] = 'Profile Settings';
		$data['user'] = db_get_row_data('users',array('id'=>$this->session->userdata('id')));

		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		if($this->input->post('opassword') != '') {
			$this->form_validation->set_rules('opassword', 'Password', 'callback_old_password');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
		}

		if ($this->form_validation->run()) {
			$save_data = [
				'full_name' => $this->input->post('full_name'),
				'address' => $this->input->post('address'),
				'country' => $this->input->post('country'),
				'state' => $this->input->post('state'),
				'city' => $this->input->post('city'),
				'gender' => $this->input->post('gender'),
				'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
				'date_updated' => date('Y-m-d H:i:s'),
			];

			if($this->input->post('opassword') != '' && $this->input->post('password') != '' && $this->input->post('cpassword') != '') {
				$save_data['password'] = md5($this->input->post('password'));
			}

			$this->db->where('id',$this->session->userdata('id'));
			if($this->db->update('users',$save_data)){
				$this->session->set_flashdata('success', 'Your setting has been successfully updated.');
				redirect('/settings');
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/settings',$data);
		$this->load->view('front/footer',$data);
	}

	public function remove_user_image()
	{
		$file_name = db_get_row_data('users',array('id'=>$this->session->userdata('id')))->profile_image;

		if(file_exists(FCPATH . 'upload_data/user/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/user/' . $file_name);

			$this->db->where('id',$this->session->userdata('id'));
			if($this->db->update('users',array('profile_image'=>''))){
				$this->session->set_flashdata('success', 'Profile Image remove successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('/settings');
	}
}