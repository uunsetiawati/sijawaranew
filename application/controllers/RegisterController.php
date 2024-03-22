<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class RegisterController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth');
	}

	public function index()
	{
		$data['title'] = 'Register';

		$config = array(
			array('field' => 'name', 'label' => 'Email_U', 'rules' => 'required'),
			array('field' => 'email', 'label' => 'Nama_U', 'rules' => 'required'),
			array('field' => 'password', 'label' => 'Nama_U', 'rules' => 'required')
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run()) {
			$condition = ['EMAIL' => $_POST['email'], 'IS_DELETE' => 0];
			$userData = $this->Auth->get_user($condition);
			if (empty($userData)) {
				$data_user = array(
					'ID_USER' => $this->GenerateUniqID($_POST['name']),
					'NAME' => $_POST['name'],
					'ID_ROLE' => 3,
					'PASS' => hash('sha256', md5($_POST['password'])),
					'EMAIL' => $_POST['email'],
					'STATUS' => 0
				);
				$this->db->insert('user', $data_user);

				$this->SendMail($_POST['name'], $_POST['email']);

				$this->session->set_flashdata('msg', "<script> 
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
							toast.addEventListener('mouseenter', Swal.stopTimer)
							toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					})
					Toast.fire({
						icon: 'success',
						title: 'Register Success'
					})
					</script>");
			} else {
				$this->session->set_flashdata('msg', "<script> 
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
							toast.addEventListener('mouseenter', Swal.stopTimer)
							toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					})
					Toast.fire({
						icon: 'error',
						title: 'Email has been registered !'
					})
					</script>");
			}

			redirect('login');
		} else {
			$this->load->view('template/header', $data);
			$this->load->view('auth/register');
			$this->load->view('template/footer');
		}
	}

	public function GenerateUniqID($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 4);
		$uniqid = strtoupper($begin);
		return "USR_" . $uniqid . substr(md5(time()), 0, 3);
	}

	public function account_verify()
	{
		$token = $_GET['token'];
		
		$this->Auth->UpdateStatus($token);
		$this->session->set_flashdata('msg', "<script> 
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			})
			Toast.fire({
				icon: 'success',
				title: 'Verification Success'
			})
			</script>");
		redirect('login');
	}

	public function SendMail($name, $email)
	{
		try {
			$this->load->library('phpmailer');

			$condition = ['EMAIL' => $email];
			$userData = $this->Auth->get_user($condition);
			$token = bin2hex(random_bytes(32));
			$this->Auth->cek_token($userData->ID_USER, 2, $token);

			$subject = "Verify TBH Academy Account";
			$html = "
				<!DOCTYPE html>
				<html lang='en'>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'>
					<title>Verification Email</title>
					<style>
						body {
							font-family: Arial, sans-serif;
							background-color: #f7f7f7;
							padding: 20px;
						}

						.container {
							background-color: #ffffff;
							border-radius: 8px;
							box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
							max-width: 600px;
							margin: 0 auto;
							padding: 20px;
						}

						h2 {
							color: #333333;
						}

						p {
							color: #666666;
						}

						.verification-button {
							display: inline-block;
							padding: 10px 20px;
							background-color: #007BFF;
							color: #FFF !important;
							text-decoration: none;
							border-radius: 5px;
							margin-top: 10px;
						}

						.verification-button:hover {
							background-color: #0056b3;
							color: #FFF;
						}
					</style>
				</head>
				<body>
					<div class='container'>
						<h2>Verify Your Account on TBH Academy</h2>
						<p>Dear $name,</p>
						<p>Thank you for signing up for an account with TBH Academy. To ensure the security of your account and activate its full functionality, we need to verify your email address.</p>
						<p>Please click the button below to verify your account:</p>
						<a class='verification-button' href='" . base_url("account/verify?token=$token") . "'>Verify Account</a>
						<p>If you are unable to click the button directly, you can copy and paste the following link into your web browser's address bar:</p>
						<p><a href='" . base_url("account/verify?token=$token") . "' target='_blank'>" . base_url("account/verify?token=$token") . "</a></p>
						<p>If you did not create an account on TBH Academy, please disregard this email. Your information will remain confidential, and no action is required.</p>
						<p>Thank you for choosing TBH Academy!</p>
						<p>Best regards,<br>The TBH Academy Team</p>
					</div>
				</body>
				</html>
			";

			$status = $this->phpmailer->SendMail($email, 'admin.tbh.academy@gmail.com', $subject, $name, $html);
			return $status;
		} catch (Exception $e) {
			return $e->getMessage();
			die;
		}
	}
}
