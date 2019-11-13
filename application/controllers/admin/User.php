<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
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
		$data['page_title'] = 'All Users';

		$data['users'] = db_get_all_data('users');

		$this->load->view('admin/header',$data);
		$this->load->view('admin/user/list',$data);
		$this->load->view('admin/footer',$data);
	}

	public function channel($id = '')
	{
		$data['page_title'] = 'User\'s Channel';
		$data['channels'] = db_get_all_data('channel',array('user_id'=>$id));

		$this->load->view('admin/header',$data);
		$this->load->view('admin/user/channel',$data);
		$this->load->view('admin/footer',$data);
	}

	public function add()
	{
		$data['page_title'] = 'Add New User';

		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

		$save_data = [
			'email' => $this->input->post('email'),
			'password' => md5($this->input->post('password')),
			'full_name' => $this->input->post('full_name'),
			'address' => $this->input->post('address'),
			'country' => $this->input->post('country'),
			'state' => $this->input->post('state'),
			'city' => $this->input->post('city'),
			'type' => $this->input->post('type'),
			'date_created' => date('Y-m-d H:i:s'),
			'status' => $this->input->post('status'),
		];

		$file = true;
		if(isset($_FILES["profile_image"]["name"])) {
			if($_FILES["profile_image"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["profile_image"]["tmp_name"]);
				if($width > 1024 || $height > 720){
					$this->session->set_flashdata('error', 'Image dimension should be in between "width : 1024px | height : 720px".');
					$file = false;
				}
			}
		}

		if ($this->form_validation->run() && $file == true) {
			$target_dir = FCPATH . "upload_data/user/";
			$upload_photo = '';
			$upload_signature = '';
			if(isset($_FILES["profile_image"]["name"])) {
				if($_FILES["profile_image"]["name"] != ''){
					$imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"],PATHINFO_EXTENSION));
					$file_name = $save_data['email'] . '-' . time() . '.' . $imageFileType;
					$target_file = $target_dir . $file_name;
					if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
						$save_data['profile_image'] = $file_name;
					}
				} else {
					$save_data['profile_image'] = '';
				}
			} else {
				$save_data['profile_image'] = '';
			}

			if($this->db->insert('users',$save_data)){
				$this->session->set_flashdata('success', 'New user added successfully.');
				redirect('admin/user');
			}
		}

		$data = array_merge($data, $save_data);

		$this->load->view('admin/header',$data);
		$this->load->view('admin/user/add',$data);
		$this->load->view('admin/footer',$data);
	}

	public function edit($id = '')
	{
		$data['page_title'] = 'Update User';
		$data['user'] = db_get_row_data('users',array('id'=>$id));

		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email.id.' . $id . ']');
		if(!empty($this->input->post('password'))){
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
		}

		$file = true;
		if(isset($_FILES["profile_image"]["name"])) {
			if($_FILES["profile_image"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["profile_image"]["tmp_name"]);
				if($width > 1024 || $height > 720){
					$this->session->set_flashdata('error', 'Image dimension should be in between "width : 1024px | height : 720px".');
					$file = false;
				}
			}
		}

		if ($this->form_validation->run() && $file == true) {
			$save_data = [
				'email' => $this->input->post('email'),
				'full_name' => $this->input->post('full_name'),
				'address' => $this->input->post('address'),
				'country' => $this->input->post('country'),
				'state' => $this->input->post('state'),
				'city' => $this->input->post('city'),
				'type' => $this->input->post('type'),
				'date_updated' => date('Y-m-d H:i:s'),
				'status' => $this->input->post('status'),
			];

			if(!empty($this->input->post('password'))){
				$save_data['password'] = md5($this->input->post('password'));
			}

			$target_dir = FCPATH . "upload_data/user/";
			$upload_photo = '';
			$upload_signature = '';
			if(isset($_FILES["profile_image"]["name"])) {
				if($_FILES["profile_image"]["name"] != ''){
					if($data['user']->profile_image != ''){
						unlink(FCPATH . "upload_data/user/" . $data['user']->profile_image);
					}
					$imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"],PATHINFO_EXTENSION));
					$file_name = $save_data['email'] . '-' . time() . '.' . $imageFileType;
					$target_file = $target_dir . $file_name;
					if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
						$save_data['profile_image'] = $file_name;
					}
				}
			}

			$this->db->where('id',$id);
			if($this->db->update('users',$save_data)){
				$this->session->set_flashdata('success', 'User Updated successfully.');
				redirect('admin/user');
			}
		}

		$this->load->view('admin/header',$data);
		$this->load->view('admin/user/edit',$data);
		$this->load->view('admin/footer',$data);
	}

	public function view($id)
	{
		$data['user'] = db_get_row_data('users',array('id'=>$id));

		$this->load->view('admin/user/view',$data);
	}

	public function remove_user_image($id = '')
	{
		$file_name = db_get_row_data('users',array('id'=>$id))->profile_image;

		if(file_exists(FCPATH . 'upload_data/user/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/user/' . $file_name);

			$this->db->where('id',$id);
			if($this->db->update('users',array('profile_image'=>''))){
				$this->session->set_flashdata('success', 'Profile Image remove successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('admin/user/edit/' . $id);
	}
}