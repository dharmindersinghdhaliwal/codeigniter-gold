<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
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
		$data['page_title'] = 'All Categories';

		$data['categories'] = db_get_all_data('category');

		$this->load->view('admin/header',$data);
		$this->load->view('admin/category/list',$data);
		$this->load->view('admin/footer',$data);
	}

	public function add()
	{
		$data['page_title'] = 'Add New Category';

		$this->form_validation->set_rules('name', 'Category Name', 'required|is_unique[category.name]');

		$save_data = [
			'name' => $this->input->post('name'),
			'icon' => $this->input->post('icon'),
			'date_created' => date('Y-m-d H:i:s')
		];

		if ($this->form_validation->run()) {
			if($this->db->insert('category',$save_data)){
				$this->session->set_flashdata('success', 'New category add successfully.');
				redirect('admin/category');
			}
		}

		$data = array_merge($data, $save_data);

		$this->load->view('admin/header',$data);
		$this->load->view('admin/category/add',$data);
		$this->load->view('admin/footer',$data);
	}

	public function edit($id = '')
	{
		$data['page_title'] = 'Update Category';
		$data['category'] = db_get_row_data('category',array('id'=>$id));

		$this->form_validation->set_rules('name', 'Category Name', 'required|is_unique[category.name.id.' . $id . ']');

		if ($this->form_validation->run()) {
			$save_data = [
				'name' => $this->input->post('name'),
				'icon' => $this->input->post('icon'),
				'date_updated' => date('Y-m-d H:i:s')
			];

			$this->db->where('id',$id);
			if($this->db->update('category',$save_data)){
				$this->session->set_flashdata('success', 'Category Updated successfully.');
				redirect('admin/category');
			}
		}

		$this->load->view('admin/header',$data);
		$this->load->view('admin/category/edit',$data);
		$this->load->view('admin/footer',$data);
	}

	public function view($id)
	{
		$data['category'] = db_get_row_data('category',array('id'=>$id));

		$this->load->view('admin/category/view',$data);
	}
}