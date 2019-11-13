<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_video extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function remove($video_id)
	{
		$video = db_get_row_data('videos',array('id'=>$video_id));

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

		return $video_id;
	}
}