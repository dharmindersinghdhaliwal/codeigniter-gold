<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_title'] = 'Help';

		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');

		$save_data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'message' => $this->input->post('message'),
			'datetime' => date('Y-m-d H:i:s')
		);

		if ($this->form_validation->run()) {
			$email_template_user_help = get_option('email_template_user_help');
			$email_template_user_help = str_replace("__USERNAME__", $this->input->post('name'), $email_template_user_help);
			$email_template_user_help = str_replace("__BASE_URL__", BASE_URL, $email_template_user_help);
			$email_template_user_help = str_replace("__USER_MESSAGE__", $this->input->post('message'), $email_template_user_help);

			require FCPATH . 'application/controllers/PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;
			$mail->setFrom($this->input->post('email'), $this->input->post('name'));
			$mail->isSMTP();
			$mail->Host = get_option('smtp_host');
			$mail->Port = get_option('smtp_port');
			$mail->SMTPAuth = true;
			$mail->Username = get_option('smtp_username');
			$mail->Password = get_option('smtp_password');
			$mail->IsHTML(true);
			$mail->addAddress(get_option('email'));
			$mail->Subject = 'GoldTubeTV : ' . $this->input->post('name') . ' need help';
			$mail->Body = $email_template_user_help;
			$mail->AltBody = $email_template_user_help;
			if($mail->send()){
				$this->session->set_flashdata('success', 'Your message sent successfully.');
				$this->db->insert('user_help_message',$save_data);
			} else {
				$this->session->set_flashdata('error', 'Unable to send email ' . $mail->ErrorInfo);
			}

			redirect('/help','refresh');
		}

		$this->load->view('front/header',$data);
		$this->load->view('front/help',$data);
		$this->load->view('front/footer',$data);
	}
}