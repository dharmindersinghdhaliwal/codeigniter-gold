<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follower extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = [];
		$data['page_title'] = 'My Followers';

		$data['followers'] = db_get_all_data('user_follow',array('follow_id'=>$this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/follower',$data);
		$this->load->view('front/footer',$data);
	}

	public function follow($follow_id = '')
	{
		header('Content-Type: application/json');
		$data = [];

		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';

			echo json_encode($data);
			die();
		}

		$user = db_get_row_data('users',array('id'=>$follow_id));

		if (count($user) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">User is no more.</div>';

			echo json_encode($data);
			die();
		}

		$user_follow = db_get_row_data('user_follow',array('follow_id'=>$follow_id,'user_id'=>$this->session->userdata('id')));

		if (count($user_follow) == 0) {
			$save_data = [
				'follow_id'	=> $follow_id,
				'user_id'	=> $this->session->userdata('id'),
				'datetime'	=> date('Y-m-d H:i:s'),
				'status'	=> 0
			];

			$this->db->insert('user_follow',$save_data);
			$data['success'] = true;
			$data['type'] = 'followed';
			$data['user_follow_count'] = db_get_count_data('user_follow',array('follow_id'=>$follow_id));
			$data['message'] = '<div class="alert alert-success">You Follow ' . $user->full_name . '</div>';

			$message = $this->session->userdata('full_name') . ' Follow you';
			make_notification($follow_id,'user',$message);
		} else {
			$this->db->where('id',$user_follow->id);
			$this->db->delete('user_follow');
			$data['success'] = true;
			$data['type'] = 'follow';
			$data['user_follow_count'] = db_get_count_data('user_follow',array('follow_id'=>$follow_id));
			$data['message'] = '<div class="alert alert-warning">You un-follow ' . $user->full_name . '.</div>';

			$message = $this->session->userdata('full_name') . ' unfollow you';
			make_notification($user_follow->id,'user',$message);
		}

		
		echo json_encode($data);
	}
}