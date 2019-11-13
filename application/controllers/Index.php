<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = [];
		$data['page_title'] = 'Home';

		$data['videos'] = db_get_all_data('videos',false,false,'date_created DESC',8);
		if(!$this->session->userdata('loggedin')) {
			$data['channels'] = db_get_all_data('channel',false,false,'date_created DESC',8);
		} else {
			$data['channels'] = db_get_all_data('channel',array('user_id !='=>$this->session->userdata('id')),false,'date_created DESC',8);
		}
		$this->load->view('front/header',$data);
		$this->load->view('front/index',$data);
		$this->load->view('front/footer',$data);
	}

	public function page($page_name)
	{
		$data = [];
		$data['page_title'] = ucwords(str_replace("_", " ", $page_name));

		$data['page'] = get_option($page_name);

		$this->load->view('front/header',$data);
		$this->load->view('front/page',$data);
		$this->load->view('front/footer',$data);
	}

	public function fetch_state()
	{
		$country_id = $this->input->get('country_id');
		$state_id = $this->input->get('state_id');

		$states = db_get_all_data('states',array('country_id'=>$country_id));
		foreach($states as $state){
			echo '<option value="' . $state->id . '" ' . (($state_id == $state->id)? 'selected' : '') . '>' . $state->name . '</option>';
		}
	}
}