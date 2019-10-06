<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_login();
	}
	public function index()
	{
		$data['title'] = 'Dashboard';

		$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')] )->row_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('admin/index',$data);
		$this->load->view('templates/footer',$data);
	}
	public function role() //menampilkan semua role
	{
		$data['title'] 	= 'Role';
		$data['user']	= $this->db->get_where('user', ['email'	=> $this->session->userdata('email')])->row_array();
		$data['role']	= $this->db->get('user_role')->result_array();
		
		$this->form_validation->set_rules('role', 'Role', 'trim|required|min_length[3]');
		if ($this->form_validation->run() ==  FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer', $data);
			
		} else {
			# code...
			$this->Admin_model->addNewRole();
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong> New role added.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('admin/role');
		}



	}
	public function roleAccess($role_id) //hanya  menampilkan role yg sesui id
	{
		$data['title'] 	= 'Role Access';
		$data['user']	= $this->db->get_where('user', ['email'	=> $this->session->userdata('email')])->row_array();
		$data['role']	= $this->db->get_where('user_role', ['id' => $role_id])->row_array(); //menampilkan / menyeleksi role sesuai id dr parameter

		//membuat pengecualian menu admin terseleksi shg menu admin tdk muncul pd halaman role_access
		$this->db->where('id !=', 1);
		//mengambil semua  baris dari tb user_menu
		$data['menu']	= $this->db->get('user_menu')->result_array();
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role-access', $data);
		$this->load->view('templates/footer');
	}

	public function changeAccess()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		//siapkan data untuk dimasukksan ke query
		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];
		//cek data ada tidak kalo ada hapus kalo tidak insert pd tb user_access_menu(jika ada maka akan terceklis sehingga bisa di unchek yg berarti dihapus,jika tidak ada uncheck mka bisa di checklist yg akan meng insrt data access)
		$hasil = $this->db->get_where('user_access_menu', $data); 

		if ($hasil->num_rows() < 1) { // jika tidak ada /uncheck
			$this->db->insert('user_access_menu', $data); // ketika dicheck maka insert kr tb
		} else {
			$this->db->delete('user_access_menu', $data);
		}

		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Congratulation!</strong> Access Changed!
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div> ');
	}
	public function addRole()
	{
		$data['title'] 	= 'Role';
		$data['user']	= $this->db->get_where('user', ['email'	=> $this->session->userdata('email')])->row_array();
		$data['role']	= $this->db->get('user_role')->result_array();
		$this->form_validation->set_rules('role', 'Role', 'trim|required|min_length[3]');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer', $data);
		} else {
			// $this->db->insert('user_role', ['role' => $this->input->post('role')] ); //simpan data ke db dari inputan name= menu dg method post(menu/index.php)
			$this->Admin_model->addNewRole();
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong> New role added.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('admin/role');
		}
	}
	public function roleEdit($id)
	{
		$data['title'] 	= 'Form Role Edit';
		$data['user']	= $this->db->get_where('user', ['email'	=> $this->session->userdata('email')])->row_array();
		// $data['role']	= $this->db->get('user_role')->result_array();
		$data['role']	=$this->Admin_model->getuserRoleByI($id);

		$this->form_validation->set_rules('role', 'Role', 'trim|required|min_length[3]');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role-edit', $data);
			$this->load->view('templates/footer', $data);
		} else {
			// $this->db->insert('user_role', ['role' => $this->input->post('role')] ); //simpan data ke db dari inputan name= menu dg method post(menu/index.php)
			$this->Admin_model->editRole();
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong> role successfull updated.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('admin/role');
		}
	}
	public function deleteRole($id)
	{
		$this->Admin_model->deleteRole($id);
		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Congratulation!</strong> Role item has been deleted.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div> ');
		redirect('admin/role');	
	}
	public function userList()
	{
		$data['title'] 	= 'User List';
		$data['user']	= $this->db->get_where('user', ['email' =>$this->session->userdata('email')])->row_array();
		$data['list_of_user'] = $this->Admin_model->getMenuList();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/user-list', $data);
		$this->load->view('templates/footer', $data);
	}
	public function userlistedit($id)
	{
		$data['title'] = 'Form User List Edit';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['user_role_data'] = $this->Admin_model->getUserById($id);
		$data['rolelist'] = $this->Admin_model->roleList(); //return nilai role
		$data['id_rolelist'] = $this->Admin_model->idRoleList(); // return nilai id role

		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');

		if ($this->form_validation->run() ==  FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/user-list-edit', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$this->Admin_model->editroleAccess();
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong> Role access has been edited.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('admin/userlist');	
		}
	}
	public function deleteUser($id)
	{
		$this->Admin_model->userDelete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Congratulation!</strong> User has been deleted.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div> ');
		redirect('admin/userlist');
	}

	// ==== membuat daftar makanan
	public function createFoodMenu()
	{
		$data['title'] 	= 'Create Food Menu';
		$data['user']	= $this->db->get_where('user', ['email' =>$this->session->userdata('email')])->row_array();
		$data['food_menu'] = $this->Admin_model->getfoodMenu();

		$this->form_validation->set_rules('foods_and_drinks', 'Food and Drink', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/food_menu', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$this->Admin_model->insertFoodMenu();
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation! </strong> new varian Food Menu has been added.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('admin/createfoodmenu');
		}

	}

	// end class
}

?>