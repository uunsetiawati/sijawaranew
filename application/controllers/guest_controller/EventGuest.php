<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class EventGuest extends CI_Controller
{
	public $session_data;
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Event', 'Course', 'Checkout', 'Certificate']);
		// error_reporting(0);
	}

	// EVENT CONTROLLER
	public function index()
	{
		$data['title'] = 'Event';

		//pagination settings
		$config['base_url'] = base_url('event');
		$config['total_rows'] = count($this->db->get_where('activity', ['TYPE_ACTIVITY' => 2])->result_array());
		$config['per_page'] = "9";
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
		$data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$data['event'] = $this->Event->get_event_pagination($config["per_page"], $data['page']);

		$data["total_data"] = count($this->db->get_where('activity', ['TYPE_ACTIVITY' => 2])->result_array());
		$data["page"] = $data['page'];
		$data["per_page"] = $config["per_page"];

		$data['pagination'] = $this->pagination->create_links();

		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$this->load->view('template/header', $data);
		$this->load->view('guest/event/event');
		$this->load->view('template/footer');
	}
	public function detailEvent()
	{
		$data['title'] = 'Event';

		$id_activity = $_GET['id_activity'];
		$data['event'] = $this->Event->get_event($id_activity);
		$data['other_event'] = $this->Event->get_other_event($id_activity);

		$con = ['ID_USER' => $this->session->userdata('ID_USER'), 'ID_ACTIVITY' => $id_activity];
        $sertifCheck = $this->Certificate->getCertificate($con);
		if (!empty($data['event']['DATA_CHECKING']) && empty($sertifCheck)) {
			$bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
			$sertif_number = $data['event']['ID_EVENT'] . '/' . (($data['event']['TYPE_ACTIVITY'] == 1) ? 'CRS' : 'EVT') . '/TBH/' . $bln[(date('m', strtotime($data['event']['DATE_START'])) - 1)] . '/' . date('Y');
			$sertif_path = $this->Certificate->generate($this->session->userdata('NAME'), $data['event']['TITLE_ACTIVITY'], $sertif_number);
			$data_sertif = array(
				"ID_USER" => $this->session->userdata('ID_USER'),
				"ID_ACTIVITY" => $id_activity,
				"NO_SERTIFIKAT" => $sertif_number,
				"JENIS_SERTIFIKAT" => $data['event']['TYPE_ACTIVITY'],
				"FILE_SERTIFIKAT" => $sertif_path,
				"LOG_TIME" => date('Y-m-d H:i:s')
			);
			$this->Certificate->createCertificate($data_sertif);

			$data['sertif'] = $this->Certificate->getCertificate($data_sertif);
		}else{
			$data['sertif'] = $sertifCheck;
		}
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$this->load->view('template/header', $data);
		$this->load->view('guest/event/event_detail');
		$this->load->view('template/footer');
	}
	public function searchEvent()
	{
		$keyword = $_GET['keyword'];
		$data['data_search'] = $this->Event->get_event_by_id($keyword, 2);
		$this->load->view('guest/event/ajax/item_search', $data);
	}
	// END EVENT CONTROLLER
}
