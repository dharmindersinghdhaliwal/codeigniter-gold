<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_subscribers extends CI_Controller
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

		$data['page_title'] = 'My subscribers';

		$data['channel'] = db_get_all_data('channel',array('user_id'=>$this->session->userdata('id')));
		
		//	echo '<pre>'; print_r( $data['channel'] ); exit; 

		if(count($data['channel']) == 0) {
			$this->session->set_flashdata('error', 'Sorry You don\'t have any channel !');
			redirect('dashboard','refresh');
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/my_subscribers',$data);
		$this->load->view('front/footer',$data);
	}
}