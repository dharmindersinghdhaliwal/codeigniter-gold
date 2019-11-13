<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_payments extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		if(!$this->session->userdata('admin_loggedin')){
			redirect('admin/login');
		}
	}

	public function index(){
		
		$data['page_title'] = 'Orders';
		$data['orders'] 	= db_get_all_data('user_payment');

		$this->load->view('admin/header',$data);
		$this->load->view('admin/orders/list',$data);
		$this->load->view('admin/footer',$data);

	}

}