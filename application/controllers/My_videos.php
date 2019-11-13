<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_videos extends CI_Controller
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

		$data['page_title'] = 'My Videos';

		$data['videos'] = db_get_all_data('videos',array('user_id'=>$this->session->userdata('id')));

		$this->load->view('front/header',$data);
		$this->load->view('front/my_videos',$data);
		$this->load->view('front/footer',$data);
	}

	public function edit($video_id = '')
	{

		$data['page_title'] = 'Update Video';

		$data['video'] = db_get_row_data('videos',array('id'=>$video_id,'user_id'=>$this->session->userdata('id')));

		if(count($data['video']) == 0) {
			$this->session->set_flashdata('error', 'Video not found !');
			redirect('my_videos','refresh');
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/edit_video',$data);
		$this->load->view('front/footer',$data);
	}

	public function remove_video($video_id = '')
	{
		$file_name = db_get_row_data('videos',array('id'=>$video_id))->video;

		if(file_exists(FCPATH . 'upload_data/video/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/video/' . $file_name);

			$this->db->where('id',$video_id);
			if($this->db->update('videos',array('video'=>''))){
				$this->session->set_flashdata('success', 'video file removed successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('my_videos/edit/' . $video_id);
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

		redirect('/my_videos','refresh');
	}

	public function remove_video_thumbnail($video_id = '')
	{
		$file_name = db_get_row_data('videos',array('id'=>$video_id))->video_thumbnail;

		if(file_exists(FCPATH . 'upload_data/video/thumbnail/' . $file_name) && $file_name != '') {
			unlink(FCPATH . 'upload_data/video/thumbnail/' . $file_name);

			$this->db->where('id',$video_id);
			if($this->db->update('videos',array('video_thumbnail'=>''))){
				$this->session->set_flashdata('success', 'video thumbnail image removed successfully.');
			}
		} else {
			$this->session->set_flashdata('error', 'File Not Found.');
		}

		redirect('my_videos/edit/' . $video_id);
	}
}