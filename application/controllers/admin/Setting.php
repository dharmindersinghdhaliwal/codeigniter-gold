<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata('admin_loggedin')){
			redirect('admin/login');
		}
	}

	public function index()
	{

		$data['page_title'] = 'Admin Settings';

		$this->load->view('admin/header',$data);
		$this->load->view('admin/setting',$data);
		$this->load->view('admin/footer',$data);
	}

	public function save()
	{
		header('Content-Type: application/json');
		$data = [];

		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		if ($this->form_validation->run()) {
			if(isset($_FILES["site_logo"]["name"])) {
				$target_dir = FCPATH . "asset/";
				if($_FILES["site_logo"]["name"] != ''){
					$fileType = strtolower(pathinfo($_FILES["site_logo"]["name"],PATHINFO_EXTENSION));
					if($fileType == 'JPG' || $fileType == 'JPEG' || $fileType == 'PNG' || $fileType == 'GIF' || $fileType == 'BMP' || $fileType == 'jpg' || $fileType == 'jpeg' || $fileType == 'png' || $fileType == 'gif' || $fileType == 'bmp'){
						$file_name = "site_logo_" . $_SERVER['SERVER_NAME'] . "_" . time() . "." . $fileType;
						$target_file = $target_dir . $file_name;
						if(file_exists(FCPATH . 'asset/' . get_option('site_logo')) && get_option('site_logo') != '') {
							unlink(FCPATH . 'asset/' . get_option('site_logo'));
						}
						if(move_uploaded_file($_FILES["site_logo"]["tmp_name"], $target_file)) {
							set_option('site_logo', $file_name);
						}
					}
				}
			}

			set_option('site_name', $this->input->post('site_name'));
			set_option('site_description', $this->input->post('site_description'));
			set_option('keywords', $this->input->post('keywords'));
			set_option('author', $this->input->post('author'));
			set_option('email', $this->input->post('email'));
			set_option('cc_email', $this->input->post('cc_email'));
			set_option('bcc_email', $this->input->post('bcc_email'));
			set_option('email_template_user_register', $this->input->post('email_template_user_register'));
			set_option('email_template_user_forgot_password', $this->input->post('email_template_user_forgot_password'));
			set_option('email_template_user_welcome', $this->input->post('email_template_user_welcome'));
			set_option('ads_header', $this->input->post('ads_header'));
			set_option('ads_sidebar', $this->input->post('ads_sidebar'));
			set_option('ads_footer', $this->input->post('ads_footer'));
			set_option('smtp_host', $this->input->post('smtp_host'));
			set_option('smtp_port', $this->input->post('smtp_port'));
			set_option('smtp_username', $this->input->post('smtp_username'));
			set_option('smtp_password', $this->input->post('smtp_password'));
			set_option('google_api_key', $this->input->post('google_api_key'));
			set_option('google_client_id', $this->input->post('google_client_id'));
			set_option('facebook_app_id', $this->input->post('facebook_app_id'));
			set_option('facebook_app_secret', $this->input->post('facebook_app_secret'));
			set_option('paypal_business', $this->input->post('paypal_business'));
			set_option('paypal_sandbox', $this->input->post('paypal_sandbox'));
			set_option('paypal_lib_currency_code', $this->input->post('paypal_lib_currency_code'));

			$data['success'] = true;
			$data['message'] = '<div class="alert alert-success">Your setting has been successfully updated.</div>';
		} else {
			$data['success'] = false;
			$data['message'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($data);
	}

	public function remove_logo()
	{
		if(get_option('site_logo') != ''){
			if(file_exists(FCPATH . 'asset/' . get_option('site_logo')) && get_option('site_logo') != '') {
				unlink(FCPATH . 'asset/' . get_option('site_logo'));
				set_option('site_logo', "");
			}

			$this->session->set_flashdata('success', 'Logo is removed successfully');
		} else {
			$this->session->set_flashdata('warning', 'Logo already removed');
		}

		redirect('admin/setting');
	}
}