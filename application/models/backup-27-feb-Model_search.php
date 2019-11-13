<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_search extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_result($string = '')
	{
		$query = $this->db->query('SELECT *
			FROM post
			WHERE content LIKE "%' . $string . '%"
			ORDER BY date_created DESC');
		return $query->result();
	}
	/*public function get_result($string = '')
	{
		$query = $this->db->query('SELECT vd.*,
			ctg.name,ctg.icon
			FROM videos vd
			LEFT JOIN category ctg ON (ctg.id = vd.category_id)
			WHERE vd.title LIKE "%' . $string . '%"
			ORDER BY vd.date_created DESC');
		return $query->result();
	}*/
}