<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function getSubMenu()
	{
		$quer = "SELECT user_sub_menu.*, user_menu.menu 
		FROM user_sub_menu JOIN user_menu
		ON user_sub_menu.menu_id = user_menu.id
		";

		return $this->db->query($quer)->result_array();	
	}
	public function insertMenu()
	{
		$data=[
			"menu"	=>	$this->input->post('menu',true)
		];
		$this->db->insert('user_menu', $data);
	}
	public function menu_array(){
		// return $this->db->get_where('user_sub_menu',)->row_array(); //row_array() = untuk mengambil hanya 1 baris  dlm bentuk array , row()= untuk mengambil dalam bntuk objex
         // $this->db->get('Table', limit, offset);
		$this->db->select('menu');
		$this->db->from('user_menu');
		// $this->db->where('code',$asset);
		// return $this->db->get()->result()->row('name');
		return $this->db->get()->result_array('menu');
		// $quer = "SELECT user_sub_menu.*, user_menu.menu 
		// FROM user_sub_menu JOIN user_menu
		// ON user_sub_menu.menu_id = user_menu.id
		// ";

		// return $this->db->query($quer)->row_array();	
	}
	public function id_userMenu()
	{
		$this->db->select('id');
		$this->db->from('user_menu');
		return $this->db->get()->result_array('id');
	}

	public function getMenu($id)
	{
		$this->db->select('user_sub_menu.* ,user_menu.menu'); //mengambil semua field di tb user submenu dan field menu di tb user_menu
		$this->db->from('user_sub_menu');
		$this->db->join('user_menu', 'user_sub_menu.menu_id = user_menu.id', 'left');
		$this->db->where('user_sub_menu.id', $id); //id untuk seleksi yg menyesuaikan berdasarkan id tb user_sub_menu dan menampilkan menu dr tb user_menu yg memiliki kesaamaan antara menu_id milik tb user_sub_menu dan id milik user_menu saja. 
		return $this->db->get()->row_array(); //mengembalikan dalam bentuk baris (tidak perlu looping kayak result_array);
	}
	public function edit_submenu()
	{
		$data = [
			"title" => $this->input->post('title',true),
			"menu_id"	=> $this->input->post('menu',true),
			"url"	=> $this->input->post('url',true),
			"icon"	=> $this->input->post('icon',true),
			"is_active"	=>$this->input->post('is_active',true)
		];
		// var_dump ($data);
		// die();
		// $this->db->where('id', $this->input->post('id'));
		// $variable =$this->db->where('id', $this->input->post('id'));
		// var_dump ($variable);
		// die();
		// $this->db->update('user_sub_menu', $data);
		// return $this->db->get('user_sub_menu')->result_array();

		$this->db->where('id', $this->input->post('id')); //mengambil id untuk seleksi
		$this->db->update('user_sub_menu', $data);
	}
	//fun deletesubmenu
	public function delete($id)
	{
		$this->db->delete('user_sub_menu',['id' => $id]); //hapus record sesuai id pada parameter
	}
	//=========================  menu ================
	public function getMenuById($id)
	{
		return $this->db->get_where('user_menu', array('id' => $id))->row_array();
	}
	public function editMenu()
	{
		$data = [
			"menu" => $this->input->post('menu',true)
		];
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('user_menu', $data);
	}
	public function deleteMenu($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('user_menu');
	}

}


/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */