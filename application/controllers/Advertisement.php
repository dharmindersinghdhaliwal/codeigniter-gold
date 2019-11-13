<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisement extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$this->load->library('paypal_lib');
	}

	public function index()
	{
		$data['page_title'] = 'My Promotion';

		$data['user'] = db_get_row_data('users',array('id' => $this->session->userdata('id')));


		$this->load->view('front/header',$data);
		$this->load->view('front/advertisement',$data);
		$this->load->view('front/footer',$data);
	}

	public function buy()
	{
		$this->form_validation->set_rules('advertise', 'Advertise', 'trim|required');

		if ($this->form_validation->run()) {
			$this->db->where('id',$this->session->userdata('id'));
			$this->db->update('users',array('advertise' => $this->input->post('advertise')));

			$returnURL = BASE_URL . 'payment/success';
			$cancelURL = BASE_URL . 'payment/cancel';
			$notifyURL = BASE_URL . 'payment/ipn';

			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('item_name', $this->session->userdata('full_name') . ' Advertisement');
			$this->paypal_lib->add_field('custom', $this->session->userdata('id'));
			$this->paypal_lib->add_field('item_number',  session_id());
			$this->paypal_lib->add_field('amount',  30);

			$this->paypal_lib->paypal_auto_form();
		} else {
			$this->session->set_flashdata('error',validation_errors());
			redirect('advertisement','refresh');
		}
	}
}