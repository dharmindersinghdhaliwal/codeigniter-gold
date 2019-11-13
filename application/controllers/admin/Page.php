<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_loggedin')){
			redirect('admin/login');
		}
	}

	public function index()
	{

		$data['page_title'] = 'Admin Web-Pages';

		$this->load->view('admin/header',$data);
		$this->load->view('admin/pages',$data);
		$this->load->view('admin/footer',$data);
	}

	public function edit()
	{
		$data['page_title'] = 'Admin Update Terms And Conditions Page';

		$this->load->view('admin/header',$data);
		$this->load->view('admin/page_edit',$data);
		$this->load->view('admin/footer',$data);
	}

	public function save()
	{
		header('Content-Type: application/json');
		$data = [];
		$this->form_validation->set_rules('terms_and_conditions', 'Terms And Conditions Page', 'trim|required');

		if ($this->form_validation->run()) {
			set_option('terms_and_conditions', $this->input->post('terms_and_conditions'));

			$data['success'] = true;
			$data['message'] = '<div class="alert alert-success">Your setting has been successfully updated.</div>';
		} else {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}
}