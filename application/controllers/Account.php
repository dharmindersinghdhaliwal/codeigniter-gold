<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
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
		$data['page_title'] = 'My Account';

		$data['user'] = db_get_row_data('users',array('id'=>$this->session->userdata('id')));
		$data['videos'] = db_get_all_data('videos',array('user_id'=>$this->session->userdata('id')));
		$data['channels'] = db_get_all_data('channel',array('user_id'=>$this->session->userdata('id')));

		$data['subscribers'] = 0;
		foreach ($data['channels'] as $channel) {
			$data['subscribers'] += db_get_count_data('subscribe',array('channel_id'=>$channel->id));
		}

		$data['views'] = 0;
		foreach ($data['videos'] as $video) {
			$data['views'] += db_get_count_data('history',array('video_id'=>$video->id));
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/account',$data);
		$this->load->view('front/footer',$data);
	}
}