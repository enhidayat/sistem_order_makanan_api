<?php 
defined('BASEPATH') or exit('No direct script access allowed');

	/**
	 * 
	 */
	class Menu extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			check_login();

		}
		public function index()
		{
			$data['title'] = 'Menu Management';
			$data['user'] = $this->db->get_where('user', ['email' =>
				$this->session->userdata('email')])->row_array();

			$data['menu'] = $this->db->get('user_menu')->result_array(); //mengambil data dr tb user_menu

			$this->form_validation->set_rules('menu', 'Menu', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('menu/index', $data);
				$this->load->view('templates/footer', $data);
			} else {
				// $this->db->insert('user_menu', ['menu' => $this->input->post('menu')] ); //simpan data ke db dari inputan name= menu dg method post(menu/index.php)
				$this->Menu_model->insertMenu();
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Congratulation!</strong>New menu added.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('menu');
			}

		}

		public function submenu()
		{
			$data['title'] = 'Submenu Management';
			$data['user'] = $this->db->get_where('user', ['email' =>
				$this->session->userdata('email')])->row_array();	

			// $this->load->model('Menu_model','menu');
			$data['subMenu'] = $this->Menu_model->getSubMenu(); //membuat method di model
			$data['menuu'] = $this->db->get('user_menu')->result_array();

			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('menu_id', 'Menu', 'trim|required');
			$this->form_validation->set_rules('url', 'URL', 'trim|required');
			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

			if ($this->form_validation->run() == false) {
				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('menu/submenu', $data);
				$this->load->view('templates/footer', $data);
			} else {
				$data = [
					'title'	 		=> $this->input->post('title'),
					'menu_id' 		=> $this->input->post('menu_id'),
					'url' 			=> $this->input->post('url'),
					'icon'			=> $this->input->post('icon'),
					'is_active'		=> $this->input->post('is_active')
				];
				$this->db->insert('user_sub_menu', $data); //$data dari Controller Menu.php
				// tes log activity
				// panggil fungsi helper log dan isi parameter
				helper_log("add", "menambahkan data");
				            //nilai prameter ex.add = diganti sesuai kebutuhan
				//
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Congratulation!</strong>New Submenu added.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('menu/submenu'); 
			}
		}

		public function submenuedit($id)
		{
			$data['title']	= 'Form Edit Data Submenu';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(); //mengambil user pd tb user untuk disimpan di var data kemudian dikirim ke views besamaan (templates/topbar,$data)
			// $this->load->model('Menu_model','menu');
			 // $data['data_submenu'] = $this->Menu_model->getSubmenuById($id);
			$data['row'] = $this->Menu_model->getMenu($id); //membuat method di model
			$data['menu'] = $this->Menu_model->menu_array();
			$data['id_usermenu'] = $this->Menu_model->id_userMenu();
			// $data['array_satu'] = $this->Menu_model->array_satu();
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('menu', 'Menu', 'trim|required');
			$this->form_validation->set_rules('url', 'URL', 'trim|required');
			$this->form_validation->set_rules('icon', 'Icon', 'trim|required');
			if ($this->form_validation->run() == false) {
				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('menu/submenuedit', $data);
				$this->load->view('templates/footer', $data);
				
			} else {
				$this->Menu_model->edit_submenu();
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Congratulation!</strong>Submenu successful updated.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('menu/submenu');
			}

		}

		public function deleteSubmenu($id)
		{
			$this->Menu_model->delete($id);
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong>Submenu has been deleted.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('menu/submenu');
		}
	//================ menu ==========================================================================================
		public function edit($id)
		{
			$data['title']	= 'Form Edit Menu';
			$data['user']	= $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array(); //ambil data dr tb user where email = email yg ada di session saat ini
			$data['menu'] = $this->Menu_model->getMenuById($id);

			$this->form_validation->set_rules('menu', 'Menu', 'trim|required|min_length[4]');

			if ($this->form_validation->run() == false) {
				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('menu/edit', $data);
				$this->load->view('templates/footer', $data);
				
			} else {
				$this->Menu_model->editMenu();
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Congratulation!</strong> Menu has been updated.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('menu');
			}
		}
		public function delete($id)
		{
			$this->Menu_model->deleteMenu($id);
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong> Menu item has been deleted.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('menu');	
		}
	}
	?>