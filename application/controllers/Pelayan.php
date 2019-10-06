<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		check_login();
	}

	public function index()
	{
		$data['title'] = 'Waiter Page';
		$data['user'] = $this->db->get_where('user', ['email' =>
			$this->session->userdata('email')])->row_array();

		$data['food_menu'] = $this->db->get('food_menu')->result_array(); //mengambil data dr tb food_menu
		$data['fn'] = $this->db->get('food_menu')->num_rows(); //mengambil data dr tb food_menu

		// $this->form_validation->set_rules('menu', 'Menu', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('pelayan/index', $data);
			$this->load->view('templates/footer', $data);
		} else {
			// $this->db->insert('food_menu', ['menu' => $this->input->post('menu')] ); //simpan data ke db dari inputan name= menu dg method post(menu/index.php)
			// $this->Menu_model->insertMenu();
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong>New menu added.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('pelayan');
		}
	}

}
