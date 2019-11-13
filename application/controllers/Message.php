<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller
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
		$data['page_title'] = 'All Messages';

		$data['user_queries'] = db_get_all_data('user_query',array('owner_id'=>$this->session->userdata('id')),false,'date_created DESC');

		$this->load->view('front/header',$data);
		$this->load->view('front/message',$data);
		$this->load->view('front/footer',$data);
	}

	public function view($message_id = '')
	{
		$data['page_title'] = 'Message';

		$data['user_query'] = db_get_row_data('user_query',array('id'=>$message_id,'owner_id'=>$this->session->userdata('id')));

		if(count($data['user_query']) == 0) {
			$this->session->set_flashdata('error', 'Sorry message is no more !');
			redirect('message','refresh');
		}

		$data['channel'] = db_get_row_data('channel',array('id'=>$data['user_query']->channel_id));

		// Change Message Status 
		$this->update_message_status($message_id);

		$this->load->view('front/header',$data);
		$this->load->view('front/message_view',$data);
		$this->load->view('front/footer',$data);
	}

	public function update_message_status($message_id = '')
	{

		if(!empty($message_id)){

			$this->db->where('id',$message_id);
			$save_data['status'] = 1;
			$this->db->update('user_query',$save_data);

		}

	}
	
}