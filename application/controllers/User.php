<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
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
		$data['page_title'] = 'User Profile';
		$data['usr'] = $this->input->get('usr');

		if(!empty($data['usr'])){
			$data['user'] = db_get_row_data('users',array('email'=>base64_decode($data['usr'])));
			if(count($data['user']) == 0){
				$this->session->set_flashdata('error', 'User Not Found !');
				redirect('my_subscribers','refresh');
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/user_profile',$data);
		$this->load->view('front/footer',$data);
	}

	public function group()
	{
		$data['page_title'] = 'My Groups';

		$data['user_groups'] = db_get_all_data('user_group',array('user_id' => $this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/user_groups',$data);
		$this->load->view('front/footer',$data);
	}

	public function group_add($group_id = '')
	{
		$data['page_title'] = 'Add New Group';

		$data['user_follows'] = db_get_all_data('user_follow',array('follow_id' => $this->session->userdata('id')));

		$save_data = [
			'user_id' => $this->session->userdata('id'),
			'name' => $this->input->post('name'),
			'type' => $this->input->post('type'),
			'datetime' => date('Y-m-d H:i:s'),
			'status' => 0
		];

		$this->form_validation->set_rules('name', 'Group Name', 'trim|required');
		$continue = true;
		if(isset($_POST['user_ids'])){
			if(count((array)$_POST['user_ids']) == 0){
				$this->session->set_flashdata('error', 'Please select any member.');
				$continue = false;
			}
		} else {
			$continue = false;
		}

		if ($this->form_validation->run() && $continue == true)
		{
			if($this->db->insert('user_group',$save_data)){
				$group_id = $this->db->insert_id();
				foreach ($this->input->post('user_ids') as $key => $value) {
					$group_detail_save = [
						'group_id'	=> $group_id,
						'user_id'	=> $value
					];

					$this->db->insert('user_group_detail',$group_detail_save);
				}

				$this->session->set_flashdata('success', 'New Group added successfully.');
				redirect('user/group');
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/user_groups_add',$data);
		$this->load->view('front/footer',$data);
	}

	public function group_edit($group_id = '')
	{
		$data['page_title'] = 'Update Group';

		$data['user_group'] = db_get_row_data('user_group',array('id' =>$group_id,'user_id' => $this->session->userdata('id')));

		$data['user_follows'] = db_get_all_data('user_follow',array('follow_id' => $this->session->userdata('id')));

		if(count($data['user_group']) == 0){
			$this->session->set_flashdata('error', 'User\'s Group Not Found !');
			redirect('user/group','refresh');
		}

		$save_data = [
			'user_id' => $this->session->userdata('id'),
			'name' => $this->input->post('name'),
			'type' => $this->input->post('type'),
			'datetime' => date('Y-m-d H:i:s'),
			'status' => 0
		];

		$this->form_validation->set_rules('name', 'Group Name', 'trim|required');
		$continue = true;
		if(isset($_POST['user_ids'])){
			if(count((array)$_POST['user_ids']) == 0){
				$this->session->set_flashdata('error', 'Please select any member.');
				$continue = false;
			}
		} else {
			$continue = false;
		}

		if ($this->form_validation->run() && $continue == true)
		{
			$this->db->where('id',$group_id);
			if($this->db->update('user_group',$save_data))
			{
				$this->db->where('group_id',$group_id);
				$this->db->delete('user_group_detail');

				foreach ($this->input->post('user_ids') as $key => $value) {
					$group_detail_save = [
						'group_id'	=> $group_id,
						'user_id'	=> $value
					];

					$this->db->insert('user_group_detail',$group_detail_save);
				}

				$this->session->set_flashdata('success', 'Group updated successfully.');
				redirect('user/group');
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/user_groups_edit',$data);
		$this->load->view('front/footer',$data);
	}
}