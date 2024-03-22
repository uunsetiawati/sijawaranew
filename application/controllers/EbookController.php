<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class EbookController extends CI_Controller {
    public function index()
    {
        $data['title'] = "Ebook";
        $this->load->view('template/header', $data);
		$this->load->view('guest/ebook/ebook');
		$this->load->view('template/footer');
    }

    public function listEbook()
    {
        $data['title'] = "List E-Book";
        $this->load->view('template/header', $data);
		$this->load->view('guest/ebook/ebook_list');
		$this->load->view('template/footer');
    }
}
?>
