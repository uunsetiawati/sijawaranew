<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Middleware extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_auth();
    }

    private function check_auth() {
        if (empty($this->session->userdata('ID_USER'))) {
            redirect('login');
        }
    }
}

class InstructorMiddleware extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_auth();
    }

    private function check_auth() {
        if (empty($this->session->userdata('ID_USER'))) {
            redirect('login');
        } else if (!empty($this->session->userdata('ID_ROLE')) && $this->session->userdata('ID_ROLE') == 3) {
            redirect('');
        }
    }
}

class AdminMiddleware extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_auth();
    }

    private function check_auth() {
        if (empty($this->session->userdata('ID_USER'))) {
            redirect('login');
        } else if (!empty($this->session->userdata('ID_ROLE')) && $this->session->userdata('ID_ROLE') == 3 && $this->session->userdata('ID_ROLE') == 2) {
            redirect('');
        }
    }
}
