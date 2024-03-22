<?php

defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class EbookController extends AdminMiddleware
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ebook');
        $this->load->library('S3Upload', NULL, 'S3');
        $this->session_data = $this->session->userdata();
        if ($this->session_data == null  ||  $this->session_data['ID_ROLE'] == 2 || $this->session_data['ID_ROLE'] == null) {
            redirect('');
        }
    }

    public function index()
    {
        $data['title'] = "Ebook";

        if ($this->session_data['ID_ROLE'] == 1) {
            $data['ebook'] = $this->Ebook->get_all_book();
        }else {
            $data['ebook'] = $this->Ebook->get_all_book_in($this->session_data['ID_USER']);
        }
        
        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/ebook/v_ebook');
        $this->load->view('admin/template/v_footer');
    }

    public function prev_book($id)
    {
        $data['ebook_prev'] = $this->Ebook->get_book_by_id($id);

        foreach ($data as $key) {
            echo $key['LINK_EBOOK'];
        }
    }

    public function add_book()
    {   
        $data['title'] = 'Ebook';

        $config = array(
            array('field' => 'judul', 'label' => 'judul_buku', 'rules' => 'required'),
            array('field' => 'genre', 'label' => 'genre_buku', 'rules' => 'required'),
            array('field' => 'author', 'label' => 'author_buku', 'rules' => 'required'),
            array('field' => 'tahun', 'label' => 'tahun_buku', 'rules' => 'required'),
            array('field' => 'link', 'label' => 'link_buku', 'rules' => 'required'),
            array('field' => 'price', 'label' => 'price_buku', 'rules' => 'required')
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {

            $data_buku = array(
                'ID_BUKU' => $this->GenerateUniqID($_POST['judul']),
                'IMAGE_EBOOK' => $this->S3->UploadImage($_FILES['cover']),
                'JUDUL' => $_POST['judul'],
                'GENRE' => $_POST['genre'],
                'AUTHOR' => $_POST['author'],
                'TAHUN' => $_POST['tahun'],
                'LINK_EBOOK' => $_POST['link'],
                'PRICE' => $_POST['price'],
                'LOG_TIME' => date('Y-m-d H:i:s'),
                'ID_USER' => $this->session_data['ID_USER']
            );

            $this->Ebook->InsertEbook($data_buku);

            $this->session->set_flashdata('msg', "Insert successfully");
            redirect('manage/ebook');
        } else {
            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/ebook/v_add_book');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function update_book($id_buku)
    {
        $data['title'] = "Ebook";

        $config = array(
            array('field' => 'judul', 'label' => 'judul_buku', 'rules' => 'required'),
            array('field' => 'genre', 'label' => 'genre_buku', 'rules' => 'required'),
            array('field' => 'author', 'label' => 'author_buku', 'rules' => 'required'),
            array('field' => 'tahun', 'label' => 'tahun_buku', 'rules' => 'required'),
            array('field' => 'price', 'label' => 'price_buku', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $data_ebook = array(
                'ID_BUKU' => $this->GenerateUniqID($_POST['judul']),
                'JUDUL' => $_POST['judul'],
                'GENRE' => $_POST['genre'],
                'AUTHOR' => $_POST['author'],
                'TAHUN' => $_POST['tahun'],
                'PRICE' => $_POST['price'],
                'LOG_TIME' => date('Y-m-d H:i:s')
            );

            if (!empty($_POST['link'])) {
                $data_ebook['LINK_EBOOK']  =  $_POST['link'];
            }

            if (!empty($_FILES['cover']['name'])) {
                $data_ebook['IMAGE_EBOOK']  = $this->S3->UploadImage($_FILES['cover']);
            }

            $this->Ebook->UpdateEbook($data_ebook, $id_buku);

            $this->session->set_flashdata('msg', "Update successfully");
            redirect('manage/ebook');
        } else {
            $data['data_buku'] = $this->Ebook->get_book_by_id($id_buku);

            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/ebook/v_update_book');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function delete_book($id_buku)
    {
        $this->Ebook->DeleteEbook($id_buku);

        redirect('manage/ebook');
    }

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "EBK_" . $uniqid . substr(md5(time()), 0, 3);
    }
}
