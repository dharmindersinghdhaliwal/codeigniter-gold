<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channels extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_video');
	}

	public function index()
	{
		$data['page_title'] = 'All Channels';

		if($this->session->userdata('loggedin')) {
			$data['my_channels'] = db_get_all_data('channel',array('user_id'=>$this->session->userdata('id')));
		}

		$data['channels'] = db_get_all_data('channel',array('user_id !='=>$this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/channels',$data);
		$this->load->view('front/footer',$data);
	}

	public function view($channel_id = '')
	{
		$data['posts'] = db_get_all_data('post',array('channel_id'=>$channel_id,'privacy'=>'public','status'=>1));
		$data['channel'] = db_get_row_data('channel',array('id'=>$channel_id));
		$data['videos'] = db_get_all_data('videos',array('channel_id'=>$channel_id));
		$data['page_title'] = $data['channel']->name;

		if( !empty( $this->session->userdata('id') ) ){
			$this->db->where('user_id',$this->session->userdata('id'));
			$save_data['status'] = 1;
			$this->db->update('notification',$save_data);
		}

		if(!$this->session->userdata('loggedin')) {
			$this->form_validation->set_rules('email', 'Email', 'required');
		}
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');

		if ($this->form_validation->run()) {
			$save_data = [
				'channel_id' => $channel_id,
				'owner_id' => $data['channel']->user_id,
				'title' => $this->input->post('title'),
				'message' => $this->input->post('message'),
				'date_created' => date('Y-m-d H:i:s'),
				'status' => 0,
			];

			if(!$this->session->userdata('loggedin')) {
				$save_data['email'] = $this->input->post('email');
			} else {
				$save_data['email'] = $this->session->userdata('email');
			}

			if($this->db->insert('user_query',$save_data)){
				$this->session->set_flashdata('success', 'Your Query is submitted successfully.');
				redirect('channels/view/' . $channel_id);
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/channel_view',$data);
		$this->load->view('front/footer',$data);
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

		redirect('/channels','refresh');
	}

	public function create()
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$data['page_title'] = 'Create Channel';

		$this->form_validation->set_rules('name', 'Channel Name', 'required|is_unique[channel.name]');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required');

		$save_data = [
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'website' => $this->input->post('website'),
			'facebook_url' => $this->input->post('facebook_url'),
			'instagram_url' => $this->input->post('instagram_url'),
			'twitter_url' => $this->input->post('twitter_url'),
			'google_url' => $this->input->post('google_url'),
			'linkedin_url' => $this->input->post('linkedin_url'),
			'pinterest_url' => $this->input->post('pinterest_url'),
			'email' => $this->input->post('email'),
			'category_id' => $this->input->post('category_id'),
			'user_id' => $this->session->userdata('id'),
			'date_created' => date('Y-m-d H:i:s'),
			'status' => 1,
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

		if ($this->form_validation->run() && $file == true) {
			$target_dir = FCPATH . "upload_data/channel/";
			if(isset($_POST["banner"])) {
				if($_POST["banner"] != ''){
					$file_name = $this->session->userdata('id') . '-banner-' . time() . '.png';
					$img = $_POST['banner'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$imgData = base64_decode($img);
					if(file_put_contents($target_dir . $file_name, $imgData)){
						$save_data['banner'] = $file_name;
					}
				} else {
					$save_data['banner'] = '';
				}
			} else {
				$save_data['banner'] = '';
			}

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

			if(isset($_POST["is_default"])) {
				$save_data['is_default'] = 1;

				$this->db->where('user_id',$this->session->userdata('id'));
				$this->db->update('channel',['is_default'=>0]);
			}

			if($this->db->insert('channel',$save_data)){
				$this->session->set_flashdata('success', 'New channel added successfully.');
				redirect('channels');
			}
		}

		$data = array_merge($data, $save_data);

		$this->load->view('front/header',$data);
		$this->load->view('front/create_channel',$data);
		$this->load->view('front/footer',$data);
	}

	public function edit($id = '')
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$data['page_title'] = 'Update Channel';
		$data['channel'] = db_get_row_data('channel',array('id'=>$id,'user_id'=>$this->session->userdata('id')));

		if(count($data['channel']) == 0){
			$this->session->set_flashdata('error', 'your channel is not found.');
			redirect('channels');
		}

		$this->form_validation->set_rules('name', 'Channel Name', 'required|is_unique[channel.name.id.' . $id . ']');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required');

		$save_data = [
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'website' => $this->input->post('website'),
			'facebook_url' => $this->input->post('facebook_url'),
			'instagram_url' => $this->input->post('instagram_url'),
			'twitter_url' => $this->input->post('twitter_url'),
			'google_url' => $this->input->post('google_url'),
			'linkedin_url' => $this->input->post('linkedin_url'),
			'pinterest_url' => $this->input->post('pinterest_url'),
			'email' => $this->input->post('email'),
			'category_id' => $this->input->post('category_id'),
			'date_updated' => date('Y-m-d H:i:s'),
		];

		$file = true;

		if(isset($_FILES["logo"]["name"])) {
			if($_FILES["logo"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["logo"]["tmp_name"]);
				if($width > 500 || $height > 500){
					$this->session->set_flashdata('error', 'logo Image dimension should be in between "width : 500px | height : 500px".');
					$file = false;
				}
			}
		}

		if ($this->form_validation->run() && $file == true) {
			$target_dir = FCPATH . "upload_data/channel/";
			if(isset($_POST["banner"])) {
				if($_POST["banner"] != ''){
					if($data['channel']->banner != ''){
						unlink($target_dir . $data['channel']->banner);
					}
					$file_name = $this->session->userdata('id') . '-banner-' . time() . '.png';
					$img = $_POST['banner'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$imgData = base64_decode($img);
					if(file_put_contents($target_dir . $file_name, $imgData)){
						$save_data['banner'] = $file_name;
					}
				}
			}

			if(isset($_FILES["logo"]["name"])) {
				if($_FILES["logo"]["name"] != ''){
					if($data['channel']->logo != ''){
						unlink($target_dir . $data['channel']->logo);
					}
					$imageFileType = strtolower(pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION));
					$file_name = $this->session->userdata('id') . '-logo-' . time() . '.' . $imageFileType;
					$target_file = $target_dir . $file_name;
					if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
						$save_data['logo'] = $file_name;
					}
				}
			}

			if(isset($_POST["is_default"])) {
				$save_data['is_default'] = 1;

				$this->db->where('user_id',$this->session->userdata('id'));
				$this->db->update('channel',['is_default'=>0]);
			}

			$this->db->where('id',$id);
			if($this->db->update('channel',$save_data)){
				$this->session->set_flashdata('success', 'Channel updated successfully.');
				redirect('channels/view/' . $id);
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/edit_channel',$data);
		$this->load->view('front/footer',$data);
	}

	public function remove_channel_logo($id = '')
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

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

		redirect('channels/edit/' . $id);
	}

	public function remove_channel_banner($id = '')
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

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

		redirect('channels/edit/' . $id);
	}

	public function custom($channel_id)
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$data['channel'] = db_get_row_data('channel',array('id'=>$channel_id,'user_id'=>$this->session->userdata('id')));

		if(count($data['channel']) == 0){
			$this->session->set_flashdata('error', 'your channel is not found.');
			redirect('channels');
		}

		$this->form_validation->set_rules('custom_url', 'Custom URL', 'required|is_unique[channel.custom_url.id.' . $channel_id . ']');

		if ($this->form_validation->run()) {
			$this->db->where('id',$channel_id);
			if($this->db->update('channel',['custom_url'=>$this->input->post('custom_url')])){
				$this->session->set_flashdata('success', 'Channel custom url is created successfully.');
				redirect('channels/view/' . $channel_id);
			}
		}

		redirect('channels/view/' . $channel_id);
	}

	public function my_subscription()
	{
		$data['page_title'] = 'My subscriptions';

		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$data['subscribes'] = db_get_all_data('subscribe',array('user_id'=>$this->session->userdata('id')));

		if(count($data['subscribes']) == 0){
			$this->session->set_flashdata('error', 'you not subscribed any channel.');
			redirect('channels');
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/my_subscription',$data);
		$this->load->view('front/footer',$data);
	}
}