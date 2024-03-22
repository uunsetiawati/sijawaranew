<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class CourseGuest extends CI_Controller
{
	public $session_data;
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Event', 'Course', 'Checkout', 'Category', 'Certificate']);
		// error_reporting(0);
	}

	// COURSE CONTROLLER
	public function index()
	{
		$data['title'] = 'Course';
		$data['kategori'] = $this->Category->get_all_category();
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$this->load->view('template/header', $data);
		$this->load->view('guest/course/course');
		$this->load->view('template/footer');
	}
	public function detailCourse()
	{
		($this->session->userdata('ID_USER') == null) ? redirect('login') : "";
		$data['title'] = 'Course';
		
		$data['id_activity'] = $_GET['id_activity'];
		$data['course'] = $this->Course->get_course($data['id_activity']);
		// ($data['course']['DATA_CHECKING'] != 1) ? redirect('login') : "";

		$this->Course->updateMappingIndex($data['course']['ID_COURSE'], $data['id_activity']);
		$condition_course = ["ID_COURSE" => $data['course']['ID_COURSE'], "ID_USER" => $this->session->userdata('ID_USER')];
		$data['item_course'] = $this->Course->get_item_course($condition_course);
		$last_item = $this->Course->get_last_item_course($data['id_activity'], '');
		$data['last_item'] = $last_item[0]['ID_ITEM'];
		
		$condition_all_mapping = array(
			"ID_USER" => $this->session->userdata('ID_USER'),
			"ID_ACTIVITY" => $data['id_activity']
		);
		$data_all_mapping = $this->Course->get_all_mapping($condition_all_mapping);
		$tot_proggress = (!empty($data['item_course'])) ? (((int)$data_all_mapping['MAPPING_COUNT']) / count($data['item_course'])) * 100 : 0;
		$tot_proggress_view = (!empty($data['item_course'])) ? (((int)$data_all_mapping['MAPPING_COUNT'] - 1) / count($data['item_course'])) * 100 : 0;
		$data['data_all_mapping'] = $data_all_mapping;
		$data['tot_proggress'] = $tot_proggress;
		$data['tot_proggress_view'] = $tot_proggress_view;

		// Generate Sertifikat
		$con = ['ID_USER' => $this->session->userdata('ID_USER'), 'ID_ACTIVITY' => $data['id_activity']];
		$sertifCheck = $this->Certificate->getCertificate($con);
		if ($data['data_all_mapping']['COURSE_COMPLETED'] == 1 && empty($sertifCheck)) {
			$bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
			$sertif_number = $data['course']['ID_COURSE'] . '/' . (($data['course']['TYPE_ACTIVITY'] == 1) ? 'CRS' : 'EVT') . '/TBH/' . $bln[(date('m', strtotime($data['course']['DATE_START'])) - 1)] . '/' . date('Y');
			$sertif_path = $this->Certificate->generate($this->session->userdata('NAME'), $data['course']['TITLE_ACTIVITY'], $sertif_number);

			$data_sertif = array(
				"ID_USER" => $this->session->userdata('ID_USER'),
				"ID_ACTIVITY" => $data['id_activity'],
				"NO_SERTIFIKAT" => $sertif_number,
				"JENIS_SERTIFIKAT" => $data['course']['TYPE_ACTIVITY'],
				"FILE_SERTIFIKAT" => $sertif_path,
				"LOG_TIME" => date('Y-m-d H:i:s')
			);
			$this->Certificate->createCertificate($data_sertif);

			$data['sertif'] = $this->Certificate->getCertificate($data_sertif);
		} else {
			$data['sertif'] = $sertifCheck;
		}

		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$this->load->view('template/header', $data);
		$this->load->view('guest/course/course_detail');
		$this->load->view('template/footer');
	}
	public function getDetailItemCourse()
	{
		$data['id_item'] = $_POST['id_item'];
		$data['type'] = $_POST['type'];
		$data['status'] = $_POST['status'];
		$data['id_activity'] = $_POST['id_activity'];
		if ($data['type'] == 3) {
			$data['type'] = 2;
			$this->Course->DeleteQuizPenilaian(['ID_QUIZ' => $data['id_item'], 'ID_USER' => $this->session->userdata('ID_USER')]);
		} else {
			$data['type'] = $_POST['type'];
		}

		$condition_all_mapping = array(
			"ID_USER" => $this->session->userdata('ID_USER'),
			"ID_ACTIVITY" => $_POST['id_activity']
		);
		$data['data_all_mapping'] = $this->Course->get_all_mapping($condition_all_mapping);
		if ($data['status'] == 2) {
			$condition_update_mapping = array(
				"ID_USER" => $this->session->userdata('ID_USER'),
				"ID_PRODUCT" => $_POST['id_activity']
			);
			$this->Course->UpdateMapping($condition_update_mapping);
		}

		$data['last_item'] = $this->Course->get_last_item_course($_POST['id_activity'], $data['id_item'])[0];
		$data['tot_proggress'] = $_POST['progress'];
		$data['COURSE_COMPLETED'] = $_POST['COURSE_COMPLETED'];

		$condition = ['item_course.ID_ITEM' => $data['id_item']];
		$data['detail_item_course'] = $this->Course->get_detail_item_course($condition, $data['type']);
		$data['quiz_grade'] = $this->Course->get_quiz_grade($data['id_item']);
		$this->load->view('guest/course/ajax/detail_item', $data);
	}
	public function infoCourse()
	{
		$data['title'] = 'Course';

		$id_activity = $_GET['id_activity'];
		$data['checking_trans'] = $this->Checkout->get_trans($this->session->userdata('ID_USER'));
		$data['course'] = $this->Course->get_course($id_activity);

		$condition = ["ID_COURSE" => $data['course']['ID_COURSE']];
		$data_itemCourse = $this->Course->get_item_course($condition);

		$data['item_course'] = array();
		$data['total_item'] = array(
			'materi' => 0,
			'quiz' => 0
		);
		foreach ($data_itemCourse as $item) {
			if ($item['TYPE'] == 1) {
				array_push(
					$data['item_course'],
					$item
				);
				$data['total_item']['materi']++;
			} else {
				$data['total_item']['quiz']++;
			}
		}

		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$this->load->view('template/header', $data);
		$this->load->view('guest/course/course_info');
		$this->load->view('template/footer');
	}
	public function QuizEvaluation()
	{
		$id_quiz = $_POST['id_quiz'];
		$id_detail = $_POST['id_detail'];
		$pilih_jwbn = $_POST['pilih_jwbn'];

		$jml_jwbn_benar = 0;
		for ($i = 0; $i < count($id_detail); $i++) {
			$jml_jwbn_benar += $this->Course->get_correct_answer_item_course($id_detail[$i], $pilih_jwbn[$i]);
		}

		$nilai = ($jml_jwbn_benar / count($id_detail)) * 100;

		$this->Course->save_quiz_grade($id_quiz, $nilai);
		echo $nilai;
	}
	public function searchCourse()
	{
		$keyword = $_GET['keyword'];
		$data['data_search'] = $this->Course->get_course_by_id($keyword, 1);
		$this->load->view('guest/course/ajax/item_search', $data);
	}
	public function getFilterByKat()
	{
		//pagination settings
		$config['base_url'] = base_url('course/category');
		$config['total_rows'] = count($this->db->get_where('activity', ['TYPE_ACTIVITY' => 1])->result_array());
		$config['per_page'] = count($this->db->get_where('activity', ['TYPE_ACTIVITY' => 1])->result_array());
		$config["uri_segment"] = 2;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = floor($choice);

		//config for bootstrap pagination class integration
		$config['full_tag_open'] = '<ul class=" pagination m-0">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<li class="page-item"><div class="page-link text-dark" style="border-radius: 5px 0px 0px 5px !important">Previous</div></li>';
		$config['prev_tag_open'] = false;
		$config['prev_tag_close'] = false;
		$config['next_link'] = '<li class="page-item"><div class="page-link text-dark" style="border-radius: 0px 5px 5px 0px !important">Next</div></li>';
		$config['next_tag_open'] = false;
		$config['next_tag_close'] = false;
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item"><div class="page-link">';
		$config['cur_tag_close'] = '</div></li>';
		$config['num_tag_open'] = '<li class="page-item"><div class="page-link">';
		$config['num_tag_close'] = '</div></li>';

		$this->pagination->initialize($config);
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$condition = (!empty($_POST['category'])) ? ['activity.TYPE_ACTIVITY' => 1, 'course.KATEGORI' => $_POST['category']] : ['activity.TYPE_ACTIVITY' => 1];
		$data['course'] = $this->Course->get_course_pagination($config["per_page"], $data['page'], $condition);

		$data["total_data"] = count($this->db->get_where('activity', ['TYPE_ACTIVITY' => 1])->result_array());
		$data["page"] = $data['page'];
		$data["per_page"] = $config["per_page"];

		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('guest/course/ajax/course_by_category', $data);
	}
	public function Finish()
	{
		$condition_update = array(
			"ID_USER" => $this->session->userdata('ID_USER'),
			"ID_PRODUCT" => $_POST['id_activity']
		);
		$this->Course->UpdateCourseFinish($condition_update);
	}
	// END COURSE CONTROLLER
	// public function getMappingCourse()
	// {
	// 	$condition_all_mapping = array(
	// 		"ID_USER" => $this->session->userdata('ID_USER'),
	// 		"ID_ACTIVITY" => $_POST['id_activity']
	// 	);
	// 	$data_all_mapping = $this->Course->get_all_mapping($condition_all_mapping);
	// 	echo json_encode($data_all_mapping);
	// }
}
