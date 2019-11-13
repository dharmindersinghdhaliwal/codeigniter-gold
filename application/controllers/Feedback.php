<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller
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
		$data['page_title'] = 'Feedback';

		$this->form_validation->set_rules('feedback', 'Feedback', 'trim|required');

		$save_data = array(
			'user_id' => $this->session->userdata('id'),
			'feedback' => $this->input->post('feedback'),
			'datetime' => date('Y-m-d H:i:s')
		);

		if ($this->form_validation->run()) {
			$user = db_get_row_data('users',array('id'=>$this->session->userdata('id')));
			$email_template_user_feedback = get_option('email_template_user_feedback');
			$email_template_user_feedback = str_replace("__USERNAME__", $user->full_name, $email_template_user_feedback);
			$email_template_user_feedback = str_replace("__BASE_URL__", BASE_URL, $email_template_user_feedback);
			$email_template_user_feedback = str_replace("__USER_MESSAGE__", $this->input->post('feedback'), $email_template_user_feedback);

			require FCPATH . 'application/controllers/PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;
			$mail->setFrom($user->email, $user->full_name);
			$mail->isSMTP();
			$mail->Host = get_option('smtp_host');
			$mail->Port = get_option('smtp_port');
			$mail->SMTPAuth = true;
			$mail->Username = get_option('smtp_username');
			$mail->Password = get_option('smtp_password');
			$mail->IsHTML(true);
			$mail->addAddress(get_option('email'));
			$mail->Subject = 'GoldTubeTV : ' . $user->full_name . ' gives feedback';
			$mail->Body = $email_template_user_feedback;
			$mail->AltBody = $email_template_user_feedback;
			if($mail->send()){
				$this->session->set_flashdata('success', 'Thanks for your feedback.');
				$this->db->insert('user_feedback_message',$save_data);
			} else {
				$this->session->set_flashdata('error', 'Unable to send email ' . $mail->ErrorInfo);
			}

			redirect('/feedback','refresh');
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/feedback',$data);
		$this->load->view('front/footer',$data);
	}
}