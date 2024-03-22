<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class Guest extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Event', 'Course', 'Category', 'Checkout']);
		// error_reporting(0);
	}

	public function index()
	{
		$data['title'] = 'TBHAcademy';

		$data['kategori'] = $this->Category->get_all_category();
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$data['event'] = $this->Event->get_home_event();

		$this->load->view('template/header', $data);
		$this->load->view('guest/home');
	}
	public function courseCategories()
	{
		$condition = (!empty($_POST['category'])) ? ['activity.TYPE_ACTIVITY' => 1, 'course.KATEGORI' => $_POST['category']] : ['activity.TYPE_ACTIVITY' => 1];
		$data['course'] = $this->Course->get_home_course($condition);
		$this->load->view('guest/home_course', $data);
	}
	public function test()
	{
		$path = base_url('assets/images/certificate_template.jpg');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$getImage = file_get_contents($path);
		$data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage);

		$data['NO_SERTIF'] = "14/CRS/TBH/X/2022";
		$data['NAME'] = "USR_ZDNFc02";
		$data['ACTIVITY'] = "ACT_CRS130";

		$this->load->view("pdf_template/sertifikat", $data);
	}
	public function send_message_to_email()
	{
		$this->load->library('phpmailer');

		$admin_to = 'panjidia995@gmail.com';
		$email_sender 	= $_POST['email'];
		$name 	= $_POST['nama'];
		if (!empty($_POST['telp'])) {
			$telp = `Silakan hubungi saya di <strong>` . $_POST['telp'] . `</strong> atau langsung balas email ini.`;
		} else {
			$telp = ``;
		}
		$pesan 	= $_POST['pesan'];
		$subject = "Seseorang telah mengirim pesan ke tbh";
		$html = '<html><head><title>Perkenalkan nama saya ' . $name . ' - Mari Bertemu dan Berkenalan!</title></head><body><h3>Perkenalkan nama saya ' . $name . '</h3><p>Halo Admin TBH,</p><p>' . $pesan . '</p><p>' . $telp . '</p><p>Semoga harimu menyenangkan!</p><p>Salam hangat,</p><p>' . $name . '</p></body></html>';

		$status = $this->phpmailer->SendMail($admin_to, $email_sender, $subject, $name, $html);
		if ($status == 201) {
			$this->session->set_flashdata('msg_send', "<script> 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: '<p>Send message success</p>'
                    })
                    </script>");
		} else {
			$this->session->set_flashdata('msg_send', "<script> 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'error',
                        title: '<p>Send message error</p>'
                    })
                    </script>");
		}
		redirect('about');
	}
}
