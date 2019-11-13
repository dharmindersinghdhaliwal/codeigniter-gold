<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function sub($channel_id = '')
	{
		header('Content-Type: application/json');
		$data = [];

		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';

			echo json_encode($data);
			die();
		}

		$channel = db_get_row_data('channel',array('id'=>$channel_id));

		if (count($channel) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Channel is no more.</div>';

			echo json_encode($data);
			die();
		}

		$user_type = db_get_row_data('users',array('id'=>$channel->user_id))->type;

		if ($user_type == 'admin') {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You are not allow to unsubscribe admin\'s channel.</div>';

			echo json_encode($data);
			die();
		}

		$subscribe = db_get_row_data('subscribe',array('channel_id'=>$channel_id,'user_id'=>$this->session->userdata('id')));

		if (count($subscribe) == 0) {
			$save_data = [
				'channel_id'	=> $channel_id,
				'user_id'		=> $this->session->userdata('id'),
				'date_created'	=> date('Y-m-d H:i:s')
			];

			$this->db->insert('subscribe',$save_data);
			$data['success'] = true;
			$data['type'] = 'subscribed';
			$data['channel_subs_count'] = db_get_count_data('subscribe',array('channel_id'=>$channel_id));
			$data['message'] = '<div class="alert alert-success">Channel subscribed.</div>';

			if($data['channel_subs_count'] >= 100){
				$this->db->where('id',$channel_id);
				$this->db->update('channel',array('verified' => 1));
			}
			$message = $this->session->userdata('full_name') . ' subscribed your channel ' . $channel->name;
			make_notification($channel->user_id,'user',$message);
		} else {
			$this->db->where('id',$subscribe->id);
			$this->db->delete('subscribe');
			$data['success'] = true;
			$data['type'] = 'unsubscribed';
			$data['channel_subs_count'] = db_get_count_data('subscribe',array('channel_id'=>$channel_id));
			$data['message'] = '<div class="alert alert-warning">Channel un-subscribed.</div>';

			$message = $this->session->userdata('full_name') . ' unsubscribed your channel ' . $channel->name;
			make_notification($channel->user_id,'user',$message);
		}

		
		echo json_encode($data);
	}
}