<?php
if(!function_exists('db_get_all_data')) {
	function db_get_all_data($table_name = null, $where = false, $select = false, $order_by = false, $limit = false) {
		$ci =& get_instance();
		if ($where) {
			$ci->db->where($where);
		}
		if ($select) {
			$ci->db->select($select);
		}
		if ($order_by) {
			$ci->db->order_by($order_by);
		}
		if ($limit) {
			$ci->db->limit($limit);
		}
		$query = $ci->db->get($table_name);

		return $query->result();
	}
}

if(!function_exists('db_get_row_data')) {
	function db_get_row_data($table_name = null, $where = false, $select = false, $order_by = false) {
		$ci =& get_instance();
		if ($where) {
			$ci->db->where($where);
		}
		if ($select) {
			$ci->db->select($select);
		}
		if ($order_by) {
			$ci->db->order_by($order_by);
		}
		$query = $ci->db->get($table_name);

		return $query->row();
	}
}

if(!function_exists('db_get_count_data')) {
	function db_get_count_data($table_name = null, $where = false) {
		$ci =& get_instance();
		if ($where) {
			$ci->db->where($where);
		}
		$query = $ci->db->get($table_name);

		return $query->num_rows();
	}
}

if(!function_exists('get_state_name')) {
	function get_state_name($state_id) {
		$ci =& get_instance();
		$ci->db->where('id',$state_id);
		
		$query = $ci->db->get('states')->row();

		return $query->name;
	}
}

if(!function_exists('get_country_name')) {
	function get_country_name($country_id) {
		$ci =& get_instance();
		
		$ci->db->where('id',$country_id);
		
		$query = $ci->db->get('countries')->row();

		return $query->name;
	}
}

if(!function_exists('make_notification')) {
	function make_notification($user_id,$user_type,$message) {
		$ci =& get_instance();
		
		$save_data = [
			'user_id' => $user_id,
			'user_type' => $user_type,
			'message' => $message,
			'datetime' => date('Y-m-d H:i:s'),
			'status' => 0
		];

		$ci->db->insert('notification',$save_data);

		return $ci->db->insert_id();
	}
}

if (!function_exists('ip_info'))
{
	function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
					$output = array(
						"city"           => @$ipdat->geoplugin_city,
						"state"          => @$ipdat->geoplugin_regionName,
						"country"        => @$ipdat->geoplugin_countryName,
						"country_code"   => @$ipdat->geoplugin_countryCode,
						"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
						"continent_code" => @$ipdat->geoplugin_continentCode
					);
					break;
					case "address":
					$address = array($ipdat->geoplugin_countryName);
					if (@strlen($ipdat->geoplugin_regionName) >= 1)
						$address[] = $ipdat->geoplugin_regionName;
					if (@strlen($ipdat->geoplugin_city) >= 1)
						$address[] = $ipdat->geoplugin_city;
					$output = implode(", ", array_reverse($address));
					break;
					case "city":
					$output = @$ipdat->geoplugin_city;
					break;
					case "state":
					$output = @$ipdat->geoplugin_regionName;
					break;
					case "region":
					$output = @$ipdat->geoplugin_regionName;
					break;
					case "country":
					$output = @$ipdat->geoplugin_countryName;
					break;
					case "countrycode":
					$output = @$ipdat->geoplugin_countryCode;
					break;
				}
			}
		}
		return $output;
	}
}

if(!function_exists('convertCurrency')) {
	function convertCurrency($amount, $from, $to){
		$conv_id = "{$from}_{$to}";
		$string = file_get_contents("http://free.currencyconverterapi.com/api/v3/convert?q=$conv_id&compact=ultra");
		$json_a = json_decode($string, true);

		return $amount * round($json_a[$conv_id], 4);
	}
}

if(!function_exists('get_option')) {
	function get_option($option_name = null, $default = null) {
		$ci =& get_instance();
		$result = $ci->db->get_where('settings', ['option_name' => $option_name]);

		if ($row = $result->row()) {
			return $row->option_value;
		} else {
			return $default;
		}
	}
}

if(!function_exists('set_option')) {
	function set_option($option_name = null, $option_value = null) {
		$ci =& get_instance();
		$result = $ci->db->get_where('settings', [ 'option_name' => $option_name]);

		if ($row = $result->row()) {
			$ci->db->where('option_name',$option_name);
			$ci->db->update('settings', array('option_value' => $option_value));
		} else {
			$ci->db->insert('settings', array('option_name' => $option_name,'option_value' => $option_value));
		}

		return $option_value;
	}
}

if(!function_exists('get_time_difference_interval')) {
	function get_time_difference_interval($total_time) {

		if( $hours=intval((floor($total_time/3600)))){
			$total_time = $total_time % 3600;
		}
		if( $minutes=intval((floor($total_time/60)))){
			$total_time = $total_time % 60;
		}
		$total_time = intval($total_time);

		return $hours . ' hrs - ' . $minutes . ' min - ' . $total_time . ' sec';
	}
}

if(!function_exists('time_elapsed_string')) {
	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}