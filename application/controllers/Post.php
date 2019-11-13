<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index($channel_id = '', $post_id = '')
	{
		$last = $this->uri->total_segments();
		$record_num = $this->uri->segment($last);
		if(is_numeric($record_num)){
			$post_id = $record_num;
			$data['post'] = db_get_row_data('post',array('id ='=>$post_id),false,'date_created DESC',10);
			$data['channel_id'] = $data['post']->channel_id;
			$data['posts'] = db_get_all_data('post');
			$this->load->view('front/header',$data);
			$this->load->view('front/post_view', $data);
			$this->load->view('front/footer',$data);
		}
		else
		{
			$data['posts'] = db_get_all_data('post');
			$this->load->view('front/header',$data);
			$this->load->view('front/posts', $data);
			$this->load->view('front/footer',$data);
		}
	}
	public function view($channel_id = '', $post_id = '')
	{
		if($channel_id == '') {
			$this->session->set_flashdata('error', 'Invalid channel !');
			redirect('channels','refresh');
		}

		$data['channel'] = db_get_row_data('channel',array('id'=>$channel_id));

		if(count($data['channel']) == 0){
			$this->session->set_flashdata('error', 'Channel Not found!');
			redirect('channels','refresh');
		}

		if($post_id == '') {
			$this->session->set_flashdata('error', 'Channel\'s post no more !');
			redirect('channels/view/' . $channel_id,'refresh');
		}

		$data['post'] = db_get_row_data('post',array('id'=>$post_id));

		if(count($data['post']) == 0){
			$this->session->set_flashdata('error', 'Post Not found!');
			redirect('channels/view/' . $channel_id,'refresh');
		}

		$data['channel_id'] = $channel_id;
		$data['page_title'] = 'Post';
		$data['posts'] = db_get_all_data('post',array('channel_id'=>$channel_id,'id !='=>$post_id),false,'date_created DESC',10);

		$this->load->view('front/header',$data);
		$this->load->view('front/post_view',$data);
		$this->load->view('front/footer',$data);
	}

	public function my($post_id = '')
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$data['posts'] = db_get_all_data('post',array('status'=>1,'user_id' => $this->session->userdata('id')),false,'date_created DESC');
		$data['page_title'] = 'My Posts';

		$this->load->view('front/header',$data);
		$this->load->view('front/posts_my',$data);
		$this->load->view('front/footer',$data);
	}

	public function create($channel_id = '')
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		if($channel_id == '') {
			$this->session->set_flashdata('error', 'You Have atleast a channel to make post !');
			redirect('dashboard','refresh');
		}

		$data['channel_id'] = $channel_id;
		$data['page_title'] = 'Create your post';

		$data['user_groups'] = db_get_all_data('user_group',array('user_id' => $this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/create_post',$data);
		$this->load->view('front/footer',$data);
	}

	public function edit($channel_id = '', $post_id = '')
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		if($channel_id == '') {
			$this->session->set_flashdata('error', 'You Have atleast a channel to make post !');
			redirect('dashboard','refresh');
		}

		$data['page_title'] = 'Update your post';
		$data['channel_id'] = $channel_id;

		$data['post'] = db_get_row_data('post',array('id'=>$post_id,'user_id' => $this->session->userdata('id')));

		if(count($data['post']) == 0){
			$this->session->set_flashdata('error', 'Post Not found!');
			redirect('post','refresh');
		}

		$data['user_groups'] = db_get_all_data('user_group',array('user_id' => $this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/edit_post',$data);
		$this->load->view('front/footer',$data);
	}

	public function save()
	{
		header('Content-Type: application/json');
		$data = [];
		$data['message'] = '';

		$this->form_validation->set_rules('content', 'Post Content', 'trim|required');

		if ($this->form_validation->run()) {
			$save_data = [
				'channel_id' => $this->input->post('channel_id'),
				'user_id' => $this->session->userdata('id'),
				'group_id' => $this->input->post('group_id'),
				'privacy' => $this->input->post('privacy'),
				'content' => $this->input->post('content'),
				'date_created' => date('Y-m-d H:i:s'),
				'status' => 1
			];

			if($this->db->insert('post',$save_data))
			{
				$data['success'] = true;
				$this->session->set_flashdata('success', 'Your post is submitted and posted successfully.');
			}
		} else {
			$data['success'] = false;
			$data['message'] .= '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}

	public function update($post_id = '')
	{
		header('Content-Type: application/json');
		$data = [];
		$data['message'] = '';

		$data['post'] = db_get_row_data('post',array('id'=>$post_id,'user_id' => $this->session->userdata('id')));

		if(count($data['post']) == 0){
			$data['success'] = false;
			$data['message'] .= '<div class="alert alert-danger">Post Not found!</div>';
		}

		$this->form_validation->set_rules('content', 'Post Content', 'trim|required');

		if ($this->form_validation->run()) {
			$save_data = [
				'group_id' => $this->input->post('group_id'),
				'privacy' => $this->input->post('privacy'),
				'content' => $this->input->post('content'),
				'date_updated' => date('Y-m-d H:i:s'),
				'status' => 1
			];

			$this->db->where('id',$post_id);
			if($this->db->update('post',$save_data))
			{
				$data['success'] = true;
				$this->session->set_flashdata('success', 'Your post is updated successfully.');
			}
		} else {
			$data['success'] = false;
			$data['message'] .= '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}

	public function comment($post_id = '')
	{
		header('Content-Type: application/json');
		$data = [];

		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';

			echo json_encode($data);
			die();
		}

		$post = db_get_row_data('post',array('id'=>$post_id));

		if (count($post) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Post is no more.</div>';

			echo json_encode($data);
			die();
		}

		if ($this->input->post('comment') == '') {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">comment is not to be empty.</div>';

			echo json_encode($data);
			die();
		}

		$save_data = [
			'post_id'		=> $post_id,
			'user_id'		=> $this->session->userdata('id'),
			'comment'		=> $this->input->post('comment'),
			'datetime'		=> date('Y-m-d H:i:s')
		];

		if ($this->db->insert('post_comment',$save_data)){
			$data['success'] = true;
			$data['message'] = '<div class="alert alert-success">Post comment submitted by you.</div>';
			$usr = db_get_row_data('users',array('id'=>$this->session->userdata('id')));
			$data['html'] = '<div class="single-video-author box mb-3">';
			if($usr->profile_image != ''){
				if(file_exists(FCPATH . 'upload_data/user/' . $usr->profile_image)){
					$data['html'] .= '<img class="img-fluid" src="' . BASE_URL . 'upload_data/user/' . $usr->profile_image . '" alt="' . $usr->full_name . '" data-toggle="tooltip" data-placement="bottom" title="' . $usr->full_name . '" />';
				} else {
					$data['html'] .= '<img class="img-fluid" src="' . BASE_ASSET . 'admin/images/user.png' . '" alt="' . $usr->full_name . '" data-toggle="tooltip" data-placement="bottom" title="' . $usr->full_name . '" />';
				}
			} else {
				$data['html'] .= '<img class="img-fluid" src="' . BASE_ASSET . 'admin/images/user.png' . '" alt="' . $usr->full_name . '" data-toggle="tooltip" data-placement="bottom" title="' . $usr->full_name . '" />';
			}
			$data['html'] .= '<p>' . $this->input->post('comment') . '</p>';
			$data['html'] .= '<small>' . time_elapsed_string(date('Y-m-d H:i:s')) . '</small></div>';
		} else {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Unable to comment to post.</div>';
		}

		echo json_encode($data);
	}
}