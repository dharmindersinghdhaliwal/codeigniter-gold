<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_loggedin')){
			redirect('admin/login');
		}

		$this->load->model('model_video');
	}

	public function index()
	{
		$data['page_title'] = 'All Channels';

		$data['channels'] = db_get_all_data('channel',array('user_id'=>$this->session->userdata('id')));

		$this->load->view('admin/header',$data);
		$this->load->view('admin/channel/list',$data);
		$this->load->view('admin/footer',$data);
	}

	public function add()
	{
		$data['page_title'] = 'Add New Channel';

		$this->form_validation->set_rules('name', 'Channel Name', 'required|is_unique[channel.name]');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required');

		$save_data = [
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'category_id' => $this->input->post('category_id'),
			'user_id' => $this->session->userdata('id'),
			'date_created' => date('Y-m-d H:i:s'),
			'status' => $this->input->post('status'),
		];

		$file = true;
		if(isset($_FILES["logo"]["name"])) {
			if($_FILES["logo"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["logo"]["tmp_name"]);
				if($width > 500 || $height > 500){
					$this->session->set_flashdata('error', 'Logo Image dimension should be in between "width : 500px | height : 500px".');
					$file = false;
				}
			}
		}
		if(isset($_FILES["banner"]["name"])) {
			if($_FILES["banner"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["banner"]["tmp_name"]);
				if($width > 1040 || $height > 300){
					$this->session->set_flashdata('error', 'Banner Image dimension should be in between "width : 1040px | height : 300px".');
					$file = false;
				}
			}
		}

		if ($this->form_validation->run() && $file == true) {
			$target_dir = FCPATH . "upload_data/channel/";
			$upload_photo = '';
			$upload_signature = '';
			if(isset($_FILES["logo"]["name"])) {
				if($_FILES["logo"]["name"] != ''){
					$imageFileType = strtolower(pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION));
					$file_name = $this->session->userdata('id') . '-logo-' . time() . '.' . $imageFileType;
					$target_file = $target_dir . $file_name;
					if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
						$save_data['logo'] = $file_name;
					}
				} else {
					$save_data['logo'] = '';
				}
			} else {
				$save_data['logo'] = '';
			}

			if(isset($_FILES["banner"]["name"])) {
				if($_FILES["banner"]["name"] != ''){
					$imageFileType = strtolower(pathinfo($_FILES["banner"]["name"],PATHINFO_EXTENSION));
					$file_name = $this->session->userdata('id') . '-banner-' . time() . '.' . $imageFileType;
					$target_file = $target_dir . $file_name;
					if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
						$save_data['banner'] = $file_name;
					}
				} else {
					$save_data['banner'] = '';
				}
			} else {
				$save_data['banner'] = '';
			}

			if($this->db->insert('channel',$save_data)){
				$this->session->set_flashdata('success', 'New channel added successfully.');
				redirect('admin/channel');
			}
		}

		$data = array_merge($data, $save_data);

		$this->load->view('admin/header',$data);
		$this->load->view('admin/channel/add',$data);
		$this->load->view('admin/footer',$data);
	}

	public function edit($id = '')
	{
		$data['page_title'] = 'Update Channel';
		$data['channel'] = db_get_row_data('channel',array('id'=>$id));

		$this->form_validation->set_rules('name', 'Channel Name', 'required|is_unique[channel.name.id.' . $id . ']');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required');

		$file = true;
		if(isset($_FILES["logo"]["name"])) {
			if($_FILES["logo"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["logo"]["tmp_name"]);
				if($width > 500 || $height > 500){
					$this->session->set_flashdata('error', 'Logo Image dimension should be in between "width : 500px | height : 500px".');
					$file = false;
				}
			}
		}
		if(isset($_FILES["banner"]["name"])) {
			if($_FILES["banner"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["banner"]["tmp_name"]);
				if($width > 1040 || $height > 300){
					$this->session->set_flashdata('error', 'Banner Image dimension should be in between "width : 1040px | height : 300px".');
					$file = false;
				}
			}
		}

		if ($this->form_validation->run() && $file == true) {
			$save_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'category_id' => $this->input->post('category_id'),
				'date_updated' => date('Y-m-d H:i:s'),
				'status' => $this->input->post('status'),
			];

			$target_dir = FCPATH . "upload_data/channel/";
			$upload_photo = '';
			$upload_signature = '';
			if(isset($_FILES["logo"]["name"])) {
				if($_FILES["logo"]["name"] != ''){
					if($data['channel']->logo != ''){
						unlink(FCPATH . "upload_data/channel/" . $data['channel']->logo);
					}
					$imageFileType = strtolower(pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION));
					$file_name = $save_data['name'] . '-' . time() . '.' . $imageFileType;
					$target_file = $target_dir . $file_name;
					if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
						$save_data['logo'] = $file_name;
					}
				}
			}

			if(isset($_FILES["banner"]["name"])) {
				if($_FILES["banner"]["name"] != ''){
					if($data['channel']->banner != ''){
						unlink(FCPATH . "upload_data/channel/" . $data['channel']->banner);
					}
					$imageFileType = strtolower(pathinfo($_FILES["banner"]["name"],PATHINFO_EXTENSION));
					$file_name = $this->session->userdata('id') . '-banner-' . time() . '.' . $imageFileType;
					$target_file = $target_dir . $file_name;
					if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
						$save_data['banner'] = $file_name;
					}
				} else {
					$save_data['banner'] = '';
				}
			} else {
				$save_data['banner'] = '';
			}

			$this->db->where('id',$id);
			if($this->db->update('channel',$save_data)){
				$this->session->set_flashdata('success', 'Channel Updated successfully.');
				redirect('admin/channel');
			}
		}

		$this->load->view('admin/header',$data);
		$this->load->view('admin/channel/edit',$data);
		$this->load->view('admin/footer',$data);
	}

	public function delete($channel_id = '')
	{
		$channel = db_get_row_data('channel',array('id'=>$channel_id,'user_id'=>$this->session->userdata('id')));

		if(count($channel) == 0) {
			$this->session->set_flashdata('error', 'channel not found !');
			redirect('channels','refresh');
		}

		if(file_exists(FCPATH . 'upload_data/channel/' . $channel->logo) && $channel->logo != '') {
			unlink(FCPATH . 'upload_data/channel/' . $channel->logo);
		}

		if(file_exists(FCPATH . 'upload_data/channel/' . $channel->banner) && $channel->banner != '') {
			unlink(FCPATH . 'upload_data/channel/' . $channel->banner);
		}

		$this->db->where('channel_id',$channel_id);
		$this->db->delete('subscribe');

		foreach (db_get_all_data('videos',array('channel_id'=>$channel_id)) as $video) {
			$this->model_video->remove($video->id);
		}

		$this->db->where('id',$channel_id);
		$this->db->delete('channel');

		$this->session->set_flashdata('success', 'channel removed successfully.');

		redirect('/admin/channel','refresh');
	}

	public function view($id)
	{
		$data['channel'] = db_get_row_data('channel',array('id'=>$id));

		$this->load->view('admin/channel/view',$data);
	}

	public function remove_channel_logo($id = '')
	{
		$file_name = db_get_row_data('channel',array('id'=>$id))->logo;

		if(file_exists(FCPATH . 'upload_data/channel/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/channel/' . $file_name);

			$this->db->where('id',$id);
			if($this->db->update('channel',array('logo'=>''))){
				$this->session->set_flashdata('success', 'channel logo removed successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('admin/channel/edit/' . $id);
	}

	public function remove_channel_banner($id = '')
	{
		$file_name = db_get_row_data('channel',array('id'=>$id))->banner;

		if(file_exists(FCPATH . 'upload_data/channel/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/channel/' . $file_name);

			$this->db->where('id',$id);
			if($this->db->update('channel',array('banner'=>''))){
				$this->session->set_flashdata('success', 'channel banner removed successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('admin/channel/edit/' . $id);
	}
}