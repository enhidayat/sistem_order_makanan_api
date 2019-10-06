<?php 

	/**fungsi helper hanya berisi fungsi2 saja
	 * 
	 */

	function check_login()
	{
		$ci = get_instance(); // membuat variable get_instance untuk dpt menggunakan objek ci yg berisi library ci
		if (!$ci->session->userdata('email')) {
			redirect('auth');
		}else{
			$role_id = $ci->session->userdata('role_id'); //mebuat var yg berisi role_id dari session
			$menu = $ci->uri->segment(1); // membuat var u/ menampung uri keberapa(apa) yg akan diakses untuk di cocokan dg pengakses berdasarkan id(admin/user)(boleh atau  tidak )
			//query u/ mengambil data menu dr tb_ user_menu dengan where dr field menu uri sebalumnya
			$queryMenu = $ci->db->get_where('user_menu',['menu' => $menu])->row_array();
			//setelah mendapat semua field dr tb user_menu ambil id saja (hasil kembalian berupa array 1 baris)
			$menu_id = $queryMenu['id']; //sekarang sudah dapat id tinggal mencocokan user_role dan menu_id pd tb

			//memfilter /mencocokan field role_id yg sesuai dg field menu_id (FYI: anka dr $menu_id dijadikan angka pencocok sebai menu_id pd tb user_access_menu)
			$user_access = $ci->db->get_where('user_access_menu', [
				'role_id' =>$role_id,
				'menu_id' =>$menu_id
			]);
			//jika sudah di filter selanjutnya hitung/ cek ada tidak baris yg sesuai
			//jika tidak ada , arahkan ke methode blocked
			if ($user_access->num_rows()<1) {
				redirect('auth/blocked');
			}
		}
	}

	function check_access($role_id, $menu_id)
	{
		$ci = get_instance();

		$ci->db->where('role_id', $role_id); //utk mencocokan antar field nilai role_id dan menu_id sesuai tidak dg tb user_access_menu mengacu dg var $role_id dan var $menu_id yg didapat dr parameter (jk ad yg sesuai maka akan tampil ceklis halaman role_access  sesuai ceklis/ hak access pd tb_user_role_access)
		$ci->db->where('menu_id', $menu_id);
		// penulisan diatas bisa ditulis dg:
		// $this->db->get_where('user_access_menu', [
		// 	'role_id' => $role_id,
		// 	'menu_id' => $menu_id
		// ]);

		$hasil = $ci->db->get('user_access_menu'); //proses pencocokan/seleksi

		if ($hasil->num_rows()>0) { //menghitung hasil pencocokan jika ada akan diset checked
			return "checked='checked'"; //memberikan chek jika ada yg sesuai antar filed role_id dan menu_id
		}
	}