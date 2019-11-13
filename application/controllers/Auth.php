<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		if($this->session->userdata('loggedin')) {
			redirect('dashboard','refresh');
		}

		$data['page_title'] = 'Login';

		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		$data['email'] = $this->input->post('email');

		if ($this->form_validation->run()) {
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));
			$rememberme = $this->input->post('rememberme');
			$user = db_get_row_data('users', array('email'=>$email));

			if(count((array)$user) > 0){
				if($user->password == $password){
					if($user->type == 'user') {
						$admin_users = db_get_all_data('users',array('type'=>'admin'));
						foreach ($admin_users as $admin) {
							$channels = db_get_all_data('channel',array('user_id'=>$admin->id));
							foreach ($channels as $channel) {
								$subscribe = db_get_row_data('subscribe',array('channel_id'=>$channel->id,'user_id'=>$user->id));
								if (count($subscribe) == 0) {
									$save_data = [
										'channel_id'	=> $channel->id,
										'user_id'		=> $user->id,
										'date_created'	=> date('Y-m-d H:i:s')
									];
									$this->db->insert('subscribe',$save_data);
								}
							}
						}
					}

					if($rememberme == 1){
						$cookie = array(
							'name'	 => 'student',
							'value'	 => $usr->id . "-" . session_id(),
							'expire' => 60*60*24*7,
							'path'	 => '/',
						);
						$this->input->set_cookie($cookie);
					}
					$this->session->set_flashdata('success', 'Login Successfully.');

					if($user->type == 'admin') {
						$data = array(
							'id' => $user->id,
							'email' => $user->email,
							'full_name' => $user->full_name,
							'type' => $user->type,
							'admin_loggedin' => TRUE
						);
						$this->session->set_userdata($data);
						redirect('admin/dashboard','refresh');
					} else {
						$data = array(
							'id' => $user->id,
							'email' => $user->email,
							'full_name' => $user->full_name,
							'type' => $user->type,
							'loggedin' => TRUE
						);
						$this->session->set_userdata($data);
						redirect('/dashboard','refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Incorrect Password.');
				}
			} else {
				$this->session->set_flashdata('error', 'User Not Found.');
			}
		}

		$this->load->view('front/login',$data);
	}

	public function forgot_password()
	{
		if ($this->session->userdata('loggedin')) {
			redirect('dashboard','refresh');
		}

		$data['page_title'] = 'Forgot Password';

		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		$data['email'] = $this->input->post('email');

		if ($this->form_validation->run()) {

			$user = db_get_row_data('users',array('email'=>$this->input->post('email')));
			if(count((array)$user) != 0){
				$email_template_user_forgot_password = get_option('email_template_user_forgot_password');
				$email_template_user_forgot_password = str_replace("__USERNAME__", $user->full_name, $email_template_user_forgot_password);
				$email_template_user_forgot_password = str_replace("__BASE_URL__", BASE_URL, $email_template_user_forgot_password);
				$email_template_user_forgot_password = str_replace("__RESET_PASSWORD_URL__", BASE_URL . 'change_password?usr=' . base64_encode($this->input->post('email')), $email_template_user_forgot_password);

				require FCPATH . 'application/controllers/PHPMailer/PHPMailerAutoload.php';

				$mail = new PHPMailer;
				$mail->setFrom(get_option('email'), 'GoldTubeTV');
				$mail->isSMTP();
				$mail->Host = get_option('smtp_host');
				$mail->Port = get_option('smtp_port');
				$mail->SMTPAuth = true;
				$mail->Username = get_option('smtp_username');
				$mail->Password = get_option('smtp_password');
				$mail->IsHTML(true);
				$mail->addAddress($this->input->post('email'));
				$mail->Subject = 'GoldTubeTV : Reset Password';
				$mail->Body = $email_template_user_forgot_password;
				$mail->AltBody = $email_template_user_forgot_password;
				if($mail->send()){
					$this->session->set_flashdata('success', 'You will recievice an email to reset your password.');
				} else {
					$this->session->set_flashdata('error', 'Unable to send email ' . $mail->ErrorInfo);
				}

				redirect('login','refresh');
			} else {
				$this->session->set_flashdata('error', 'Invalid institute account. try again !');
			}
		}

		$this->load->view('front/forgot_password',$data);
	}

	public function change_password()
	{
		if ($this->session->userdata('institute_loggedin')) {
			redirect('dashboard','refresh');
		}

		if($this->input->get('usr') == ''){
			$this->session->set_flashdata('error', 'Invalid Access Url');
			redirect('login','refresh');
			die();
		}

		$data = [];
		$data['page_title'] = 'Reset Password';


		$data['email'] = base64_decode($this->input->get('usr'));
		$userData = db_get_row_data('users',array('email'=>$data['email']));

		if(count((array)$userData) == 0){
			$this->session->set_flashdata('error', 'Sorry User not exist.');
			redirect('login','refresh');
			die();
		}

		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm', 'Confirm Password', 'trim|required|matches[password]');

		if ($this->form_validation->run()) {

			$this->db->where('id',$userData->id);
			$this->db->update('users',array('password'=> md5($this->input->post('password'))));

			$this->session->set_flashdata('success', 'Your password is reset sucessfully.');
			redirect('login');
		}

		$this->load->view('front/change_password',$data);
	}

	public function register()
	{
		if($this->session->userdata('loggedin')) {
			redirect('dashboard','refresh');
		}

		$data['page_title'] = 'Register';

		$this->form_validation->set_rules('full_name', 'Full Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

		$this->form_validation->set_message('is_unique', 'User already exists');

		$save_data = array(
			'full_name' => $this->input->post('full_name'),
			'email' => $this->input->post('email'),
			'password' => md5($this->input->post('password')),
			'type' => 'user',
			'date_created' => date('Y-m-d H:i:s'),
			'status' => 0
		);

		if ($this->form_validation->run()) {
			if($this->db->insert('users',$save_data))
			{
				$user_id = $this->db->insert_id();
				$admin_users = db_get_all_data('users',array('type'=>'admin'));
				foreach ($admin_users as $admin) {
					$channels = db_get_all_data('channel',array('user_id'=>$admin->id));
					foreach ($channels as $channel) {
						$subscribe = db_get_row_data('subscribe',array('channel_id'=>$channel->id,'user_id'=>$user_id));
						if (count($subscribe) == 0) {
							$save_data = [
								'channel_id'	=> $channel->id,
								'user_id'		=> $user_id,
								'date_created'	=> date('Y-m-d H:i:s')
							];
							$this->db->insert('subscribe',$save_data);
						}
					}
				}

				$email_template_user_register = get_option('email_template_user_register');
				$email_template_user_register = str_replace("__USERNAME__", $this->input->post('full_name'), $email_template_user_register);
				$email_template_user_register = str_replace("__BASE_URL__", BASE_URL, $email_template_user_register);
				$email_template_user_register = str_replace("__VERIFY_ACCOUNT_URL__", BASE_URL . 'verify?u=' . base64_encode($this->input->post('email')), $email_template_user_register);

				require FCPATH . 'application/controllers/PHPMailer/PHPMailerAutoload.php';

				$mail = new PHPMailer;
				$mail->setFrom(get_option('email'), 'GoldTubeTV');
				$mail->isSMTP();
				$mail->Host = get_option('smtp_host');
				$mail->Port = get_option('smtp_port');
				$mail->SMTPAuth = true;
				$mail->Username = get_option('smtp_username');
				$mail->Password = get_option('smtp_password');
				$mail->SMTPSecure = 'tls';
				$mail->IsHTML(true);
				$mail->addAddress($save_data['email']);
				$mail->Subject = 'GoldTubeTV : Register Verify';
				$mail->Body = $email_template_user_register;
				$mail->AltBody = $email_template_user_register;
				if($mail->send()){
					$this->session->set_flashdata('success', 'Your account sucessfully created You will recievice an email to verifying your account.');
				} else {
					$this->session->set_flashdata('error', 'Unable to send email ' . $mail->ErrorInfo);
				}

				redirect('/login','refresh');
			} else {
				$this->session->set_flashdata('error', 'Unable to create user. try again !');
			}
		}

		$this->load->view('front/register',$data);
	}

	public function verify()
	{
		if ($this->session->userdata('loggedin')) {
			redirect('dashboard','refresh');
		}

		if($this->input->get('u') == ''){
			$this->session->set_flashdata('error', 'Invalid Access Url');
			redirect('/login','refresh');
			die();
		}

		$email = base64_decode($this->input->get('u'));

		if($userData = db_get_row_data('users',array('email'=>$email))){
			if($userData->status == 0){
				$this->db->where('id',$userData->id);
				$this->db->update('users',array('status'=>1));


				$email_template_user_welcome = get_option('email_template_user_welcome');
				$email_template_user_welcome = str_replace("__USERNAME__", $this->input->post('full_name'), $email_template_user_welcome);
				$email_template_user_welcome = str_replace("__BASE_URL__", BASE_URL, $email_template_user_welcome);

				require FCPATH . 'application/controllers/PHPMailer/PHPMailerAutoload.php';

				$mail = new PHPMailer;
				$mail->setFrom(get_option('email'), 'GoldTubeTV');
				$mail->isSMTP();
				$mail->Host = get_option('smtp_host');
				$mail->Port = get_option('smtp_port');
				$mail->SMTPAuth = true;
				$mail->Username = get_option('smtp_username');
				$mail->Password = get_option('smtp_password');
				$mail->SMTPSecure = 'tls';
				$mail->IsHTML(true);
				$mail->addAddress($save_data['email']);
				$mail->Subject = 'GoldTubeTV : Welcome you';
				$mail->Body = $email_template_user_welcome;
				$mail->AltBody = $email_template_user_welcome;
				$mail->send();

				$this->session->set_flashdata('success', 'Your account sucessfully verified.');
			} else {
				$this->session->set_flashdata('warning', 'Your account is already verified.');
			}
		} else {
			$this->session->set_flashdata('error', 'Invalid User Access');
		}

		redirect('/login','refresh');
	}

	public function social_login()
	{
		header('Content-Type: application/json');
		$data = [];

		$userData = json_decode($this->input->post('userData'),true);

		if ($this->input->post('oauth_provider') == 'google') {
			if(!empty($userData)){

				if($userData['emails'][0]['value'] != '') {
					$save_data = array(
						'oauth_provider'	=> $this->input->post('oauth_provider'),
						'oauth_uid'			=> (!empty($userData['id'])?$userData['id']:''),
						'first_name'		=> (!empty($userData['name']['givenName'])?$userData['name']['givenName']:''),
						'last_name'			=> (!empty($userData['name']['familyName'])?$userData['name']['familyName']:''),
						'full_name'			=> ($userData['name']['givenName'] . ' ' . $userData['name']['familyName']),
						'email'				=> (!empty($userData['emails'][0]['value'])?$userData['emails'][0]['value']:''),
						'gender'			=> (!empty($userData['gender'])?$userData['gender']:''),
						'type'				=> 'user',
						'profile_image'		=> (!empty($userData['image']['url'])?$userData['image']['url']:''),
						'link'				=> (!empty($userData['url'])?$userData['url']:''),
						'date_created'		=> date('Y-m-d H:i:s'),
						'status'			=> 1
					);

					$check_user = db_get_row_data('users',array('email'=>$save_data['email']));
					if(count($check_user) == 0){
						$this->db->insert('users',$save_data);
						$user_id = $this->db->insert_id();
					} else {
						$user_id = $check_user->id;
					}

					$admin_users = db_get_all_data('users',array('type'=>'admin'));
					foreach ($admin_users as $admin) {
						$channels = db_get_all_data('channel',array('user_id'=>$admin->id));
						foreach ($channels as $channel) {
							$subscribe = db_get_row_data('subscribe',array('channel_id'=>$channel->id,'user_id'=>$user_id));
							if (count($subscribe) == 0) {
								$save_data = [
									'channel_id'	=> $channel->id,
									'user_id'		=> $user_id,
									'date_created'	=> date('Y-m-d H:i:s')
								];
								$this->db->insert('subscribe',$save_data);
							}
						}
					}

					$user = db_get_row_data('users', array('id'=>$user_id));

					$data = array(
						'id' => $user->id,
						'email' => $user->email,
						'full_name' => $user->full_name,
						'type' => $user->type,
						'loggedin' => TRUE
					);
					$this->session->set_userdata($data);
					$this->session->set_flashdata('success', 'Login Successfully.');
				} else {
					$data['loggedin'] = FALSE;
					$data['message'] = '<div class="alert alert-danger">Unable to create user because we don\'t get any email information.</div>';
				}
			} else {
				$data['loggedin'] = FALSE;
				$data['message'] = '<div class="alert alert-danger">Unable to login user try after some time.</div>';
			}
		} elseif ($this->input->post('oauth_provider') == 'facebook') {
			if(!empty($userData)){

				if($userData['email'] != '') {
					$save_data = array(
						'oauth_provider'	=> $this->input->post('oauth_provider'),
						'oauth_uid'			=> (!empty($userData['id'])?$userData['id']:''),
						'first_name'		=> (!empty($userData['first_name'])?$userData['first_name']:''),
						'last_name'			=> (!empty($userData['last_name'])?$userData['last_name']:''),
						'full_name'			=> ($userData['first_name'] . ' ' . $userData['last_name']),
						'email'				=> (!empty($userData['email'])?$userData['email']:''),
						'gender'			=> (!empty($userData['gender'])?$userData['gender']:''),
						'type'				=> 'user',
						'profile_image'		=> (!empty($userData['picture']['data']['url'])?$userData['picture']['data']['url']:''),
						'link'				=> (!empty($userData['url'])?$userData['url']:''),
						'date_created'		=> date('Y-m-d H:i:s'),
						'status'			=> 1
					);

					$check_user = db_get_row_data('users',array('email'=>$save_data['email']));
					if(count($check_user) == 0){
						$this->db->insert('users',$save_data);
						$user_id = $this->db->insert_id();
					} else {
						$user_id = $check_user->id;
					}

					$admin_users = db_get_all_data('users',array('type'=>'admin'));
					foreach ($admin_users as $admin) {
						$channels = db_get_all_data('channel',array('user_id'=>$admin->id));
						foreach ($channels as $channel) {
							$subscribe = db_get_row_data('subscribe',array('channel_id'=>$channel->id,'user_id'=>$user_id));
							if (count($subscribe) == 0) {
								$save_data = [
									'channel_id'	=> $channel->id,
									'user_id'		=> $user_id,
									'date_created'	=> date('Y-m-d H:i:s')
								];
								$this->db->insert('subscribe',$save_data);
							}
						}
					}

					$user = db_get_row_data('users', array('id'=>$user_id));

					$data = array(
						'id' => $user->id,
						'email' => $user->email,
						'full_name' => $user->full_name,
						'type' => $user->type,
						'loggedin' => TRUE
					);
					$this->session->set_userdata($data);
					$this->session->set_flashdata('success', 'Login Successfully.');
				} else {
					$data['loggedin'] = FALSE;
					$data['message'] = '<div class="alert alert-danger">Unable to create user because we don\'t get any email information.</div>';
				}
			} else {
				$data['loggedin'] = FALSE;
				$data['message'] = '<div class="alert alert-danger">Unable to login user try after some time.</div>';
			}
		}

		echo json_encode($data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login','refresh');
	}
}