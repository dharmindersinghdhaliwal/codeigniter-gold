<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
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
		$data['page_title'] = 'Upload Video';
		$data['channel_id'] = $this->input->get('chnl');

		if(!empty($data['channel_id'])){
			if(db_get_count_data('channel',array('id'=>$data['channel_id'])) == 0){
				$this->session->set_flashdata('error', 'Your channel is no more !');
				redirect('channels','refresh');
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/upload',$data);
		$this->load->view('front/footer',$data);
	}

	public function upload_save()
	{
		$config['max_size'] = '2097152';
		header('Content-Type: application/json');
		$data = [];
		$data['message'] = '';

		$this->form_validation->set_rules('title', 'Video Title', 'trim|required');
		$this->form_validation->set_rules('channel_id', 'Channel', 'trim|required');
		
		$file = true;
		if(isset($_FILES["video"]["name"])) {
			if($_FILES["video"]["name"] != ''){
				$fileType = strtolower(pathinfo($_FILES["video"]["name"],PATHINFO_EXTENSION));
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
			$category_id = db_get_row_data('channel',array('id'=>$this->input->post('channel_id')))->category_id;
			$save_data = [
				'title' 		=> $this->input->post('title'),
				'description' 	=> $this->input->post('description'),
				'category_id' 	=> $category_id,
				'channel_id' 	=> $this->input->post('channel_id'),
				'user_id' 		=> $this->session->userdata('id'),
				'tags' 			=> $this->input->post('tags'),
				'date_created' 	=> date('Y-m-d H:i:s'),
				'status' 		=> 1,
				'duration' 			=> $this->input->post('duration'),

			];

			if(isset($_FILES["video"]["name"])) {
				$target_dir_video = FCPATH . "upload_data/video/";
				if($_FILES["video"]["name"] != ''){
					$video_fileType = strtolower(pathinfo($_FILES["video"]["name"],PATHINFO_EXTENSION));
					if($video_fileType == 'MP4' || $video_fileType == 'FLV' || $video_fileType == 'WEBM' || $video_fileType == 'mp4' || $video_fileType == 'flv' || $video_fileType == 'webm'){
						$video_file_name = $this->session->userdata('id') . '-video-' . time() . '.' . $video_fileType;
						$target_file_video = $target_dir_video . $video_file_name;
						if(move_uploaded_file($_FILES["video"]["tmp_name"], $target_file_video)) {
							$save_data['video'] = $video_file_name;
						}
					}
				}
			}

			if(isset($_POST["video_thumbnail"])) {
				if($_POST["video_thumbnail"] != ''){
					$target_dir_image = FCPATH . "upload_data/video/thumbnail/";
					$image_file_name = $this->session->userdata('id') . '-video-thumbnail-' . time() . '.png';
					$img = $_POST['video_thumbnail'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$imgData = base64_decode($img);
					if(file_put_contents($target_dir_image . $image_file_name, $imgData)){
						$save_data['video_thumbnail'] = $image_file_name;
					}
				}
			}

			if($this->db->insert('videos',$save_data))
			{
				$data['success'] = true;
				$this->session->set_flashdata('success', 'Your video is uploaded and saved successfully.');
			}
		} else {
			$data['success'] = false;
			$data['message'] .= '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}

	public function upload_update($video_id)
	{
		header('Content-Type: application/json');
		$data = [];
		$data['message'] = '';
		$data['video'] = db_get_row_data('videos',array('id'=>$video_id));

		$this->form_validation->set_rules('title', 'Video Title', 'trim|required');
		$this->form_validation->set_rules('channel_id', 'Channel', 'trim|required');

		$file = true;
		if(isset($_FILES["video"]["name"])) {
			if($_FILES["video"]["name"] != ''){
				$fileType = strtolower(pathinfo($_FILES["video"]["name"],PATHINFO_EXTENSION));
				if($fileType == 'MP4' || $fileType == 'FLV' || $fileType == 'WEBM' || $fileType == 'mp4' || $fileType == 'flv' || $fileType == 'webm'){
					$file = true;
				} else {
					$file = false;
					$data['message'] .= '<div class="alert alert-danger">Sorry video file is only allow <b>MP4 | FLV | WEBM</b>.</div>';
				}
			}
		}

		if ($this->form_validation->run() && $file == true) {
			$category_id = db_get_row_data('channel',array('id'=>$this->input->post('channel_id')))->category_id;
			$save_data = [
				'title' 		=> $this->input->post('title'),
				'description' 	=> $this->input->post('description'),
				'category_id' 	=> $category_id,
				'channel_id' 	=> $this->input->post('channel_id'),
				'user_id' 		=> $this->session->userdata('id'),
				'embed_code' 	=> $this->input->post('embed_code'),
				'tags' 			=> $this->input->post('tags'),
				'date_updated' 	=> date('Y-m-d H:i:s'),
				'duration' 			=> $this->input->post('duration'),
			];

			if(isset($_FILES["video"]["name"])) {
				$target_dir = FCPATH . "upload_data/video/";
				if($_FILES["video"]["name"] != ''){
					if($data['video']->video != ''){
						unlink($target_dir . $data['video']->video);
					}
					$fileType = strtolower(pathinfo($_FILES["video"]["name"],PATHINFO_EXTENSION));
					if($fileType == 'MP4' || $fileType == 'FLV' || $fileType == 'WEBM' || $fileType == 'mp4' || $fileType == 'flv' || $fileType == 'webm'){
						$file_name = $this->session->userdata('id') . '-video-' . time() . '.' . $fileType;
						$target_file = $target_dir . $file_name;
						if(move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
							$save_data['video'] = $file_name;
						}
					}
				}
			}


			if(isset($_POST["video_thumbnail"])) {
				if($_POST["video_thumbnail"] != ''){
					$target_dir_image = FCPATH . "upload_data/video/thumbnail/";

					if($data['video']->video_thumbnail != ''){
						unlink($target_dir_image . $data['video']->video_thumbnail);
					}

					$image_file_name = $this->session->userdata('id') . '-video-thumbnail-' . time() . '.png';
					$img = $_POST['video_thumbnail'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$imgData = base64_decode($img);
					if(file_put_contents($target_dir_image . $image_file_name, $imgData)){
						$save_data['video_thumbnail'] = $image_file_name;
					}
				}
			}

			$this->db->where('id',$video_id);
			if($this->db->update('videos',$save_data))
			{
				$data['success'] = true;
				$this->session->set_flashdata('success', 'Your video content is updated successfully.');
			}
		} else {
			$data['success'] = false;
			$data['message'] .= '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}
}