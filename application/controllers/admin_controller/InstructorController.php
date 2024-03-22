<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class InstructorController extends InstructorMiddleware
{
	public $session_data;
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Instructor', 'Checkout']);
	}

	public function index()
	{
		$data['title'] = 'TBHAcademy';
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$this->load->view('template/header', $data);
		$this->load->view('instructor/home');
		$this->load->view('template/footer');
	}

	public function Instructor()
	{
		$data['title'] = 'Instructor';
		$data['instructor'] = $this->Instructor->get_all_instructor();
		
        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/instructor/v_instructor');
        $this->load->view('admin/template/v_footer');	
	}

	public function Instructor_verify()
	{
		$data['title'] = 'Instructor';
		if ($_POST['type'] == 1) {
			$this->Instructor->accept($_POST['id_user']);
			$this->session->set_flashdata('msg', "Accept user as instructor successfully");
		}else{
			$this->Instructor->reject($_POST['id_user']);
			$this->session->set_flashdata('msg', "Reject user as instructor successfully");			
		}

		redirect('manage/instructor');
		
	}
}