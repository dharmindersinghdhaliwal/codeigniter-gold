<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_history extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_history()
	{
		$query = $this->db->query('SELECT hst.*,
			vd.title,vd.description,
			vd.video,vd.video_thumbnail,vd.tags,vd.date_created,
			ctg.name,ctg.icon
			FROM history hst
			LEFT JOIN videos vd ON (vd.id = hst.video_id)
			LEFT JOIN category ctg ON (ctg.id = hst.category_id)
			WHERE hst.viewer_id="' . $this->session->userdata('id') . '"
			ORDER BY hst.datetime DESC');
		return $query->result();
	}
}