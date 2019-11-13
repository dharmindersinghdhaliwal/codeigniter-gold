<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_loggedin')){
			redirect('admin/login');
		}
	}

	public function index()
	{
		$data['page_title'] = 'Admin Dashboard';

		$this->load->view('admin/header',$data);
		$this->load->view('admin/dashboard',$data);
		$this->load->view('admin/footer',$data);
	}

	public function profile()
	{
		$data['page_title'] = 'Profile';

		$data['profile'] = db_get_row_data('users',array('id'=>$this->session->userdata('id')));

		$this->load->view('admin/header',$data);
		$this->load->view('admin/profile',$data);
		$this->load->view('admin/footer',$data);
	}

	public function profile_save()
	{
		header('Content-Type: application/json');
		$data = [];

		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		if($this->input->post('opassword') != '') {
			$this->form_validation->set_rules('opassword', 'Password', 'callback_old_password');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
		}

		if ($this->form_validation->run()) {
			$save_data = [
				'email' => $this->input->post('email'),
				'full_name' => $this->input->post('full_name'),
				'address' => $this->input->post('address'),
				'date_updated' => date('Y-m-d H:i:s'),
			];

			if(isset($_FILES["profile_image"]["name"])) {
				$target_dir = FCPATH . "upload_data/admin/";
				if($_FILES["profile_image"]["name"] != ''){
					$fileType = strtolower(pathinfo($_FILES["profile_image"]["name"],PATHINFO_EXTENSION));
					if($fileType == 'JPG' || $fileType == 'JPEG' || $fileType == 'PNG' || $fileType == 'GIF' || $fileType == 'BMP' || $fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'png' || $fileType == 'gif' || $fileType == 'bmp'){

						$file_name = "profile_image_" . $_SERVER['SERVER_NAME'] . "_" . time() . "." . $fileType;
						$target_file = $target_dir . $file_name;

						$result = db_get_row_data('users',array('id'=>$this->session->userdata('id')));
						if(file_exists(FCPATH . 'upload_data/admin/' . $result->profile_image) && $result->profile_image != '') {
							unlink(FCPATH . 'upload_data/admin/' . $result->profile_image);
						}

						if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
							$save_data['profile_image'] = $file_name;
						}
					}
				}
			}

			if($this->input->post('opassword') != '' && $this->input->post('password') != '' && $this->input->post('cpassword') != '') {
				$save_data['password'] = md5($this->input->post('password'));
			}

			$this->db->where('id',$this->session->userdata('id'));
			$this->db->update('users',$save_data);

			$data['success'] = true;
			$data['message'] = '<div class="alert alert-success">Your setting has been successfully updated.</div>';
		} else {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}

	public function remove_profile_image()
	{
		$result = db_get_row_data('users',array('id'=>$this->session->userdata('id')));
		if($result->profile_image != ''){
			if(file_exists(FCPATH . 'upload_data/admin/' . $result->profile_image) && $result->profile_image != '') {
				unlink(FCPATH . 'upload_data/admin/' . $result->profile_image);
				$this->db->where('id',$this->session->userdata('id'));
				$this->db->update('users',array('profile_image'=> ''));
			}

			$this->session->set_flashdata('success', 'Profile image is removed successfully');
		} else {
			$this->session->set_flashdata('warning', 'Profile image already removed');
		}

		redirect('admin/dashboard/profile');
	}

	public function old_password($value = '')
	{
		if($value != ''){
			$result = db_get_row_data('users',array('id'=>$this->session->userdata('id')));

			if($result->password == md5($value)){
				return TRUE;
			} else {
				$this->form_validation->set_message('old_password', 'Old Password is incorrect.');
				return FALSE;
			}
		}
	}
}