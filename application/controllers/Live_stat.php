<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_stat extends CI_Controller
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
		$data['page_title'] = 'Live stat';

		$data['user'] = db_get_row_data('users',array('id'=>$this->session->userdata('id')));
		$data['posts'] = db_get_all_data('post',array('user_id' => $this->session->userdata('id')),false,'date_created DESC');
		$data['channels'] = db_get_all_data('channel',array('user_id'=>$this->session->userdata('id')));

		$data['subscribers'] = 0;
		foreach ($data['channels'] as $channel) {
			$data['subscribers'] += db_get_count_data('subscribe',array('channel_id'=>$channel->id));
		}


		$this->load->view('front/header',$data);
		$this->load->view('front/live_stat',$data);
		$this->load->view('front/footer',$data);
	}

	public function graph_data($year = '2019')
	{
		header('Content-Type: application/json');

		$data['followers_data'] = [];
		for ($i=1; $i <= 12; $i++) { 
			$current_year_all_followers = $this->db->query('SELECT COUNT(id) AS total_followers
				FROM user_follow
				WHERE follow_id=' . $this->session->userdata('id') . '
				AND YEAR(datetime)=' . $year . ' AND MONTH(datetime)=' . $i . '
				GROUP BY YEAR(datetime), MONTH(datetime)')
			->row();
			$data['followers_data'][] = floatval((count((array)$current_year_all_followers) == 0)? 0 : $current_year_all_followers->total_followers);
		}

		$data['subscribers_data'] = [];
		for ($i=1; $i <= 12; $i++) { 
			$current_year_all_subscribers = $this->db->query('SELECT COUNT(sb.id) AS total_subscribes
				FROM subscribe sb
				LEFT JOIN channel ch ON (ch.id = sb.channel_id)
				WHERE ch.user_id=' . $this->session->userdata('id') . '
				AND YEAR(sb.date_created)=' . $year . ' AND MONTH(sb.date_created)=' . $i . '
				GROUP BY YEAR(sb.date_created), MONTH(sb.date_created)')
			->row();
			$data['subscribers_data'][] = floatval((count((array)$current_year_all_subscribers) == 0)? 0 : $current_year_all_subscribers->total_subscribes);
		}

		echo json_encode($data);
	}
}