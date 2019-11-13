<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Watch_later extends CI_Controller
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
		$data['page_title'] = 'Watch Later Videos';

		$data['video_watch_laters'] = db_get_all_data('video_watch_later',array('user_id'=>$this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/watch_later',$data);
		$this->load->view('front/footer',$data);
	}

	public function remove($watch_id)
	{
		$this->db->where('id',$watch_id);
		if($this->db->delete('video_watch_later')) {
			$this->session->set_flashdata('success', 'Watch Later record removed.');
		}

		redirect('/watch_later');
	}
}