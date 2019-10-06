<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_login();
	}
	public function index()
	{
		$data['title'] = 'My Profile';
		//ambil data dari session
		$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('user/index',$data);
		$this->load->view('templates/footer',$data);
	}
	public function edit()
	{
		$data['title']	= 'Edit Profile';
		// print_r($user); 
		//ambil data dr session
		$data['user']	= $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[5]|max_length[120]');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer', $data);
		} else{
			$name = $this->input->post('name'); //setiap input dr multipart pasti mgunakan post
			$email = $this->input->post('email');

			//jika ada gambar yg diupload
			$upload_image = $_FILES['image']['name']; //didapat dr form multipart ['name '] = untuk mengambil data array gambar lebih spesifik berupa nama dari array image
			// var_dump ($upload_image);
			// die();
			
			//verifikasi n validasi
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']     = '5240';
				$config['upload_path'] = './asset/img/profile/';
				
				$this->load->library('upload', $config);
				//trik agar gambar default tidak terhapus saat update gambar dan hanya terhapus gambar update tan sebelumnya ketika diupdate
				$default_image = $data['user']['image'];
				if ($default_image != 'default.jpg') {
					unlink(FCPATH . 'asset/img/profile/' . $default_image);
				}

				//jika berhasill diupload lakukan perubahan nama gambar di tb
				if ( $this->upload->do_upload('image')){
							$new_image = $this->upload->data('file_name'); // menampung data /nama file yg diupload sesuai dg file yg akan diupload
							$this->db->set('image', $new_image); //menset nama/data image yg akan di upadate dg nama gmabar baru(upload). jk tk ada file yg diupload mk kosong
						}else{
							echo $this->upload->display_errors();
						}
					}


				//utk update nma
			$this->db->set('name', $name); //menset data yg akan di update (name)
			$this->db->where('email', $email); //untuk klause where (query buildernya ci)
			$this->db->update('user'); //untuk update


			//notif n redirect
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong> Your Profile has been Updated.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('user');
		}

	}//end of edit method

	public function changePassword()
	{
		$data['title'] = 'Change Password';
		//ambil data dari session
		$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('new_password1', 'New Password', 'trim|required|min_length[5]|max_length[190]|matches[new_password2]');
		$this->form_validation->set_rules('new_password2', 'Confirm Password', 'trim|required|min_length[5]|max_length[190]|matches[new_password1]');

		if ($this->form_validation->run() ==  false) {
			
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('user/changepassword',$data);
			$this->load->view('templates/footer',$data);
		} else {
			$current_password = $this->input->post('current_password', true);
			$new_password 	 = $this->input->post('new_password2',true);
			if (!password_verify($current_password, $data['user']['password'])) {
				//notif n redirect
				$this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Warning!</strong> Wrong current password.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('user/changepassword');
			}else{
				if ($current_password == $new_password) {
					//notif n redirect
					$this->session->set_flashdata('message','<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<strong>Warning!</strong> New password cannot be the same as current password.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div> ');
					redirect('user/changepassword');
				}else {
					//password sudah benar
					$password_hash = password_hash($new_password, PASSWORD_DEFAULT); //mengacak password baru

					$this->db->set('password', $password_hash); //query set field yg akan dirubah
					$this->db->where('email', $this->session->userdata('email')); //klaus
					$this->db->update('user'); //query update

					//notif n redirect
					$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Congratulation!</strong> Your password changed.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div> ');
					redirect('user/changepassword');
				}
			}
		}
	}
	// =========   gallery ===========
	public function gallery(){
		$this->load->view('gallery/index');
	}
	public function prosesUpload(){
		// Panggil Model M_Welcome
		$this->load->model('Gallery_model');
		// Hitung Jumlah File/Gambar yang dipilih
		$jumlahData = count($_FILES['gambar']['name']);
		// Lakukan Perulangan dengan maksimal ulang Jumlah File yang dipilih
		for ($i=0; $i < $jumlahData ; $i++):
			// Inisialisasi Nama,Tipe,Dll.
			$_FILES['file']['name']     = $_FILES['gambar']['name'][$i];
			$_FILES['file']['type']     = $_FILES['gambar']['type'][$i];
			$_FILES['file']['tmp_name'] = $_FILES['gambar']['tmp_name'][$i];
			$_FILES['file']['size']     = $_FILES['gambar']['size'][$i];
			// Konfigurasi Upload
			$config['upload_path']          = './assets/upload/';
			$config['allowed_types']        = 'gif|jpg|png|pdf';
			// Memanggil Library Upload dan Setting Konfigurasi
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')){ // Jika Berhasil Upload
				$fileData = $this->upload->data(); // Lakukan Upload Data
				// Membuat Variable untuk dimasukkan ke Database
				$uploadData[$i]['judul'] = $fileData['file_name']; 
			}
		endfor; // Penutup For
		if($uploadData !== null){ // Jika Berhasil Upload
			// Insert ke Database 
			$insert = $this->Gallery_model->upload($uploadData);
			
			if($insert){ // Jika Berhasil Insert
				echo "
				<a href='".base_url()."'> Kembali </a> 
				<br>
				Berhasil Upload ";
			}else{ // Jika Tidak Berhasil Insert
				echo "Gagal Upload";
			}
		}
	}

	///     =============     end gallery
	
}

?>