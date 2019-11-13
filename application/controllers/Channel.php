<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($custom_url = '')
	{
		if(empty($custom_url)) {
			$this->session->set_flashdata('error', 'channel not found !');
			redirect('channels','refresh');
		}

		$data['channel'] = db_get_row_data('channel',array('custom_url'=>$custom_url));

		if(count($data['channel']) == 0) {
			$this->session->set_flashdata('error', 'invalid channel url !');
			redirect('channels','refresh');
		}

		$data['videos'] = db_get_all_data('videos',array('channel_id'=>$data['channel']->id));

		$data['page_title'] = ucwords(str_replace("-", " ", $custom_url));

		if(!$this->session->userdata('loggedin')) {
			$this->form_validation->set_rules('email', 'Email', 'required');
		}
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');

		if ($this->form_validation->run()) {
			$save_data = [
				'channel_id' => $channel_id,
				'owner_id' => $data['channel']->user_id,
				'title' => $this->input->post('title'),
				'message' => $this->input->post('message'),
				'date_created' => date('Y-m-d H:i:s'),
				'status' => 1,
			];

			if(!$this->session->userdata('loggedin')) {
				$save_data['email'] = $this->input->post('email');
			} else {
				$save_data['email'] = $this->session->userdata('email');
			}

			if($this->db->insert('user_query',$save_data)){
				$this->session->set_flashdata('success', 'Your Query is submitted successfully.');
				redirect('channels/view/' . $channel_id);
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/channel_view',$data);
		$this->load->view('front/footer',$data);
	}
}