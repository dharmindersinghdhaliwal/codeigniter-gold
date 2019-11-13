<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
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
		$data['page_title'] = 'My Profile';
		$data['user'] = db_get_row_data('users',array('id'=>$this->session->userdata('id')));
		$data['posts'] = db_get_all_data('post',array('user_id' => $this->session->userdata('id')),false,'date_created DESC');

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

		if ($this->form_validation->run()) {
			$save_data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'date_updated' => date('Y-m-d H:i:s')
			];

			$target_dir = FCPATH . "upload_data/user/";
			if(isset($_POST["profile_image"])) {
				if($_POST["profile_image"] != ''){
					if($data['user']->profile_image != ''){
						unlink(FCPATH . "upload_data/user/" . $data['user']->profile_image);
					}

					$file_name = $save_data['email'] . '-' . time() . '.png';
					$img = $_POST['profile_image'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$imgData = base64_decode($img);
					if(file_put_contents($target_dir . $file_name, $imgData)){
						$save_data['profile_image'] = $file_name;
					}
				}
			}

			$this->db->where('id',$this->session->userdata('id'));
			if($this->db->update('users',$save_data)){
				$this->session->set_flashdata('success', 'Your profile has been successfully updated.');
				redirect('/profile');
			}
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/profile',$data);
		$this->load->view('front/footer',$data);
	}
}