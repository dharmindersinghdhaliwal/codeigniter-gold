<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_loggedin')){
			redirect('admin/login');
		}
	}

	public function index()
	{
		$data['page_title'] = 'All Videos';

		$data['videos'] = db_get_all_data('videos',array('user_id'=>$this->session->userdata('id')));

		$this->load->view('admin/header',$data);
		$this->load->view('admin/video/list',$data);
		$this->load->view('admin/footer',$data);
	}

	public function add()
	{
		$data['page_title'] = 'Add New Video';

		$this->load->view('admin/header',$data);
		$this->load->view('admin/video/add',$data);
		$this->load->view('admin/footer',$data);
	}

	public function add_save()
	{
		header('Content-Type: application/json');
		$data = [];
		$data['message'] = '';

		$this->form_validation->set_rules('title', 'Video Title', 'trim|required');
		$this->form_validation->set_rules('channel_id', 'Channel', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required');

		$save_data = [
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'category_id' => $this->input->post('category_id'),
			'channel_id' => $this->input->post('channel_id'),
			'user_id' => $this->session->userdata('id'),
			'tags' => $this->input->post('tags'),
			'date_created' => date('Y-m-d H:i:s'),
			'status' => 1
		];

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

		if(isset($_FILES["video_thumbnail"]["name"])) {
			if($_FILES["video_thumbnail"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["video_thumbnail"]["tmp_name"]);
				if($width > 300 || $height > 300){
					$file = false;
					$data['message'] .= '<div class="alert alert-danger">Image dimension should be in between "width : 300px | height : 300px.</div>';
				}
			} else {
				$file = false;
				$data['message'] .= '<div class="alert alert-danger">Choose your custom video thumbnail.</div>';
			}
		}

		if ($this->form_validation->run() && $file == true) {
			if(isset($_FILES["video"]["name"])) {
				$target_dir = FCPATH . "upload_data/video/";
				if($_FILES["video"]["name"] != ''){
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

			if(isset($_FILES["video_thumbnail"]["name"])) {
				$target_dir = FCPATH . "upload_data/video/thumbnail/";
				if($_FILES["video_thumbnail"]["name"] != ''){
					$fileType = strtolower(pathinfo($_FILES["video_thumbnail"]["name"],PATHINFO_EXTENSION));
					$file_name = $this->session->userdata('id') . '-video-thumbnail-' . time() . '.' . $fileType;
					$target_file = $target_dir . $file_name;
					if(move_uploaded_file($_FILES["video_thumbnail"]["tmp_name"], $target_file)) {
						$save_data['video_thumbnail'] = $file_name;
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

	public function edit($id = '')
	{
		$data['page_title'] = 'Update Video';
		$data['video'] = db_get_row_data('videos',array('id'=>$id));

		$this->load->view('admin/header',$data);
		$this->load->view('admin/video/edit',$data);
		$this->load->view('admin/footer',$data);
	}

	public function edit_save($video_id = '')
	{
		header('Content-Type: application/json');
		$data = [];
		$data['message'] = '';
		$data['video'] = db_get_row_data('videos',array('id'=>$video_id));

		$this->form_validation->set_rules('title', 'Video Title', 'trim|required');
		$this->form_validation->set_rules('channel_id', 'Channel', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required');

		$save_data = [
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'category_id' => $this->input->post('category_id'),
			'channel_id' => $this->input->post('channel_id'),
			'user_id' => $this->session->userdata('id'),
			'embed_code' => $this->input->post('embed_code'),
			'tags' => $this->input->post('tags'),
			'date_updated' => date('Y-m-d H:i:s')
		];

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

		if(isset($_FILES["video_thumbnail"]["name"])) {
			if($_FILES["video_thumbnail"]["name"] != ''){
				list($width, $height) = getimagesize($_FILES["video_thumbnail"]["tmp_name"]);
				if($width > 300 || $height > 300){
					$file = false;
					$data['message'] .= '<div class="alert alert-danger">Image dimension should be in between "width : 300px | height : 300px.</div>';
				}
			}
		}

		if ($this->form_validation->run() && $file == true) {
			if(isset($_FILES["video"]["name"])) {
				$target_dir = FCPATH . "upload_data/video/";
				if($_FILES["video"]["name"] != ''){
					if($data['video']->video != ''){
						unlink(FCPATH . "upload_data/video/" . $data['video']->video);
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

			if(isset($_FILES["video_thumbnail"]["name"])) {
				$target_dir = FCPATH . "upload_data/video/thumbnail/";
				if($_FILES["video_thumbnail"]["name"] != ''){
					if($data['video']->video_thumbnail != ''){
						unlink(FCPATH . "upload_data/video/thumbnail" . $data['video']->video_thumbnail);
					}
					$fileType = strtolower(pathinfo($_FILES["video_thumbnail"]["name"],PATHINFO_EXTENSION));
					$file_name = $this->session->userdata('id') . '-video-thumbnail-' . time() . '.' . $fileType;
					$target_file = $target_dir . $file_name;
					if(move_uploaded_file($_FILES["video_thumbnail"]["tmp_name"], $target_file)) {
						$save_data['video_thumbnail'] = $file_name;
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

	public function delete($video_id = '')
	{
		$video = db_get_row_data('videos',array('id'=>$video_id,'user_id'=>$this->session->userdata('id')));

		if(count($video) == 0) {
			$this->session->set_flashdata('error', 'Video not found !');
			redirect('my_videos','refresh');
		}

		if(file_exists(FCPATH . 'upload_data/video/' . $video->video) && $video->video != '') {
			unlink(FCPATH . 'upload_data/video/' . $video->video);
		}

		if(file_exists(FCPATH . 'upload_data/video/thumbnail/' . $video->video_thumbnail) && $video->video_thumbnail != '') {
			unlink(FCPATH . 'upload_data/video/thumbnail/' . $video->video_thumbnail);
		}

		$this->db->where('video_id',$video_id);
		$this->db->delete('history');

		$this->db->where('video_id',$video_id);
		$this->db->delete('video_comment');

		$this->db->where('video_id',$video_id);
		$this->db->delete('video_comment');

		$this->db->where('video_id',$video_id);
		$this->db->delete('video_like_detail');

		$this->db->where('video_id',$video_id);
		$this->db->delete('video_watch_later');

		$this->db->where('id',$video_id);
		$this->db->delete('videos');

		$this->session->set_flashdata('success', 'video removed successfully.');

		redirect('admin/video','refresh');
	}

	public function view($id)
	{
		$data['video'] = db_get_row_data('videos',array('id'=>$id));

		$this->load->view('admin/video/view',$data);
	}

	public function remove_video($id = '')
	{
		$file_name = db_get_row_data('videos',array('id'=>$id))->video;

		if(file_exists(FCPATH . 'upload_data/video/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/video/' . $file_name);

			$this->db->where('id',$id);
			if($this->db->update('videos',array('video'=>''))){
				$this->session->set_flashdata('success', 'video removed successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('admin/video/edit/' . $id);
	}
}