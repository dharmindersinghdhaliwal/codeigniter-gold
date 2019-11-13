<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_search');
	}

	public function index()
	{
		$data['page_title'] = 'Search';

		$string = $this->input->get('srch');
	
		$data['data'] = $this->model_search->get_result($string);		
		//	echo '<pre>';print_r( $data );exit; 
		
		$this->load->view('front/header',$data);
		$this->load->view('front/search_view',$data);
		$this->load->view('front/footer',$data);
	}
}