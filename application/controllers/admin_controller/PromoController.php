<?php

defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class PromoController extends AdminMiddleware
{
    public $session_data;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Promo');
        $this->session_data = $this->session->userdata();
        if ($this->session_data == null  ||  $this->session_data['ID_ROLE'] <> 1) {
            redirect('');
        }
        // error_reporting(0);
    }

    public function index()
    {
        $data['title'] = "Promo";
        $data['promo'] = $this->Promo->get_all_promo();
        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/promo/v_promo');
        $this->load->view('admin/template/v_footer');
    }

    public function add_promo()
    {   
        $promo_name = $_POST['promo-title'];
        $promo_ammount = $_POST['promo-ammount'];
        $promo_exp = $_POST['promo-exp'];

        (empty($promo_name) ? redirect('manage/promo') : '');

        $data = array(
            'PROMO_NAME' => $promo_name,
            'AMMOUNT' => $promo_ammount,
            'EXP_DATE' => $promo_exp,
            'LOG_TIME' => date('Y-m-d H:i:s')
        );
        $this->Promo->InsertPromo($data);
        $this->session->set_flashdata('msg', "Insert Successfully");
        redirect('manage/promo');
    }

    public function update_promo()
    {
        $id = $_POST['promo-id'];
        
        (empty($id) ? redirect('manage/promo') : '');
        
        $promo_name = $_POST['promo-title'];
        $promo_ammount = $_POST['promo-ammount'];
        $promo_exp = $_POST['promo-exp'];
        $data = array(
            'PROMO_NAME' => $promo_name,
            'AMMOUNT' => $promo_ammount,
            'EXP_DATE' => $promo_exp,
            'LOG_TIME' => date('Y-m-d H:i:s')
        );
        $this->Promo->UpdatePromo($data, $id);
        $this->session->set_flashdata('msg', "Update Successfully");
        redirect('manage/promo');
    }
    
    public function delete_promo()
    {
        $id = $_POST['promo-id'];

        (empty($id) ? redirect('manage/promo') : '');

        $this->Promo->DeletePromo($id);
        $this->session->set_flashdata('msg', "Delete Successfully");
        redirect('manage/promo');
    }
}