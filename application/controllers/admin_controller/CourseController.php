<?php

defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class CourseController extends InstructorMiddleware
{
    public $session_data;
    public $id_detailCousre = 0;
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Course', 'Category']);
        $this->load->library('S3Upload', NULL, 'S3');
        $this->session_data = $this->session->userdata();
    }

    public function index()
    {
        $data['title'] = "Course";

        if ($this->session_data['ID_ROLE'] == 1) {
            $data['course'] = $this->Course->get_all_course();
        }else {
            $data['course'] = $this->Course->get_all_course_in($this->session_data['ID_USER']);
        }

        $this->load->view('admin/template/v_header', $data);
        $this->load->view('admin/activity/course/v_course');
        $this->load->view('admin/template/v_footer');
    }

    public function add_course()
    {
        $data['title'] = "Course";
        $data['kategori'] = $this->Category->get_all_category();

        $config = array(
            array('field' => 'title', 'label' => 'title', 'rules' => 'required'),
            array('field' => 'price', 'label' => 'price', 'rules' => 'required'),
            array('field' => 'date_start', 'label' => 'date start', 'rules' => 'required'),
            array('field' => 'date_end', 'label' => 'date end', 'rules' => 'required'),
            array('field' => 'desc', 'label' => 'deskripsi', 'rules' => 'required'),
            array('field' => 'desc_item', 'label' => 'deskripsi', 'rules' => 'required'),
            array('field' => 'category', 'label' => 'category', 'rules' => 'required'),
            array('field' => 'code_sertif', 'label' => 'certificate code', 'rules' => 'required')
        );
        
        if (empty($_POST['order_list'])) {
            array_push(
                $config,
                array('field' => 'order_list', 'label' => 'item course', 'rules' => 'required', 'errors' => array(
                    'required' => 'add item course at least one item.',
                ))
            );
        }

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $data_activity = array(
                'ID_ACTIVITY' => $this->GenerateUniqID($_POST['title']),
                'TITLE_ACTIVITY' => $_POST['title'],
                'ID_USER' => $this->session_data['ID_USER'],
                'PRICE_ACTIVITY' => $_POST['price'],
                'SERTIF_CODE' => strtoupper($_POST['code_sertif']),
                'IMAGE_ACTIVITY' => $this->S3->UploadImage($_FILES['course_cover']),
                'TYPE_ACTIVITY' => 1,
                'DATE_START' => date_format(date_create($_POST['date_start']), 'Y-m-d H:i:s'),
                'DATE_END' => date_format(date_create($_POST['date_end']), 'Y-m-d H:i:s'),
                'LOG_TIME' => date('Y-m-d H:i:s')
            );
            if ($_POST['status'] <> "on") {
                $data_activity['STATUS'] = 0;
            } else {
                $data_activity['STATUS'] = 1;
            }

            $data_course = array(
                'ID_ACTIVITY' => $data_activity['ID_ACTIVITY'],
                'PENGUMUMAN' => $_POST['announcement'],
                'DESKRIPSI_COURSE' => $_POST['desc'],
                'DESKRIPSI_COURSE_ITEM' => $_POST['desc_item'],
                'KATEGORI' => $_POST['category']
            );

            $this->Course->InsertActivity($data_activity);
            $this->Course->InsertCourse($data_course);

            $id_course = $this->db->insert_id();
            $this->insert_item_course($id_course);

            $this->session->set_flashdata('msg', "Insert successfully");
            redirect('manage/activity/course');
        } else {
            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/activity/course/v_add_course');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function update_course($id_activity)
    {
        $data['title'] = "Course";
        $data['kategori'] = $this->Category->get_all_category();

        $config = array(
            array('field' => 'title', 'label' => 'title', 'rules' => 'required'),
            array('field' => 'price', 'label' => 'price', 'rules' => 'required'),
            array('field' => 'date_start', 'label' => 'date start', 'rules' => 'required'),
            array('field' => 'date_end', 'label' => 'date end', 'rules' => 'required'),
            array('field' => 'desc', 'label' => 'description', 'rules' => 'required'),
            array('field' => 'desc_item', 'label' => 'description what to learn', 'rules' => 'required'),
            array('field' => 'category', 'label' => 'category', 'rules' => 'required'),
            array('field' => 'code_sertif', 'label' => 'certificate code', 'rules' => 'required')
        );

        if (empty($_POST['order_list'])) {
            array_push(
                $config,
                array('field' => 'order_list', 'label' => 'item course', 'rules' => 'required', 'errors' => array(
                    'required' => 'add item course at least one item.',
                ))
            );
        }

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $data_activity = array(
                'TITLE_ACTIVITY' => $_POST['title'],
                'ID_USER' => $this->session_data['ID_USER'],
                'PRICE_ACTIVITY' => $_POST['price'],
                'SERTIF_CODE' => strtoupper($_POST['code_sertif']),
                'TYPE_ACTIVITY' => 1,
                'DATE_START' => date_format(date_create($_POST['date_start']), 'Y-m-d H:i:s'),
                'DATE_END' => date_format(date_create($_POST['date_end']), 'Y-m-d H:i:s'),
                'LOG_TIME' => date('Y-m-d H:i:s')
            );

            if (!empty($_FILES['course_cover']['name'])) {
                $data_activity['IMAGE_ACTIVITY'] = $this->S3->UploadImage($_FILES['course_cover']);
            }
            if ($_POST['status'] <> "on") {
                $data_activity['STATUS'] = 0;
            } else {
                $data_activity['STATUS'] = 1;
            }

            $data_course = array(
                'PENGUMUMAN' => $_POST['announcement'],
                'DESKRIPSI_COURSE' => $_POST['desc'],
                'DESKRIPSI_COURSE_ITEM' => $_POST['desc_item'],
                'KATEGORI' => $_POST['category']
            );

            $this->Course->UpdateActivity($data_activity, $id_activity);
            $this->Course->UpdateCourse($data_course, $id_activity);

            $dataCourse = $this->Course->get_course($id_activity);
            $this->insert_item_course($dataCourse['ID_COURSE']);

            $this->session->set_flashdata('msg', "Update successfully");
            redirect('manage/activity/course');
        } else {
            $data['course_data'] = $this->Course->get_course($id_activity);
            $data['course_item'] = $this->Course->get_all_materi($data['course_data']['ID_COURSE']);

            (empty($data['course_data'])) ? redirect('manage/activity/event') : '';
            $this->load->view('admin/template/v_header', $data);
            $this->load->view('admin/activity/course/v_update_course');
            $this->load->view('admin/template/v_footer');
        }
    }

    public function delete_course($id_activity)
    {
        $this->Course->DeleteActivity($id_activity);
        $this->Course->DeleteEvent($id_activity);

        $dataCourse = $this->Course->get_course($id_activity);
        $this->Course->DeleteMateri($dataCourse['ID_COURSE']);

        $this->session->set_flashdata('msg', "Delete successfully");
        redirect('manage/activity/course');
    }

    public function insert_item_course($id_course)
    {
        // var_dump($this->Course->get_all_materi($id_course));die;
        if (count($this->Course->get_all_materi($id_course)) > 0) {
            $this->Course->DeleteItem($id_course);
            if (count($this->Course->get_all_quizDetail($id_course)) > 0) {
                $this->Course->DeleteDetailQuiz($id_course);
            }
        }
        if (!empty($_POST['order_list'])) {
            $file_materi = $_FILES['materi_file'];
            $title_materi = $_POST['materi_title'];
            $link_materi = $_POST['materi_link'];
            $desc_materi = $_POST['desc_materi'];
            $order_list = $_POST['order_list'];
            $type = $_POST['type'];

            $id_quiz = array();
            for ($i = 0; $i < count($order_list); $i++) {
                if ($type[$i] == 1) {
                    $data_item = array(
                        'ID_COURSE' => $id_course,
                        'TITLE' => $title_materi[$i],
                        'LINK_YT' => $link_materi[$i],
                        'ORDER_LIST' => $order_list[$i],
                        'DESKRIPSI' => $desc_materi[$i],
                        'TYPE' => $type[$i]
                    );
                    if (!empty($file_materi['name'][$i])) {
                        $data_item['FILE'] = $this->S3->UploadFile($file_materi['name'][$i], $file_materi['tmp_name'][$i], $file_materi['type'][$i], 'file_materi');
                    } else {
                        $old_file = $_POST['old_file'];
                        $data_item['FILE'] = $old_file[$i];
                    }
                    $this->Course->InsertItem($data_item);
                } else {
                    $data_item = array(
                        'ID_COURSE' => $id_course,
                        'ORDER_LIST' => $order_list[$i],
                        'TYPE' => $type[$i]
                    );

                    $id_item = $this->Course->InsertItem($data_item);
                    array_push($id_quiz, $id_item);
                }
            }

            if (!empty($id_quiz)) {
                $this->detail_quiz($id_quiz, $id_course, $order_list);
            }
        }
    }

    public function detail_quiz($id_quiz, $id_course, $total_item)
    {
        $data_question = array();
        if (!empty($_POST['question'])) {
            $question = $_POST['question'];
            $jawaban_a = $_POST['jawaban_a'];
            $jawaban_b = $_POST['jawaban_b'];
            $jawaban_c = $_POST['jawaban_c'];
            $jawaban_d = $_POST['jawaban_d'];
            $kunci_soal = $_POST['kunci_soal_'];
            $list_quiz = $_POST['list_quiz'];
            $order_list_question = $_POST['order_list_question'];

            $question_list = array();
            for ($h = 0; $h < count($total_item); $h++) {
                if (!empty($list_quiz[$h])) {
                    array_push($question_list, array(
                        'SOAL' => $question[$h],
                        'PIL_JWB_A' => $jawaban_a[$h],
                        'PIL_JWB_B' => $jawaban_b[$h],
                        'PIL_JWB_C' => $jawaban_c[$h],
                        'PIL_JWB_D' => $jawaban_d[$h],
                        'KUNCI' => $kunci_soal[$h],
                        'ORDER_LIST' => $order_list_question[$h]
                    ));
                }
            }
            $data_question = array();
            for ($j = 0; $j < count($id_quiz); $j++) {
                for ($i = 0; $i < count($question_list[$j]['ORDER_LIST']); $i++) {
                    array_push(
                        $data_question,
                        array(
                            'ID_QUIZ' => $id_quiz[$j],
                            'ID_COURSE' => $id_course,
                            'SOAL' => $question_list[$j]['SOAL'][$i],
                            'PIL_JWB' => implode(',', [$question_list[$j]['PIL_JWB_A'][$i], $question_list[$j]['PIL_JWB_B'][$i], $question_list[$j]['PIL_JWB_C'][$i],$question_list[$j]['PIL_JWB_D'][$i]]),
                            'KUNCI' => $question_list[$j]['KUNCI'][$i],
                            'ORDER_LIST' => $question_list[$j]['ORDER_LIST'][$i]
                        )
                    );
                }
            }
            for ($k = 0; $k < count($data_question); $k++) {
                $this->Course->InsertQuizDetail($data_question[$k]);
            }
        }
    }

    public function add_course_materi($i)
    {
        $this->id_detailCousre += $i;
        $data['no'] = $this->id_detailCousre;
        $this->load->view('admin/activity/course/materi/item_materi', $data);
    }

    public function get_course_item()
    {
        $this->id_detailCousre += $_GET['ID_MATERI'];
        $data['id_item'] = $this->id_detailCousre;
        $data['data_materi'] = $this->Course->get_all_materi($_GET['ID_COURSE']);
        $data['no'] = 1;
        foreach ($data['data_materi'] as $item_data) {
            $data['item']['ID_ITEM'] = $item_data['ID_ITEM'];
            if ($item_data['TYPE'] == 1) {
                $data['item'] = array(
                    'FILE' => $item_data['FILE'],
                    'TITLE' => $item_data['TITLE'],
                    'LINK_YT' => $item_data['LINK_YT'],
                    'DESKRIPSI' => $item_data['DESKRIPSI']
                );
                $this->load->view('admin/activity/course/materi/item_materi_update', $data);
            } else {
                $this->load->view('admin/activity/course/quiz/item_quiz_update', $data);
            }
            $data['no']++;
        }
    }

    public function remove_course_materi($i)
    {
        $this->id_detailCousre -= $i;
        $data['id_materi'] = $this->id_detailCousre;
    }

    public function add_course_quiz($i)
    {
        $this->id_detailCousre += $i;
        $data['no'] = $this->id_detailCousre;
        $this->load->view('admin/activity/course/quiz/item_quiz', $data);
    }

    public function add_quiz_question()
    {
        $data['id_quiz'] = $_GET['id_quiz'];
        $data['no'] = $_GET['id_question'];
        $this->load->view('admin/activity/course/quiz/item_question', $data);
    }

    public function get_quiz_question()
    {
        $data['id_quiz'] = $_GET['id_quiz'];
        $data['no'] = (int)$_GET['id_question'];

        $data['data_question'] = $this->Course->get_all_question($_GET['id_item']);
        foreach ($data['data_question'] as $item_data) {
            $data['item'] = array(
                'SOAL' => $item_data['SOAL'],
                'PIL_JWB' => explode(',', $item_data['PIL_JWB']),
                'KUNCI' => $item_data['KUNCI'],
                'ORDER_LIST' => $item_data['ORDER_LIST']
            );
            $data['no']++;
            $this->load->view('admin/activity/course/quiz/item_question_update', $data);
        }
    }

    public function get_total_question()
    {
        $data['id_quiz'] = $_GET['id_quiz'];
        $data['no'] = (int)$_GET['id_question'];

        $data['data_question'] = $this->Course->get_all_question($_GET['id_item']);
        echo count($data['data_question']);
    }

    public function remove_course_quiz($i)
    {
        $this->id_detailCousre -= $i;
        $data['id_quiz'] = $this->id_detailCousre;
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
