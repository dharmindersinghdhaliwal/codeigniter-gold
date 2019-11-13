<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_advertisement extends CI_Controller
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
		$data['page_title'] = 'Video Advertisement';

		$data['user'] = db_get_row_data('users',array('id' => $this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/video_advertisement',$data);
		$this->load->view('front/footer',$data);
	}

	public function submit_advt(){
		
		header('Content-Type: application/json');
		$data = [];
		$data['message'] = '';
		
		$this->form_validation->set_rules('title', 'Advertisement Title', 'trim|required');
		$this->form_validation->set_rules('myVideo', 'Channel Video', 'trim|required');
		$this->form_validation->set_rules('selectTiming', 'Timing ', 'trim|required');
		
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
			} else {
				$file = false;
				$data['message'] .= '<div class="alert alert-danger">Sorry video file is not selected.</div>';
			}
		}
		if ($this->form_validation->run() && $file == true) {
			$save_data = [
				'title' 		=> $this->input->post('title'),
				'video_id' 		=> $this->input->post('myVideo'),
				'user_id' 		=> $this->session->userdata('id'),
				'timing' 		=> $this->input->post('selectTiming'),				
				'date_created' 	=> date('Y-m-d H:i:s'),
				'date_updated' 	=> date('Y-m-d H:i:s'),
				'status' 		=> 0
			];

			if(isset($_FILES["advtVideo"]["name"])) {
				$target_dir_video = FCPATH . "upload_data/advt/";
				if($_FILES["advtVideo"]["name"] != ''){
					$video_fileType = strtolower(pathinfo($_FILES["advtVideo"]["name"],PATHINFO_EXTENSION));
					if($video_fileType == 'MP4' || $video_fileType == 'FLV' || $video_fileType == 'WEBM' || $video_fileType == 'mp4' || $video_fileType == 'flv' || $video_fileType == 'webm'){
						$video_file_name = $this->session->userdata('id') . '-advrtise-' . time() . '.' . $video_fileType;
						$target_file_video = $target_dir_video . $video_file_name;
						if(move_uploaded_file($_FILES["advtVideo"]["tmp_name"], $target_file_video)) {
							$save_data['advertisement'] = $video_file_name;
						}
					}
				}
			}

			if($this->db->insert('advertisement',$save_data)){
				$data['success'] = true;
				$data['message'] .= '<div class="alert alert-success">Your advertisement submitted successfully !</div>';
			}
		} else {
			$data['success'] = false;
			$data['message'] .= '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}
	
}