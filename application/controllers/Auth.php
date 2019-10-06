<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Auth extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); //hanya bisa untuk 1 class
		// $this->load->model('menu'); //hanya bisa untuk 1 class
	}

	public function index()
	{
		//cek session sudah ada blom
		if ($this->session->userdata('email')) {
			redirect('user');
		}

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == false) {
			$data['title'] = "Login!";
			$this->load->view('templates/auth_header',$data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else{
			//sukses validasi
			$this->_login();
		}
	}

	private function _login()
	{
		$email 	= $this->input->post('email');
		
		$password = $this->input->post('password');

		$user = $this->db->get_where('user',['email' => $email])->row_array(); //ambil 1 baris field db, select * from tb_(user) where email=email 
		// var_dump ($user);
		// die();

		//jika ada usernya
		if ($user) {
			// jika usernya aktif
					if ($user['is_active'] == 1) { //$user['is_active'] == mengambil filed is_active pad tb user

									//cek passaword
										//untuk memverifikasi pass dr inputan dan database yg sudah dihash
					if (password_verify($password, $user['password'])) 
					{
						// jika proses benar siapkan data u/ seasson
						$data = [
							'email'	=> $user['email'],
							'role_id' => $user['role_id']
						]; //data udah siap
						$this->session->set_userdata($data);

						//cek role_id
						if ($user['role_id'] == 1) {

							//arahkan ke user controller
							redirect('admin');
						}else{
							redirect('user');	
						}



					} else{
													//salah pass
						$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Error!</strong> Wrong password. Please input password corectly!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
							</div> ');
						redirect('auth');
					}
				}else{
					$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Error!</strong> Your email has not been activated. Please activated!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div> ');
					redirect('auth');
				}
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Error!</strong> Your email has not been registered. Please registered!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('auth');
			}
		}

		public function registration()
		{

			//cek session sudah ada blom
			if ($this->session->userdata('email')) {
				redirect('user');
			}
			
			$this->form_validation->set_rules('name', 'Name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]',[
				'is_unique' => 'This Email has already registered!'
		]); //
			$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[5]|matches[password2]',[
				'matches' => 'Password dont matches!',
				'min_length' =>'Password too short!'

			]);
			$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
			if ($this->form_validation->run()==false) {
				$data['title'] = "Registration!";
				$this->load->view('templates/auth_header',$data);
				$this->load->view('auth/registration');
				$this->load->view('templates/auth_footer');
			}else{
				$email =	$this->input->post('email',true);
				$data = [
					'name' 		=> htmlspecialchars($this->input->post('name',true)),
					'email' 	=> htmlspecialchars($email),
					'image' 	=> 'default.jpg',
					'password' 		=> password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
					'role_id' 		=> 2,
					'is_active' 	=>0,
					'date_created' 	=>time()

				];
			//siapkan token 
				$token = base64_encode(random_bytes(64));
				//siapkan data untuk di insert ke tb token
				$user_token = [
					'email'			=> $email,
					'token' 		=> $token,
					'date_created' 	=> 	time()	//waktu saat ini	//untuk vitur expired activation
				];
				
			$this->db->insert('user',$data); //kalo data udah urut sebaris selesai //harusnya sih pake model ,data sudah berhasil di insert ke tbl
			$this->db->insert('user_token', $user_token);//data sudah berhasil di insert ke tbl user_token 
			//lalu kirim email activation
			//panggil metd kirim enail. 
			//utk aktivasi aplikasi kita akan kirim email ke user  yg didlamnya ad link yg bisa diklik. link itu berisi data kemudian dikirimkan ke aplikasi kita .data itu berisi token(bilangan random yg panjang) yg isinya hanya diketahui oleh sistem app kita.jd saat usr klik link akan diarahkan ke sistem kemudian data akan dicocokan dengan dtbase berdasarkan token jika cocok maka akun yg didaftarkan akan di aktifasi 
			$this->_sendEmail($token,'verify'); //$token = token selain di insrt jg dikirim ke email, verify= parameter u/ fitur verifikasi akun

			//notif sukses create account
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation!</strong> Your account has been created. Please activated!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('auth');
		}
	}
	//method ukirim email
	private function _sendEmail($token,$type) 
	{
		//buat konfiguisi preferencesnya ada di user guide ci->email class
		$config = [
			'protocol'	=> 'smtp', //simple mail protocol
			'smtp_host'	=> 'ssl://smtp.googlemail.com',
			'smtp_user' => 'dayoke06@gmail.com',
			'smtp_pass'	=> 'mudah123',
			'smtp_port' => '465', //port smtpnya gg
			'mailtype'	=> 'html', //karna ada link nya{anchor} 
			'charset'	=> 'utf-8',
			'newline'	=> "\r\n"
		];
		$this->load->library('email', $config); //mengaktifkan library email dan mengisi data dengan nilai  $var config
		$this->email->initialize($config);

		$this->email->from('dayoke06@gmail.com','Day Oke');
		$this->email->to($this->input->post('email',true));
		// $this->email->cc('ozink003@gmail.com');
		//uji apakah u verify atau apa forgot password

		if ($type == 'verify') { // u/ verifikasi
			$this->email->subject('Account Verification');
			$this->email->message(' Click  this link to verify your account : <a href=" '.base_url().'auth/verify?email='.$this->input->post('email').'&token='.urlencode($token).'">Activate</a> ');
			// fun urlencode() digunakan untuk mnerjemahkan karakter khusus (mis. +=) yg url menerjemhakan
			//  sebagai spasi atau krakterlain menjadi krakter yg sesuai dg encode base64_encode sehingga url tidak salah menerjemahkan hingga berakibat error
		}elseif ($type == 'forgotpass') { // u/ forgotpass
			$this->email->subject('Reset Password');
			$this->email->message(' Click  this link to reset your password : <a href=" '.base_url().'auth/resetpassword?email='.$this->input->post('email').'&token='.urlencode($token).'">Reset Password</a> ');
		}
		
		if ($this->email->send()) {
			# code... benar
			return true;
		}else{
			echo $this->email->print_debugger();
			die;
		}
		
	}

	//untuk  menangani verifikasi 
	public function verify()
	{
		//ambil data email token dari url untuk dicockan ke db 
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		//ambil data user dr tb user untuk di cocokan apakah data dari url benar2 ada di db
		$user = $this->db->get_where('user',['email' => $email])->row_array();
		if ($user) {
			//jk email sudah benar ada di db cek token di tb user_token apakah sesui dg url
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				//jika token valid cek estimasi masa kadaluarsa token jk lebih dr 24 jam maka token tidak dpt digunakan u/ verifikasi
				if (time() - $user_token['date_created'] < (60*60*24)) {
					//jika semua data cocok dan token tidak expired rubah filedl is_active dari nilai 0(belum aktiv) jd 1(sudah aktiv)
					//menggunakan query builder
					$this->db->set('is_active', 1); //rubah nilai saat ini jadi 1
					$this->db->where('email', $email); //klause
					$this->db->update('user');

					//jika user sudah aktiv hapus token krna sudah tidak dibutukan
					$this->db->delete('user_token', ['email'	=>	$email]);
					//berikan notif sukses verifikasi
					$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Conratulation!</strong>'.$email.' has been activated. Please login.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div> ');
					redirect('auth');
				}else{ //jika token > 24 jam
					//jika token kadaluarsa hapus email dan token
					$this->db->delete('user', ['email' => $email]);
					$this->db->delete('user_token', ['token' => $token]);

					$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Error!</strong> Account activation failed. token expired.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						</div> ');
					redirect('auth');
				}
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Error!</strong> Account activation failed. Invalid token.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('auth');
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error!</strong> Account activation failed. Wrong email.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('auth');
		}
	}

	public function logout(){
		$this->session->unset_userdata('email'); //hapus session email
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Congratulation!</strong> You have been logged out!
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div> ');
		redirect('auth');
	}
	//membuat method blocked u/ mengarahkan userke halaman forbiden jk user tdk punya akses 
	public function blocked()
	{
		$this->load->view('auth/blocked');
	}

	public function forgotPassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Forgot Password";
			$this->load->view('templates/auth_header',$data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');
		} else {
			$email = $this->input->post('email',true); //inputan dr views/forgot-password.php
			$user  = $this->db->get_where('user', ['email'	=>	$email, 'is_active' => 1])->row_array(); //membandikan apakah ada email yg sesuai antara yg diiput dan yg ada di db d an apakah kolom is_active bernilai 1 jika iya masuk ke statemen if jk tidak masuk ke else

			if ($user) {
				$token = base64_encode(random_bytes(64));
				$user_token = [
					'email'	=> $email,
					'token'	=> $token,
					'date_created'	=>	time()
				];
				//jika data sudah ok insert ke db
				$this->db->insert('user_token', $user_token); //insert into user_token values $user_token
				//selanjutna kirim enail
				$this->_sendEmail($token,'forgotpass'); //menggunakan this karna berada dalam method lain //harus mengirim parameter
				//kirim notif sukses mengirim email
				$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Congratulation ! </strong> Please check your email to reset your passaword.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('auth/forgotpassword');

			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Error!</strong> Email is not registered or activated
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('auth/forgotpassword');
			}
		}
	}
	public function resetPassword() // fun untuk mencocokan ketika di redirect dr email data dikirim di url lalu dicocokan
	{
		$email = $this->input->get('email'); //ambil dr url
		$token = $this->input->get('token');

		//cek di db ada nggak data(email) sesuai dg dari url
		// $user = $this->user->getUserByEmail(); //misal pakai model
		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		//jka ada/sesuai maka lakukan pengujian untuk kecocokan token
		if ($user) {
				//ambil token dari db untuk dicek apakah token sesuai dg yg ada di url
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				//sampai sini token dan email cocok
				//selanjutnya buat session agar hanya diketahui oleh server saja dan hanya akan aktiv saat user mengklik reset password dr email 1 kali reset selanjutnya session dihapus
				$this->session->set_userdata('reset_pass', $email);
				$this->changePassword(); //jalankan func rubah pass
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Error!</strong> Reset password failed. Invalid token
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div> ');
				redirect('auth');
			}

		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Error!</strong> Reset password failed. Wrong Email
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('auth');
		}	
	}
	public function changePassword()
	{
		//cek dulu ada session reset_pass tidak jika tidak mk func changepassword tidak dpt dijalnkan /reidrect ke login
		if (!$this->session->userdata('reset_pass')) {
			redirect('auth');
		}

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[5]|matches[password2]');
		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[5]|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Change Password";
			$this->load->view('templates/auth_header',$data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');
		} else {
			// sebelum di update passx. engkripsi dulu
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			//ambil email yg ada di session reser pass 
			$email = $this->session->userdata('reset_pass'); 
			
			//selanjutnua update pass


			$this->db->set('password', $password); // kolom yg akan di update
			$this->db->where('email', $email); //klause 
			$this->db->update('user');// jlaankan update

			//hapus session reset_pass
			$this->session->unset_userdata('reset_pass');

			//notif n redirect
			$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Congratulation ! </strong> Password has been changed. Please login
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div> ');
			redirect('auth');
		}
	}
}