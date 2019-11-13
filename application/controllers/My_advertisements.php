<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_advertisements extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}
		
	}

	public function index()
	{
		$data['page_title'] = 'My Advertisements';

		$data['user'] = db_get_row_data('users',array('id' => $this->session->userdata('id')));

		$data['advertisements'] = db_get_all_data('advertisement',array('user_id'=>$this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/my_advertisements',$data);
		$this->load->view('front/footer',$data);
	}

	public function delete($video_id = '')
	{
		$video = db_get_row_data('advertisement',array('id'=>$video_id,'user_id'=>$this->session->userdata('id')));

		if(count($video) == 0) {
			$this->session->set_flashdata('error', 'Video not found !');
			redirect('my_advertisements','refresh');
		}

		if(file_exists(FCPATH . 'upload_data/advt/' . $video->advertisement) && $video->advertisement != '') {
			unlink(FCPATH . 'upload_data/advt/' . $video->advertisement);
		}

		$this->db->where('id',$video_id);
		$this->db->delete('advertisement');
		
		$this->session->set_flashdata('success', 'Advertisement removed successfully.');

		redirect('/my_advertisements','refresh');
	}

	public function edit($video_id = '')
	{

		$data['page_title'] 	= 'Edit advertisement';
		$data['advertisement'] 	= db_get_row_data('advertisement',array('id'=>$video_id,'user_id'=>$this->session->userdata('id')));

		if(count($data['advertisement']) == 0) {
			$this->session->set_flashdata('error', 'Advertisement not found !');
			redirect('my_advertisements','refresh');
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/edit_advertisement',$data);
		$this->load->view('front/footer',$data);
	}

	/**
	* Remove advertisement video while doing edit advertisement
	*
	*/
	public function remove_advt_video($video_id = '')
	{
		$file_name = db_get_row_data('advertisement',array('id'=>$video_id))->advertisement;

		if(file_exists(FCPATH . 'upload_data/advt/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/advt/' . $file_name);

			$this->db->where('id',$video_id);
			if($this->db->update('advertisement',array('advertisement'=>''))){
				$this->session->set_flashdata('success', 'Advertisement file removed successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('my_advertisements/edit/' . $video_id);
	}

	public function update_advt($video_id){

		header('Content-Type: application/json');
		
		$data = [];
		$data['video'] = db_get_row_data('advertisement',array('id'=>$video_id));

		$this->form_validation->set_rules('title', 'Advertisement Title', 'trim|required');
		//$this->form_validation->set_rules('myVideo', 'Channel Video', 'trim|required');
		//$this->form_validation->set_rules('selectTiming', 'Timing ', 'trim|required');
		
		$file = true;
		if(isset($_FILES["advtVideo"]["name"])) {
			if($_FILES["advtVideo"]["name"] != ''){
				$fileType = strtolower(pathinfo($_FILES["advtVideo"]["name"],PATHINFO_EXTENSION));
				if($fileType == 'MP4' || $fileType == 'FLV' || $fileType == 'WEBM' || $fileType == 'mp4' || $fileType == 'flv' || $fileType == 'webm'){
					$file = true;
				} else {
					$file = false;
					$data['message'] .= '<div class="alert alert-danger">Sorry video file is only allow <b>MP4 | FLV | WEBM</b>.</div>';
				}
			} 
		}
		if ($this->form_validation->run() && $file == true) {

			if($data['video']->admin_approve==1){
				$save_data = [				
				'status' 	=> $this->input->post('status')				
			];
			
			}else{
				$save_data = [
					'title' 	=> $this->input->post('title'),
					'video_id' 	=> $this->input->post('myVideo'),
					'user_id' 	=> $this->session->userdata('id'),
					'timing' 	=> $this->input->post('selectTiming'),
					'status' 	=> $this->input->post('status'),					
				];
			}
			
			if(isset($_FILES["advtVideo"]["name"])) {
				$target_dir = FCPATH . "upload_data/advt/";
				if($_FILES["advtVideo"]["name"] != ''){
					if($data['video']->advertisement != ''){
						unlink($target_dir . $data['video']->advertisement);
					}
					$fileType = strtolower(pathinfo($_FILES["advtVideo"]["name"],PATHINFO_EXTENSION));
					if($fileType == 'MP4' || $fileType == 'FLV' || $fileType == 'WEBM' || $fileType == 'mp4' || $fileType == 'flv' || $fileType == 'webm'){
						$file_name = $this->session->userdata('id') . '-video-' . time() . '.' . $fileType;
						$target_file = $target_dir . $file_name;
						if(move_uploaded_file($_FILES["advtVideo"]["tmp_name"], $target_file)) {
							$save_data['advertisement'] = $file_name;
						}
					}
				}
			}

			$this->db->where('id',$video_id);
			if($this->db->update('advertisement',$save_data)){
				$data['success'] = true;
				$this->session->set_flashdata('success', 'Your advertisement content is updated successfully.');
			}
		} else {
			$data['success'] = false;
			$data['message'] .= '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}
	/**
	* Redirect to Payment Method
	**/
	public function payment($advt_id){

		if(empty($advt_id)){
			$this->session->set_flashdata('error', 'Advertisement id is missing');
			redirect('my_advertisements','refresh');
		}

		$advt = db_get_row_data('advertisement',array('id' => $advt_id));
		
		//check if already paid for this advertisement
		if(isset($advt->payment_status)&& $advt->payment_status==1){
			$this->session->set_flashdata('error', 'You have already paid for this advertisement');
			redirect('my_advertisements','refresh');
		}

		$data['page_title'] = 'Payment Methods';
		$data['advt_id'] 	= $advt_id;

		$this->load->view('front/header',$data);
		$this->load->view('front/payment_methods',$data);
		$this->load->view('front/footer',$data);

	}

}