<?php

defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class UserController extends AdminMiddleware
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User');
        $this->load->library('S3Upload', NULL, 'S3');
        $this->session_data = $this->session->userdata();
        if ($this->session_data == null) {
            redirect('manage/login');
        }
    }

    public function ManageUser()
    {
        $data['title'] = "User";
        $data['user'] = $this->User->get_all_user();
        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/user/v_user');
        $this->load->view('admin/template/v_footer');
    }

    public function add_user()
    {
        $data['title'] = 'User';

        $config = array(
            array('field' => 'name', 'label' => 'Email_U', 'rules' => 'required'),
            array('field' => 'jk', 'label' => 'Nama_U', 'rules' => 'required'),
            array('field' => 'email', 'label' => 'Nama_U', 'rules' => 'required'),
            array('field' => 'no_hp', 'label' => 'Nama_U', 'rules' => 'required'),
            array('field' => 'password', 'label' => 'Nama_U', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $data_user = array(
                'ID_USER' => $this->GenerateUniqID($_POST['name']),
                'NAME' => $_POST['name'],
                'ID_ROLE' => 2,
                'PASS' => hash('sha256', md5($_POST['password'])),
                'EMAIL' => $_POST['email'],
                'TELP' => $_POST['no_hp'],
                'JK' => $_POST['jk'],
                'STATUS' => 1,
                'FOTO_PROFILE' => $this->S3->UploadImage($_FILES['foto_profile'])
            );

            if (!empty($_FILES['cv']['name'])) {
                $data_user['CV']  = $this->S3->UploadFile($_FILES['cv']['name'], $_FILES['cv']['tmp_name']);
            }

            if (!empty($_FILES['portofolio']['name'])) {
                $data_user['PORTOFOLIO']  = $this->S3->UploadFile($_FILES['portofolio']['name'], $_FILES['portofolio']['tmp_name']);
            }

            if (!empty($_FILES['sertifikat']['name'])) {
                $data_user['SERTIFIKAT']  = $this->S3->UploadFile($_FILES['sertifikat']['name'], $_FILES['sertifikat']['tmp_name']);
            }

            if (!empty($_FILES['surat_recom']['name'])) {
                $data_user['SURAT_RECOM']  = $this->S3->UploadFile($_FILES['surat_recom']['name'], $_FILES['surat_recom']['tmp_name']);
            }

            $this->db->insert('user', $data_user);
            
            $this->session->set_flashdata('msg', "Insert successfully");
            redirect('manage/user');
        } else {
            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/user/v_add_user');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function update_user($id_user)
    {
        $data['title'] = 'User';

        $config = array(
            array('field' => 'name', 'label' => 'Email_U', 'rules' => 'required'),
            array('field' => 'jk', 'label' => 'Nama_U', 'rules' => 'required'),
            array('field' => 'email', 'label' => 'Nama_U', 'rules' => 'required'),
            array('field' => 'no_hp', 'label' => 'Nama_U', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $data_user = array(
                'ID_USER' => $this->GenerateUniqID($_POST['name']),
                'NAME' => $_POST['name'],
                'ID_ROLE' => 2,
                'EMAIL' => $_POST['email'],
                'TELP' => $_POST['no_hp'],
                'JK' => $_POST['jk']
            );

            if (!empty($_FILES['foto_profile']['name'])) {
                $data_user['FOTO_PROFILE']  = $this->S3->UploadImage($_FILES['foto_profile']);
            }            

            if (!empty($_FILES['cv']['name'])) {
                $data_user['CV']  = $this->S3->UploadFile($_FILES['cv']['name'], $_FILES['cv']['tmp_name']);
            }

            if (!empty($_FILES['portofolio']['name'])) {
                $data_user['PORTOFOLIO']  = $this->S3->UploadFile($_FILES['portofolio']['name'], $_FILES['portofolio']['tmp_name']);
            }

            if (!empty($_FILES['sertifikat']['name'])) {
                $data_user['SERTIFIKAT']  = $this->S3->UploadFile($_FILES['sertifikat']['name'], $_FILES['sertifikat']['tmp_name']);
            }

            if (!empty($_FILES['surat_recom']['name'])) {
                $data_user['SURAT_RECOM']  = $this->S3->UploadFile($_FILES['surat_recom']['name'], $_FILES['surat_recom']['tmp_name']);
            }

            if(!empty($_POST['password'])){
                $data_user['PASS'] = hash('sha256', md5($_POST['password']));
            }

            $this->User->update_user($data_user, $id_user);
            $this->session->set_flashdata('msg', "Update successfully");
            redirect('manage/user');
        } else {
            $data['user_data'] = $this->User->user_ini($id_user);
            
            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/user/v_update_user');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function delete_user($id)
    {
        $this->User->hapus_user($id);
        $this->session->set_flashdata('delete_user', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fa fa-check"></i>User Berhasil dihapus</div>');
        redirect('manage/user');
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
}
