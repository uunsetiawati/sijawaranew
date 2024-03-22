<?php

defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class EventController extends InstructorMiddleware
{
    public $session_data;
    public $id_materi = 1;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Event');
        $this->load->library('S3Upload', NULL, 'S3');
        $this->session_data = $this->session->userdata();
        // error_reporting(0);
    }

    public function index()
    {
        $data['title'] = "Event";

        if ($this->session_data['ID_ROLE'] == 1) {
            $data['event'] = $this->Event->get_all_event();
        }else {
            $data['event'] = $this->Event->get_all_event_in($this->session_data['ID_USER']);
        }
        
        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/activity/event/v_event');
        $this->load->view('admin/template/v_footer');
    }

    public function add_event()
    {
        $data['title'] = "Event";

        $config = array(
            array('field' => 'title', 'label' => 'title', 'rules' => 'required'),
            array('field' => 'price', 'label' => 'price', 'rules' => 'required'),
            array('field' => 'date_start', 'label' => 'date start', 'rules' => 'required'),
            array('field' => 'category', 'label' => 'category', 'rules' => 'required'),
            array('field' => 'organizer', 'label' => 'organizer', 'rules' => 'required'),
            array('field' => 'location', 'label' => 'event location', 'rules' => 'required'),
            array('field' => 'contact', 'label' => 'contact person', 'rules' => 'required'),
            array('field' => 'code_sertif', 'label' => 'certificate code', 'rules' => 'required')
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $data_activity = array(
                'ID_ACTIVITY' => $this->GenerateUniqID($_POST['title']),
                'TITLE_ACTIVITY' => $_POST['title'],
                'ID_USER' => $this->session_data['ID_USER'],
                'PRICE_ACTIVITY' => $_POST['price'],
                'SERTIF_CODE' => strtoupper($_POST['code_sertif']),
                'IMAGE_ACTIVITY' => $this->S3->UploadImage($_FILES['cover']),
                'TYPE_ACTIVITY' => 2,
                'DATE_START' => date_format(date_create($_POST['date_start']), 'Y-m-d H:i:s'),
                'LOG_TIME' => date('Y-m-d H:i:s')
            );
            if ($_POST['status'] <> "on") {
                $data_activity['STATUS'] = 0;
            } else {
                $data_activity['STATUS'] = 1;
            }

            $data_course = array(
                'ID_ACTIVITY'       => $data_activity['ID_ACTIVITY'],
                'CATEGORY_EVENT'    => $_POST['category'],
                'LOCATION'          => $_POST['location'],
                'ORGANIZER'         => $_POST['organizer'],
                'CONTACT_CUSTOMER'  => $_POST['contact'],
                'DESKRIPSI_EVENT'   => $_POST['desc'],
                'LINK_ZOOM'         => $_POST['link']
            );

            $this->Event->InsertActivity($data_activity);
            $this->Event->InsertEvent($data_course);

            $this->session->set_flashdata('msg', "Insert successfully");
            redirect('manage/activity/event');
        } else {
            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/activity/event/v_add_event');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function update_event($id_event)
    {
        $data['title'] = "Event";

        $config = array(
            array('field' => 'title', 'label' => 'title', 'rules' => 'required'),
            array('field' => 'price', 'label' => 'price', 'rules' => 'required'),
            array('field' => 'date_start', 'label' => 'date start', 'rules' => 'required'),
            array('field' => 'category', 'label' => 'category', 'rules' => 'required'),
            array('field' => 'organizer', 'label' => 'organizer', 'rules' => 'required'),
            array('field' => 'location', 'label' => 'event location', 'rules' => 'required'),
            array('field' => 'contact', 'label' => 'contact person', 'rules' => 'required'),
            array('field' => 'code_sertif', 'label' => 'certificate code', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $data_activity = array(
                'ID_ACTIVITY' => $this->GenerateUniqID($_POST['title']),
                'TITLE_ACTIVITY' => $_POST['title'],
                'ID_USER' => $this->session_data['ID_USER'],
                'PRICE_ACTIVITY' => $_POST['price'],
                'SERTIF_CODE' => strtoupper($_POST['code_sertif']),
                'TYPE_ACTIVITY' => 2,
                'DATE_START' => date_format(date_create($_POST['date_start']), 'Y-m-d H:i:s'),
                'LOG_TIME' => date('Y-m-d H:i:s')
            );

            if (!empty($_FILES['cover']['name'])) {
                $data_activity['IMAGE_ACTIVITY']  = $this->S3->UploadImage($_FILES['cover']);
            }
            if ($_POST['status'] <> "on") {
                $data_activity['STATUS'] = 0;
            } else {
                $data_activity['STATUS'] = 1;
            }

            $data_course = array(
                'ID_ACTIVITY'       => $data_activity['ID_ACTIVITY'],
                'CATEGORY_EVENT'    => $_POST['category'],
                'LOCATION'          => $_POST['location'],
                'ORGANIZER'         => $_POST['organizer'],
                'CONTACT_CUSTOMER'  => $_POST['contact'],
                'DESKRIPSI_EVENT'   => $_POST['desc'],
                'LINK_ZOOM'         => $_POST['link']
            );

            $this->Event->UpdateActivity($data_activity, $id_event);
            $this->Event->UpdateEvent($data_course, $id_event);

            $this->session->set_flashdata('msg', "Update successfully");
            redirect('manage/activity/event');
        } else {
            $data['event_data'] = $this->Event->get_event($id_event);

            (empty($data['event_data'])) ? redirect('manage/activity/event') : '';
            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/activity/event/v_update_event');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function delete_event($id_event)
    {
        $this->Event->DeleteActivity($id_event);
        $this->Event->DeleteEvent($id_event);

        $this->session->set_flashdata('msg', "Delete successfully");
        redirect('manage/activity/event');
    }

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "ACT_" . $uniqid . substr(md5(time()), 0, 3);
    }
}
