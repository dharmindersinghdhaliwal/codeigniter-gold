<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisements extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_loggedin')){
			redirect('admin/login');
		}
	}

	public function index(){
		$data['page_title'] 	= 'All Advertisements';
		$data['advertisements'] = db_get_all_data('advertisement');
		
		$this->load->view('admin/header',$data);
		$this->load->view('admin/advertisements/list',$data);
		$this->load->view('admin/footer',$data);
	}
	
	public function admin_approve_disapprove(){

		$data = [];
		$advt_id 		= $this->input->post('advt_id');
		$admin_approve 	= $this->input->post('admin_approve');
		$user_id  		= $this->user_by_advertisement($advt_id);

		$newStatus 	= 1;
		$text 		= 'Accepted';
		if($admin_approve==1){
			$newStatus 	= 0;
			$text 		= 'Declined';
		}
		$update_data = [
			'admin_approve' => $newStatus,			
			'date_updated' 	=> date('Y-m-d H:i:s'),
		];

		$this->db->where('id',$advt_id);
		if($this->db->update('advertisement',$update_data)){

			$advt = db_get_row_data('advertisement',array('id' => $advt_id));
			$notification_data=[
				'user_id' 	=> $user_id,
				'user_type' => 'user',
				'message' 	=> 'Your Advertisement <strong>'.substr($advt->title,0,30).'...'.'</strong> has been '. $text.' by admin ',
				'datetime' 	=> date('Y-m-d H:i:s'),
				'status' 	=> 0
			];

			$this->db->insert('notification',$notification_data);

			$data['success'] = true;
			$data['message'] = '<div class="alert alert-success">Advertisement status changed.</div>';

		}else{
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Advertisement status could not changed.</div>';
		}
		
		echo json_encode($data);
	}

	/**
	* Get user id by advt id
	*/
	public function user_by_advertisement($advt_id){

		$advertisement = db_get_row_data('advertisement',array('id' => $advt_id));

		if(isset($advertisement->user_id)){
			return $advertisement->user_id;
		}

	}
	/**
	* Review advertisement
	*/
	public function review($advt_id=''){

		if(empty($advt_id)){
			$this->session->set_flashdata('error', 'Advertisement id is missing');
			redirect('admin/advertisements','refresh');
		}
		$data['advertisement'] = db_get_row_data('advertisement',array('id' => $advt_id));
		$this->load->view('admin/header',$data);
		$this->load->view('admin/advertisements/review-advertisement',$data);
		$this->load->view('admin/footer',$data);

	}

	public function add_price($advt_id=''){

		if(empty($advt_id)){
			$this->session->set_flashdata('error', 'Advertisement id is missing');
			redirect('admin/advertisements','refresh');
		}
		
		$update_data = [
			'price' 			=> $this->input->post('price'),				
			'date_updated' 		=> date('Y-m-d H:i:s'),
		];
		$this->db->where('id',$advt_id);
		if($this->db->update('advertisement',$update_data)){
			$this->session->set_flashdata('success', 'Price added successfully for this advertisement');
			redirect('admin/advertisements/review/'.$advt_id,'refresh');
		}else{
			$this->session->set_flashdata('error', 'Price could not added');
			redirect('admin/advertisements/review/'.$advt_id,'refresh');
		}

	}

}