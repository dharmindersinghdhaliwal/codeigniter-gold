<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller
{
	public function __construct(){
		parent::__construct();

		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}
	}

	public function index()	{
		$data['page_title'] = 'Orders';
		
		$this->load->view('admin/header',$data);
		$this->load->view('admin/orders/list',$data);
		$this->load->view('admin/footer',$data);
	}

	public function make_payment($advt_id){

		$amountDetail = $this->input->get('amountDetail');

		header('Content-Type: application/json');
		$data = [];
		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';
			echo json_encode($data);
			die();
		}
		if(empty($advt_id)){
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Advertisement not found.</div>';
			echo json_encode($data);
			die();
		}

		$update_data = [
			'status' 		=> 1,
			'payment_status'=> 1,
			'date_updated' 	=> date('Y-m-d H:i:s'),
		];

		//Insert order
		if($this->insert_order()){

			$this->db->where('id',$advt_id);
			if($this->db->update('advertisement',$update_data)){

				# notification to user
				$advt = db_get_row_data('advertisement',array('id' => $advt_id));
				$notification_data=[
					'user_id' 	=> $this->session->userdata('id'),
					'user_type' => 'user',
					'message' 	=> 'Payment success for <strong>'.substr($advt->title,0,30).'...</strong>',
					'datetime' 	=> date('Y-m-d H:i:s'),
					'status' 	=> 0
				];

				$this->db->insert('notification',$notification_data);

				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success">Payment successfully completed.</div>';
				$data['redirect'] = BASE_URL.'my_advertisements/';

			}else{
				$data['success'] = false;
				$data['message'] = '<div class="alert alert-danger">Advertisement status could not changed.</div>';
			}
		}else{
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Order Could not created.</div>';
		}

		echo json_encode($data);
		die();
	}

	public function insert_order(){

		$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');

    	$amountDetail = $this->input->get('amountDetail');
		$save_data = [
			'user_id' 			=> $this->session->userdata('id'),
			'txn_id' 			=> $this->input->get('txn_id'),
			'payment_gross'		=> $amountDetail['value'],
			'currency_code' 	=> $amountDetail['currency_code'],
			'payer_email' 		=> $this->input->get('payer_email'),
			'payment_status'	=> $this->input->get('payment_status'),
			'datetime' 			=> date('Y-m-d H:i:s'),
			'ip' 				=> $ip
		];

		if($this->db->insert('user_payment',$save_data)){
			return true;
		}

	}

}