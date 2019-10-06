<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * 
	 */
	class Admin_model extends CI_Model
	{
		
		public function addNewRole()
		{
			$data =[
				"role" => $this->input->post('role', true)
			];

			// $this->db->insert('user_role', ['role' => $this->input->post('role')] );
			$this->db->insert('user_role', $data);
		}
		public function getuserRoleByI($id)
		{
			// $this->db->select('*');
			// $this->db->from('user_role');
			// $this->db->where('id', $id);
			// return $this->db->get()->row_array();
			//bisa ditulis singkat :
			return $this->db->get_where('user_role', array('id' => $id))->row_array();
		}
		public function editRole()
		{
			$data=[
				"role" => $this->input->post('role',true)
			];
			// $variable = $this->db->where('id', $id);
			$this->db->where('id', $this->input->post('id',true));
			$this->db->update('user_role', $data);
		}
		public function deleteRole($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('user_role');
		}
		public function getmenuList()
		{
			$this->db->select('user.id,user.name,user.email,user_role.role');
			$this->db->from('user');
			$this->db->join('user_role', 'user.role_id = user_role.id', 'left');
			// $this->db->where('user.id', $Value);
			return $this->db->get()->result_array();
		}

		public function getUserById($id)
		{
			$this->db->select('user.id,user.name,user.email,user.role_id,user_role.role');
			$this->db->from('user');
			$this->db->join('user_role', 'user.role_id = user_role.id', 'left');
			$this->db->where('user.id', $id);
			return $this->db->get()->row_array();
		}
		public function roleList()
		{
			$this->db->select('role');
			$this->db->from('user_role');
			return $this->db->get()->result_array('role');
			// return $this->db->get('user_role')->result_array();
		}
		public function idRoleList()
		{
			$this->db->select('id');
			$this->db->from('user_role');
			return $this->db->get()->result_array();
		}
		public function editroleAccess()
		{
			$data=[
				"name" => $this->input->post('name', true),
				// "email" => $this->input->post('email', true)
				"role_id" => $this->input->post('role',true)
			];
			// var_dump ($data);
			// die();
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('user', $data);
		}
		public function userDelete($id)
		{
			$this->db->where('id', $id);
			$this->db->delete('user');
		}
		public function getfoodMenu()
		{
			return $this->db->get('food_menu')->result_array();
		}
		public function insertFoodMenu()
		{
			$data = [
				"foods_and_drinks" => $this->input->post('foods_and_drinks',true),
				"status" => $this->input->post('status',true),
				"price" => $this->input->post('price',true)
			];

			$this->db->insert('food_menu', $data);
		}
	}

	?>