<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller
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

	public function success(){
		$paypalInfo = $this->input->get();

		$this->session->set_flashdata('success', 'Payment success and your advertisement is submitted successfully.');
		redirect('dashboard','refresh');
	}

	public function cancel(){
		$this->session->set_flashdata('error', 'Payment cancelled.');
		redirect('advertisement','refresh');
	}

	public function ipn(){
		$paypalInfo = $this->input->post();

		if(!empty($paypalInfo)){
			$ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);

			if($ipnCheck){
				$save_data['user_id']			= $paypalInfo["custom"];
				$save_data['txn_id']			= $paypalInfo["txn_id"];
				$save_data['payment_gross']		= $paypalInfo["mc_gross"];
				$save_data['currency_code']		= $paypalInfo["mc_currency"];
				$save_data['payer_email']		= $paypalInfo["payer_email"];
				$save_data['payment_status']	= $paypalInfo["payment_status"];
				$save_data['datetime']			= date('Y-m-d H:i:s');
				$save_data['ip']				= $ip;

				if($this->db->insert('user_payment',$save_data)){
					$payment_id = $this->db->insert_id();

					$this->db->where('id',$this->session->userdata('id'));
					$this->db->update('users',array('payment_id' => $payment_id, 'allow_ad' => 1));
				}
			}
		}
	}
}