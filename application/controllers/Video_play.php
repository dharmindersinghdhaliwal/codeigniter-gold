<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_play extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$data['page_title'] = 'My Videos';
		$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');

		$data['video'] = db_get_row_data('videos',array('id'=>$this->input->get('vid')));
		if (count((array)$data['video']) == 0) {
			$this->session->set_flashdata('error', 'Video is no more longer');
			redirect('/index','refresh');
		}

		if(!$this->session->userdata('loggedin')) {
			$save_data = [
				'video_id'		=> $this->input->get('vid'),
				'channel_id'	=> $data['video']->channel_id,
				'category_id'	=> $data['video']->category_id,
				'ip'			=> $ip,
				'user_agent'	=> $_SERVER['HTTP_USER_AGENT'],
				'datetime'		=> date('Y-m-d H:i:s'),
			];

			$check_data = db_get_row_data('history',array('video_id'=>$this->input->get('vid'),'ip'=>$ip,'user_agent'=>$_SERVER['HTTP_USER_AGENT']));
		
			if(count((array)$check_data) == 0){
				$this->db->insert('history',$save_data);
			} else {
				$this->db->where('id',$check_data->id);
				$this->db->update('history',$save_data);
			}
		} else {
			$save_data = [
				'video_id'		=> $this->input->get('vid'),
				'viewer_id'		=> $this->session->userdata('id'),
				'channel_id'	=> $data['video']->channel_id,
				'category_id'	=> $data['video']->category_id,
				'ip'			=> $ip,
				'user_agent'	=> $_SERVER['HTTP_USER_AGENT'],
				'datetime'		=> date('Y-m-d H:i:s'),
			];

			$check_data = db_get_row_data('history',array('video_id'=>$this->input->get('vid'),'viewer_id'=>$this->session->userdata('id')));
			if(count($check_data) == 0){
				$this->db->insert('history',$save_data);
			} else {
				$this->db->where('id',$check_data->id);
				$this->db->update('history',$save_data);
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/video_play',$data);
		$this->load->view('front/footer',$data);
	}

	public function like($video_id = '')
	{
		header('Content-Type: application/json');
		$data = [];
		$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');

		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';

			echo json_encode($data);
			die();
		}

		$video = db_get_row_data('videos',array('id'=>$video_id));

		if (count($video) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Video is no more.</div>';

			echo json_encode($data);
			die();
		}

		$video_like_detail = db_get_row_data('video_like_detail',array('video_id'=>$video_id,'user_id'=>$this->session->userdata('id')));

		$save_data = [
			'video_id'		=> $video_id,
			'user_id'		=> $this->session->userdata('id'),
			'type'			=> $this->input->get('type'),
			'ip'			=> $ip,
			'user_agent'	=> $_SERVER['HTTP_USER_AGENT'],
			'datetime'		=> date('Y-m-d H:i:s')
		];

		if (count($video_like_detail) == 0) {

			$this->db->insert('video_like_detail',$save_data);
			$data['success'] = true;
			$data['type'] = $this->input->get('type');
			$data['video_like_count'] 		= db_get_count_data('video_like_detail',array('video_id'=>$video_id,'type'=>'like'));
			$data['video_dislike_count'] 	= db_get_count_data('video_like_detail',array('video_id'=>$video_id,'type'=>'dislike'));
			$data['message'] = '<div class="alert alert-info">Video ' . $this->input->get('type') . ' by you.</div>';

			$message = $this->session->userdata('full_name') . ' gave you like for your video ' . $video->title;
			make_notification($video->user_id,'user',$message);

		} else {

			$this->db->where('id',$video_like_detail->id);
			$this->db->update('video_like_detail',$save_data);
			$data['success'] = true;
			$data['type'] = $this->input->get('type');
			$data['video_like_count'] 		= db_get_count_data('video_like_detail',array('video_id'=>$video_id,'type'=>'like'));
			$data['video_dislike_count'] 	= db_get_count_data('video_like_detail',array('video_id'=>$video_id,'type'=>'dislike'));
			$data['message'] = '<div class="alert alert-info">Video ' . $this->input->get('type') . ' by you.</div>';

			$message = $this->session->userdata('full_name') . ' unlike for your video ' . $video->title;
			make_notification($video->user_id,'user',$message);

		}

		echo json_encode($data);
	}

	public function like_remove($video_id = '')
	{
		header('Content-Type: application/json');
		$data = [];

		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';

			echo json_encode($data);
			die();
		}

		$video = db_get_row_data('videos',array('id'=>$video_id));

		if (count($video) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Video is no more.</div>';

			echo json_encode($data);
			die();
		}

		$video_like_detail = db_get_row_data('video_like_detail',array('video_id'=>$video_id,'user_id'=>$this->session->userdata('id')));

		if (count($video_like_detail) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Video didn\'t liked or disliked by you.</div>';
		} else {
			$this->db->where('id',$video_like_detail->id);
			$this->db->delete('video_like_detail');
			$data['success'] = true;
			$data['video_like_count'] 		= db_get_count_data('video_like_detail',array('video_id'=>$video_id,'type'=>'like'));
			$data['video_dislike_count'] 	= db_get_count_data('video_like_detail',array('video_id'=>$video_id,'type'=>'dislike'));
		}

		echo json_encode($data);
	}

	public function watch_later()
	{
		header('Content-Type: application/json');
		$data = [];

		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';

			echo json_encode($data);
			die();
		}

		$video = db_get_row_data('videos',array('id'=>$this->input->get('video_id')));

		if (count($video) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Video is no more.</div>';

			echo json_encode($data);
			die();
		}

		$video_watch_later = db_get_row_data('video_watch_later',array('video_id'=>$this->input->get('video_id'),'user_id'=>$this->session->userdata('id')));

		if (count($video_watch_later) == 0) {
			$save_data = [
				'video_id' 	=> $this->input->get('video_id'),
				'user_id'	=> $this->session->userdata('id'),
				'datetime' 	=> date('Y-m-d H:i:s'),
			];
			$this->db->insert('video_watch_later',$save_data);
			$data['success'] = true;
			$data['type'] = 'save';
			$data['message'] = '<div class="alert alert-info">Video saved in watch later.</div>';
		} else {
			$this->db->where('id',$video_watch_later->id);
			$this->db->delete('video_watch_later');
			$data['success'] = true;
			$data['type'] = 'delete';
			$data['message'] = '<div class="alert alert-info">Video removed from watch later.</div>';
		}

		echo json_encode($data);
	}

	public function comment($video_id = '')
	{
		header('Content-Type: application/json');
		$data = [];

		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must login first !</div>';

			echo json_encode($data);
			die();
		}

		$video = db_get_row_data('videos',array('id'=>$video_id));

		if (count($video) == 0) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Video is no more.</div>';

			echo json_encode($data);
			die();
		}

		if ($this->input->post('comment') == '') {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">comment is not to be empty.</div>';

			echo json_encode($data);
			die();
		}

		$save_data = [
			'video_id'	=> $video_id,
			'user_id'	=> $this->session->userdata('id'),
			'comment'	=> $this->input->post('comment'),
			'datetime'	=> date('Y-m-d H:i:s')
		];

		if ($this->db->insert('video_comment',$save_data)){

			$video_comment_id = $this->db->insert_id();
			$data['success']  = true;
			$data['message']  = '<div class="alert alert-success">Video comment submitted by you.</div>';
			$data['html'] 	  = '<div class="single-video-author box mb-3">';
			$usr = db_get_row_data('users',array('id'=>$this->session->userdata('id')));

			$default_channel = db_get_row_data('channel',array('user_id'=>$this->session->userdata('id'),'is_default'=>1));

			//if($usr->profile_image != ''){
			if(isset($default_channel->logo) && $default_channel->logo!= ''){
				//if(file_exists(FCPATH . 'upload_data/user/' . $usr->profile_image)){
				if(file_exists(FCPATH . 'upload_data/channel/' . $default_channel->logo)){
					$data['html'] .= '<img class="img-fluid" src="'. BASE_URL .'upload_data/channel/' . $default_channel->logo . '" alt="' . $usr->full_name . '" />';
				} else {
					$data['html'] .= '<img class="img-fluid" src="' . BASE_ASSET . 'admin/images/user.png' . '" alt="' . $usr->full_name . '" />';
				}
			} else {
				$data['html'] .= '<img class="img-fluid" src="' . BASE_ASSET . 'admin/images/user.png' . '" alt="' . $usr->full_name . '" />';
			}
			$data['html'] .= '<strong>';
			$data['html'] .=  isset($default_channel->name) ? $default_channel->name:  $usr->full_name;
			$data['html'] .= '</strong>';
			$data['html'] .= '<small> ' . time_elapsed_string(date('Y-m-d H:i:s')) . '</small>';
			$data['html'] .= '<p>' . $this->input->post('comment') . '</p>';
			$data['html'] .= '<div class="pull-right"><a href="' . BASE_URL. 'video_play?vid='.$video_id.'&edit_video_comment='.$video_comment_id.'"><i class="fa fa-edit text-danger"></i></a> &nbsp;<a href="javascript:remove_comment(' . $video_comment_id . ');"><i class="fa fa-trash text-danger"></i></a></div>';
			
			$data['html'] .= '	<div class="like-dislike-panel">';
			$data['html'] .= '<p>&nbsp;</p>';
			$data['html'] .= '<a href="javascript:void(0);" data-comment="'.$video_comment_id.'" data-user="'.$this->session->userdata('id').'" 
													class="float-left h6 likeComment" style="width: 35px">';
			$data['html'] .= '<i class="fas fa-thumbs-up"></i>';
			$data['html'] .= '</a>';
			$data['html'] .= '<h5 class="h6 float-left" style="width: 35px" id="totalLikes">0</h5>';
			$data['html'] .= '<a href="javascript:void(0);" data-comment="'.$video_comment_id.'" data-user="'.$this->session->userdata('id').'" class="float-left h6 <?= $dislikeComment ?>" style="width: 35px">';
			$data['html'] .= '<i class="fas fa-thumbs-down"></i></a>';
			$data['html'] .= '<a href="javascript:void(0);" class="h6 float-left replyComment" comment-id="'.$video_comment_id.'"><small>REPLY</small></a>';
			$data['html'] .= '<p>&nbsp;</p>';
			$data['html'] .= '<div class="replyComment-panel" style="display: none" id="replyComment_'.$video_comment_id.'">';
			$data['html'] .= '<div class="replyComment-body">';

			$channel = db_get_row_data('channel',array('user_id'=>$this->session->userdata('id'),'is_default'=>1));
			
			if($channel->logo != ''){
				$data['html'] .= '<img class="img-fluid" src="'.BASE_URL .'upload_data/channel/'.$channel->logo.'" alt="'.$channel->name.'">';
			} else {
				$data['html'] .= '<img class="img-fluid" src="'.BASE_ASSET .'img/s1.png" alt="'.$channel->name.'">';
			}

			$data['html'] .= '<textarea name="replyComment-text" class="replyComment-text" placeholder="Add a public reply"></textarea>';
			$data['html'] .= '<div class="replyComment-btns pull-right">';
			$data['html'] .= '<a href="javascript:void(0)" class="btn btn-danger cancelReply">Cancel</a>';
			$data['html'] .= '<a href="javascript:void(0)" class="btn btn-primary">Reply</a>';
			$data['html'] .= '</div></div></div></div></div>';

		} else {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Unable to comment to video.</div>';
		}

		echo json_encode($data);
	}

	public function remove_comment($video_id = '', $video_comment_id = '')
	{
		if(!$this->session->userdata('loggedin')) {
			$this->session->set_flashdata('error', 'You must login first !');
			redirect('login','refresh');
		}

		$video = db_get_row_data('videos',array('id'=>$video_id));

		if (count($video) == 0) {
			$this->session->set_flashdata('error', 'Video is no more.');
			redirect('/dashboard','refresh');
		}

		if ($video_comment_id == '') {
			$this->session->set_flashdata('error', 'Not Allow to remove any comment.');
			redirect('/dashboard','refresh');
		}

		$video_comment = db_get_row_data('video_comment',array('id'=>$video_comment_id));
		if (count($video_comment) == '') {
			$this->session->set_flashdata('error', 'Video Comment not found.');
			redirect('/video_play?vid=' . $video_id,'refresh');
		}

		if ($video->user_id != $this->session->userdata('id')) {
			if ($video_comment->user_id != $this->session->userdata('id')) {
				$this->session->set_flashdata('error', 'You are not allow to remove video comment.');
				redirect('/video_play?vid=' . $video_id,'refresh');
			}
		}

		$this->db->where('id',$video_comment_id);
		if($this->db->delete('video_comment')){
			$this->session->set_flashdata('warning', 'Video comment removed.');
			redirect('/video_play?vid=' . $video_id,'refresh');
		}
	}

	public function update_comment($comment_id=''){
		if(!empty($comment_id)){

			header('Content-Type: application/json');
			$data = [];

			if(!$this->session->userdata('loggedin')) {
				$data['success'] = false;
				$data['message'] = '<div class="alert alert-danger">You must login first !</div>';
			}

			if ($this->input->post('comment') == '') {
				$data['success'] = false;
				$data['message'] = '<div class="alert alert-danger">comment is not to be empty.</div>';
			}

			$update_data = [
				'comment'	=> $this->input->post('comment'),
				'datetime'	=> date('Y-m-d H:i:s')
			];

			$this->db->where('id',$comment_id);
			if($this->db->update('video_comment',$update_data)){

				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success">Video comment updated successfully.</div>';

			}else {

				$data['success'] = false;
				$data['message'] = '<div class="alert alert-danger">Unable to Update comment to video.</div>';

			}
		}else{
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Comment id not found.</div>';
		}

		echo json_encode($data);

	}

	public function dislikeComment($comment_id=''){

		header('Content-Type: application/json');
		$data = [];
		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must need to login</div>';
		}
		elseif (empty($comment_id)) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Error..! Comment id not found.</div>';
		}
		else{

			$check_data = db_get_row_data('likes_and_dislikes',array('cmt_id'=>$comment_id,'user_id'=>$this->session->userdata('id')));
			if(count($check_data) == 0){
				$save_data = [
					'cmt_id'		=> $comment_id,
					'user_id'		=> $this->session->userdata('id'),
					'likes'			=> 0,
					'dislikes'		=> 1,
					'date_updated'	=> date('Y-m-d H:i:s'),
					'date_created'	=> date('Y-m-d H:i:s'),
				];
				if($this->db->insert('likes_and_dislikes',$save_data)){

					$likes = $this->get_comment_likes($comment_id);
					$likes = ($likes=='')|| ($likes==0) ? 0 : $likes-1;
					$this->update_comment_likes($comment_id,$likes);

					$data['success'] = true;
					$data['message'] = '<div class="alert alert-success">You Disliked </div>';
					$data['likes'] 	 = $this->get_comment_likes($comment_id);
				}else{
					$data['success'] = false;
					$data['message'] = '<div class="alert alert-danger">Error..! Please try again later.</div>';
				}
			}else{
				$save_data = [
					'cmt_id'		=> $comment_id,
					'user_id'		=> $this->session->userdata('id'),
					'likes'			=> 0,
					'dislikes'		=> 1,
					'date_updated'	=> date('Y-m-d H:i:s'),
				];

				$this->db->where('id',$check_data->id);
				$this->db->update('likes_and_dislikes',$save_data);

				$likes = $this->get_comment_likes($comment_id);
				$likes = ($likes=='')|| ($likes==0) ? 0 : $likes-1;
				$this->update_comment_likes($comment_id,$likes);

				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success">You Disliked </div>';
				$data['likes'] 	 = $this->get_comment_likes($comment_id);
			}
			
		}
		echo json_encode($data);
		die();

	}

	public function likeComment($comment_id=''){

		header('Content-Type: application/json');
		$data = [];
		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must need to login</div>';
		}
		elseif (empty($comment_id)) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Error..! Comment id not found.</div>';
		}
		else{
			
			$check_data = db_get_row_data('likes_and_dislikes',array('cmt_id'=>$comment_id,'user_id'=>$this->session->userdata('id')));
			if(count($check_data) == 0){
				$save_data = [
					'cmt_id'		=> $comment_id,
					'user_id'		=> $this->session->userdata('id'),
					'likes'			=> 1,
					'dislikes'		=> 0,
					'date_updated'	=> date('Y-m-d H:i:s'),
					'date_created'	=> date('Y-m-d H:i:s'),
				];
				if($this->db->insert('likes_and_dislikes',$save_data)){

					$likes = $this->get_comment_likes($comment_id);
					$likes = $likes+1;
					$this->update_comment_likes($comment_id,$likes);

					$data['success'] = true;
					$data['message'] = '<div class="alert alert-success">You liked </div>';
					$data['likes'] 	 = $this->get_comment_likes($comment_id);
				}else{
					$data['success'] = false;
					$data['message'] = '<div class="alert alert-danger">Error..! Please try again later.</div>';
				}

			}else{
				$save_data = [
					'cmt_id'		=> $comment_id,
					'user_id'		=> $this->session->userdata('id'),
					'likes'			=> 1,
					'dislikes'		=> 0,
					'date_updated'	=> date('Y-m-d H:i:s'),
				];

				$this->db->where('id',$check_data->id);
				$this->db->update('likes_and_dislikes',$save_data);

				$likes = $this->get_comment_likes($comment_id);
				$likes = $likes+1;
				$this->update_comment_likes($comment_id,$likes);

				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success">You Liked </div>';
				$data['likes'] 	 = $this->get_comment_likes($comment_id);
			}

		}
		echo json_encode($data);
		die();

	}

	public function get_comment_likes($comment_id=''){
		$row_data = db_get_row_data('video_comment',array('id'=>$comment_id));
		return $row_data->likes;
	}

	public function update_comment_likes($comment_id='',$likes=''){
		$save_data = ['likes'=> $likes];
		$this->db->where('id',$comment_id);
		$this->db->update('video_comment',$save_data);
	}

	public function reply_comment($comment_id=''){

		header('Content-Type: application/json');
		$data = [];
		if(!$this->session->userdata('loggedin')) {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must need to login</div>';
		}
		elseif ($comment_id == '') {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">Error..! Comment id not found</div>';
		}
		elseif ($this->input->post('reply_text') == '') {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">You must need to add some text into reply section.</div>';
		}
		else{
			$save_data = [
					'comment_id'	=> $comment_id,
					'user_id'		=> $this->session->userdata('id'),
					'reply_text'	=> $this->input->post('reply_text'),
					'date_updated'	=> date('Y-m-d H:i:s'),
					'date_created'	=> date('Y-m-d H:i:s'),
				];
			if($this->db->insert('reply_comment',$save_data)){
				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success">Success..!</div>';
			}else{
				$data['success'] = false;
				$data['message'] = '<div class="alert alert-error">Error..! Please try again laterr </div>';
			}
		}
		echo json_encode($data);
		die();

	}

	#Save advertisemnt impression
	public function save_advt_impression(){
		
		$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');

		$video_id 	= $this->input->post('video_id');
		$advt_id 	= $this->input->post('advt_id');
		$watch_time = ceil($this->input->post('advt_watchtime'));

		if((empty($video_id))||(empty($advt_id))){
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-error">Error..! Advertisement or video id is missing. unable to save advertisement impression</div>';
			echo json_encode($data);
			die();
		}

		$save_data = [
				'video_id'		=> $video_id,
				'advt_id'		=> $advt_id,
				'watch_time'	=> $watch_time,
				'ip'			=> $ip,
				'user_agent'	=> $_SERVER['HTTP_USER_AGENT'],
				'datetime'		=> date('Y-m-d H:i:s'),
			];

		//if not user logged in
		if(!$this->session->userdata('loggedin')) {

			$checkData = db_get_row_data('advt_impressions',array('advt_id'=>$advt_id,'video_id'=>$video_id,'ip'=>$ip,'user_agent'=>$_SERVER['HTTP_USER_AGENT']));
			$save_data['viewer_id'] = 0;
			if(count((array)$checkData) == 0){
				$this->db->insert('advt_impressions',$save_data);
				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success"> Advertisement impression successfully saved</div>';
			} else {
				$this->db->where('id',$checkData->id);
				$this->db->update('advt_impressions',$save_data);
				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success"> Advertisement impression successfully updated</div>';
			}
		} else {
			
			$checkData = db_get_row_data('advt_impressions',array('advt_id'=>$advt_id,'video_id'=>$video_id,'viewer_id'=>$this->session->userdata('id')));
			$save_data['viewer_id'] = $this->session->userdata('id');

			if(count($checkData) == 0){
				$this->db->insert('advt_impressions',$save_data);
				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success"> Advertisement impression successfully saved</div>';
			} else {
				$this->db->where('id',$checkData->id);
				$this->db->update('advt_impressions',$save_data);
				$data['success'] = true;
				$data['message'] = '<div class="alert alert-success"> Advertisement impression successfully updated</div>';
			}

		}
		echo json_encode($data);
		die();
	}
}