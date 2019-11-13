<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($category_id = '')
	{
		$data['page_title'] = 'Category';

		$data['category'] = db_get_row_data('category',array('id'=>$category_id));
		$data['videos'] = db_get_all_data('videos',array('category_id'=>$category_id),false,'date_created DESC',8);
		if(!$this->session->userdata('loggedin')) {
			$data['channels'] = db_get_all_data('channel',array('category_id'=>$category_id),false,'date_created DESC',8);
		} else {
			$data['channels'] = db_get_all_data('channel',array('category_id'=>$category_id,'user_id !='=>$this->session->userdata('id')),false,'date_created DESC',8);
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/category',$data);
		$this->load->view('front/footer',$data);
	}
}