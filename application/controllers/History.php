<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$this->load->model('model_history');
	}

	public function index()
	{

		$data['page_title'] = 'History';

		$data['histories'] = $this->model_history->get_history();

		$this->load->view('front/header',$data);
		$this->load->view('front/history',$data);
		$this->load->view('front/footer',$data);
	}

	public function remove($history_id)
	{
		$this->db->where('id',$history_id);
		if($this->db->delete('history')) {
			$this->session->set_flashdata('success', 'History record removed.');
		}

		redirect('/history');
	}
}