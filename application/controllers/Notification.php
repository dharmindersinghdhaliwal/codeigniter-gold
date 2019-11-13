<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller
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
		$data['page_title'] = 'All Notifications';

		$data['notifications'] = db_get_all_data('notification',array('user_type'=>'user','user_id'=>$this->session->userdata('id')),false,'datetime DESC');

		$this->change_notification_status($data['notifications']);

		$this->load->view('front/header',$data);
		$this->load->view('front/notification',$data);
		$this->load->view('front/footer',$data);
		
	}

	public function change_notification_status($notifications){

		foreach ($notifications as $notification) {
			
			$this->db->where('id',$notification->id);
			$save_data['status'] = 1;
			$this->db->update('notification',$save_data);
		}

	}

}