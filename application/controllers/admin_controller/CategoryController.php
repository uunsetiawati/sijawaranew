<?php

defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class CategoryController extends AdminMiddleware
{
    public $session_data;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Category');
        $this->session_data = $this->session->userdata();
        if ($this->session_data == null ||  $this->session_data['ID_ROLE'] <> 1) {
            redirect('');
        }
        // error_reporting(0);
    }

    public function index()
    {
        $data['title'] = "Category";

        $data['kategori'] = $this->Category->get_all_category();

        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/category/v_category');
        $this->load->view('admin/template/v_footer');
    }

    public function insert_category()
    {
        $category = $_POST['category-title'];

        (empty($category) ? redirect('manage/category') : '');

        $data = array(
            'KATEGORI' => $category
        );
        $this->Category->createCategory($data);
        $this->session->set_flashdata('msg', "Insert Successfully");
        redirect('manage/category');
    }
    
    public function update_category()
    {
        $id = $_POST['category-id'];
        
        (empty($id) ? redirect('manage/category') : '');
        
        $category = $_POST['category-title'];
        $data = array(
            'KATEGORI' => $category
        );
        $this->Category->updateCategory($data, $id);
        $this->session->set_flashdata('msg', "Update Successfully");
        redirect('manage/category');
    }
    
    public function delete_category()
    {
        $id = $_POST['category-id'];

        (empty($id) ? redirect('manage/category') : '');

        $this->Category->deleteCategory($id);
        $this->session->set_flashdata('msg', "Delete Successfully");
        redirect('manage/category');
    }
}
