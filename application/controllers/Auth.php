<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AuthModel');
		error_reporting(0);
	}

	public function index()
	{
		// Check login
		if ( $this->prodia->isLogin() ) {
			redirect('');
		}

		$vals = [
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url('assets/captcha/'),
			'font_path'	 	=> BASEPATH.'/fonts/texb.ttf',
			'img_width'     => 150,
			'img_height'    => 50,
			'expiration'    => 5, // satuan detik untuk menghapus file gambar
			'word_length'   => 5,
			'font_size'     => 24,
			'img_id'        => 'Imageid',
			'pool'          => 'abcdefghijklmnopqrstuvwxyz',
			'colors'        => [
					'background'=> [255, 255, 255],
					'border'    => [255, 255, 255],
					'text'      => [0, 0, 0],
					'grid'      => [255, 40, 40]
			]
		];
		
		$captcha = create_captcha($vals);
	
		$this->session->set_userdata('captcha', $captcha['word']);

		$data['jawaban'] =  $captcha['word'];
		$data['captcha'] = $captcha['image'];

		// Pemanggilan View
        $data['content'] = "auth/login";
		$this->load->view('template/page_nonlogin', $data);
	}

	public function register()
	{
		// Check login
		if ( $this->prodia->isLogin() ) {
			redirect('');
		}

		$vals = [
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url('assets/captcha/'),
			'font_path'	 	=> BASEPATH.'/fonts/texb.ttf',
			'img_width'     => 150,
			'img_height'    => 50,
			'expiration'    => 5, // satuan detik untuk menghapus file gambar
			'word_length'   => 5,
			'font_size'     => 24,
			'img_id'        => 'Imageid',
			'pool'          => 'abcdefghijklmnopqrstuvwxyz',
			'colors'        => [
					'background'=> [255, 255, 255],
					'border'    => [255, 255, 255],
					'text'      => [0, 0, 0],
					'grid'      => [255, 40, 40]
			]
		];
		
		$captcha = create_captcha($vals);
	
		$this->session->set_userdata('captcha', $captcha['word']);

		$data['jawaban'] =  $captcha['word'];
		$data['captcha'] = $captcha['image'];

		// Pemanggilan View
        $data['content'] = "auth/register";
		$this->load->view('template/page_nonlogin', $data);
	}

	public function submitRegister()
	{
		// Check login
		if ( $this->prodia->isLogin() ) {
			redirect('');
		}

		// Check Captcha
		if ( $this->input->post('captcha') !== $this->session->userdata('captcha') ) {
			$this->session->set_flashdata('error', 'Maaf, captcha salah');
			$this->register();
			return;
		}

		// Check Form Validation
		$this->form_validation->set_rules($this->rulesDaftar());
		if ($this->form_validation->run() == FALSE) {
			$msg_errors = $this->prodia->validationError($this->form_validation->error_array());
			$this->session->set_flashdata('error', $msg_errors);
			$this->register();
			return;
		}

		// Check password
		if ( $this->validPassword($this->input->post('password')) ) {
			$this->session->set_flashdata('error', $this->validPassword($this->input->post('password')));
			$this->register();
			return;
		}

		// Check email
		$column = 'email';
		$data = array(
			'LOWER(email)'		=> strtolower($this->input->post('email'))
		);

		$resultEmail = $this->AuthModel->get($column, $data);
		// Check error get data
		if ( !$resultEmail['result'] && $resultEmail['error']['message'] ) {
			$this->session->set_flashdata('error', strip_quotes($resultEmail['error']['message']));
			$this->register();
			return;
		}
		// Check email in db
		$num = $resultEmail['result']->num_rows();
		if ( !empty($num) || $num > 0 ) {
			$this->session->set_flashdata('error', 'Email sudah terdaftar');
			$this->register();
			return;
		}

		// Insert Data
		$user = array(
			'firstname' 	=> $this->input->post('fname'),
			'lastname' 		=> $this->input->post('lname'),
			'email' 		=> $this->input->post('email'),
			'password' 		=> password_hash($this->input->post('password'), PASSWORD_BCRYPT),
			'phone_number' 	=> $this->input->post('phone'),
			'create_by' 	=> 0,
			'update_by' 	=> 0
		);

		$resultInsert = $this->AuthModel->insert($user);

		// Check error insert data
		if ( !$resultInsert['result'] && $resultInsert['error']['message'] ) {
			$this->session->set_flashdata('error', strip_quotes($resultInsert['error']['message']));
			$this->register();
			return;
		}

		$this->session->set_flashdata('success', 'Anda telah berhasil daftar, silahkan masuk!');
		redirect('masuk');
	}

	public function submitLogin()
	{
		// Check login
		if ( $this->prodia->isLogin() ) {
			redirect('');
		}

		// Check Captcha
		if ( $this->input->post('captcha') !== $this->session->userdata('captcha') ) {
			$this->session->set_flashdata('error', 'Maaf, captcha salah');
			$this->index();
			return;
		}

		// Check Form Validation
		$this->form_validation->set_rules($this->rulesMasuk());
		if ($this->form_validation->run() == FALSE) {
			$msg_errors = $this->prodia->validationError($this->form_validation->error_array());
			$this->session->set_flashdata('error', $msg_errors);
			$this->index();
			return;
		}

		// Call Api Login
		$url = "http://localhost/prodia/api/login";

		// Membuat Body API
		$body = '{
			"email": "'.$this->input->post('email').'",
			"password": "'.$this->input->post('password').'"
		}';
		
		$result = $this->prodia->postAPI($url,$body);

		// Jika login success
		if ( $result['code'] == '200' ) {
			$this->prodia->create_user_session($result['data']);
			$this->session->set_flashdata('success', $result['message']);
			redirect('');
		}

		// Jika login gagal
		$this->session->set_flashdata('error', 'Maaf, terdapat kesalahan pada saat login');
		$this->session->unset_userdata('token');
		$this->session->sess_destroy();
		redirect('masuk');
	}

	// public function submitLogin()
	// {
	// 	// Check login
	// 	if ( $this->prodia->isLogin() ) {
	// 		redirect('');
	// 	}

	// 	// Check Captcha
	// 	if ( $this->input->post('captcha') !== $this->session->userdata('captcha') ) {
	// 		$this->session->set_flashdata('error', 'Maaf, captcha salah');
	// 		$this->index();
	// 		return;
	// 	}

	// 	// Check Form Validation
	// 	$this->form_validation->set_rules($this->rulesMasuk());
	// 	if ($this->form_validation->run() == FALSE) {
	// 		$msg_errors = $this->prodia->validationError($this->form_validation->error_array());
	// 		$this->session->set_flashdata('error', $msg_errors);
	// 		$this->index();
	// 		return;
	// 	}

	// 	// Check login
	// 	$column = 'id, email, password, firstname, lastname, phone_number';
	// 	$where = array(
	// 		'LOWER(email)' 		=> $this->input->post('email')
	// 	);

	// 	$resultLogin = $this->AuthModel->get($column, $where);
	// 	// Check error get data
	// 	if ( !$resultLogin['result'] && $resultLogin['error']['message'] ) {
	// 		$this->session->set_flashdata('error', strip_quotes($resultLogin['error']['message']));
	// 		$this->index();
	// 		return;
	// 	}

	// 	// Check email in db
	// 	$num = $resultLogin['result']->num_rows();
	// 	if ( empty($num) || $num == 0 ) {
	// 		$this->session->set_flashdata('error', 'Email belum terdaftar silahkan daftar terlebih dahulu');
	// 		$this->index();
	// 		return;
	// 	}

	// 	// Check password in db
	// 	$password = $resultLogin['result']->row()->password;
	// 	if (!password_verify($this->input->post('password'), $password)) {
	// 		$this->session->set_flashdata('error', 'Password salah, silakan coba lagi');
	// 		$this->index();
	// 		return;
	// 	}

	// 	$session = array(
	// 		'id'			=> $resultLogin['result']->row()->id,
	// 		'email'			=> $resultLogin['result']->row()->email,
	// 		'name'			=> $resultLogin['result']->row()->firstname.' '.$resultLogin['result']->row()->lastname,
	// 		'phone'			=> $resultLogin['result']->row()->phone_number
	// 	);

	// 	$this->prodia->create_user_session($session);
		
	// 	redirect('');
	// }

	private function rulesDaftar()
	{	
		$this->form_validation->set_message('required', '{field} tidak boleh kosong');
		$this->form_validation->set_message('valid_email', '{field} yang dimasukkan tidak valid');
		$this->form_validation->set_message('regex_match', '{field} harus berupa angka');
		$this->form_validation->set_message('min_length', '{field} minimal memiliki {param} karakter');
		$this->form_validation->set_message('matches', '{field} tidak sesuai dengan Kata Sandi');
		return [
			[
				'field' => 'fname', 'label' => 'First Name', 'rules' => 'required'
			],
			[
				'field' => 'lname', 'label' => 'Last Name', 'rules' => 'required'
			],
			[
				'field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'
			],
			[
				'field' => 'phone', 'label' => 'Nomor Handphone', 'rules' => 'required|regex_match[/^[0-9,]+$/]|min_length[10]'
			],
			[
				'field' => 'password', 'label' => 'Kata Sandi', 'rules' => 'required'
			],
			[
				'field' => 'confirmPassword', 'label' => 'Konfirmasi Kata Sandi', 'rules' => 'required|matches[password]'
			],
			[
				'field' => 'captcha', 'label' => 'Captcha', 'rules' => 'required'
			],
		];
	}

	private function rulesMasuk()
	{	
		$this->form_validation->set_message('required', '{field} tidak boleh kosong');
		$this->form_validation->set_message('valid_email', '{field} yang dimasukkan tidak valid');
		return [
			[
				'field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'
			],
			[
				'field' => 'password', 'label' => 'Kata Sandi', 'rules' => 'required'
			],
		];
	}

	public function logout()
	{
		$this->session->unset_userdata('token');
		$this->session->sess_destroy();
		redirect('masuk');
	}

	private function validPassword($password)
	{
		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';
		$regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
		$message = false;

		if (preg_match_all($regex_uppercase, $password) < 1)
		{
			$message = 'Kata sandi minimal memiliki 1 huruf besar';
		}

		if (strlen($password) < 8)
		{
			$message = 'Kata sandi minimal memiliki 8 karakter';
		}

		return $message;
	}
}
