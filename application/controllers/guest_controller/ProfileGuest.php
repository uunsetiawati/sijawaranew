<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class ProfileGuest extends Middleware
{
    public $session_data;
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Profile', 'Course', 'Category', 'Instructor', 'Checkout']);
        $this->load->library('S3Upload', NULL, 'S3');
        // error_reporting(0);
    }

    // Main Page
    public function about()
    {
        $data['title'] = 'About';
        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));
        $this->load->view('template/header', $data);
        $this->load->view('guest/about');
        $this->load->view('template/footer');
    }

    // Profile Settings
    public function index()
    {
        
        $data['page'] = 'guest/profile/personal';

        $data['title'] = 'Personal Data';
        $data['data_personal'] = $this->Profile->get_detail_user($this->session->userdata('ID_USER'));
        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function academic()
    {
        $data['title'] = 'Academic Data';
        $data['page'] = 'guest/profile/academic';
        
        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['academic'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function document()
    {
        $data['title'] = 'Supporting Documents';
        $data['page'] = 'guest/profile/document';
        
        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function password()
    {
        $data['title'] = 'Change Password';
        $data['page'] = 'guest/profile/password';
        
        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function myCourses()
    {
        $data['title'] = 'My Courses';
        $data['page'] = 'guest/profile/mycourses';

        $condition = ['activity.TYPE_ACTIVITY' => 1];
        $data['course'] = [];
        $mycourse = $this->Profile->get_my_product($condition);
        foreach ($mycourse as $item) {
            if ($item['DATA_CHECKING'] == 1) {
                array_push($data['course'], $item);
            }
        }

        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function myEvents()
    {
        $data['title'] = 'My Courses';
        $data['page'] = 'guest/profile/myevents';

        $condition = ['activity.TYPE_ACTIVITY' => 2];
        $data['event'] = [];
        $myevent = $this->Profile->get_my_product($condition);
        foreach ($myevent as $item) {
            if ($item['DATA_CHECKING'] == 1) {
                array_push($data['event'], $item);
            }
        }
        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function myEbook()
    {
        $data['title'] = 'My Courses';
        $data['page'] = 'guest/profile/myebook';
        
        $data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function overview()
    {
        
        $data['title'] = 'Overview';
        $data['page'] = 'guest/profile/overview';

		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));

        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }
    
    public function courses()
    {
        
        $data['title'] = 'Courses';
        $data['page'] = 'guest/profile/courses';

		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
        $data['document'] = $this->Profile->get_user_academic($this->session->userdata('ID_USER'));
        
        $this->load->view('template/header', $data);
        $this->load->view('guest/profile/profile_template');
        $this->load->view('template/footer');
    }

    public function change_academic()
    {
        $id_user = $this->session->userdata('ID_USER');
        $data = array(
            "ID_USER"       => $id_user,
            "UNIV"          => $_POST['univ'],
            "NIM"           => $_POST['nim'],
            "STUDY"         => $_POST['study'],
            "DEGREE"        => $_POST['degree'],
            "SEMESTER"      => $_POST['sem'],
            "IS_GRADUATED"  => ((empty($_POST['sem']) || $_POST['sem'] == 0) ? 1 : 0)
        );

        $this->Profile->update_user_academic($id_user, $data);

        $msg = "<script> 
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: 'Change academic data successfull'
            })
            </script>";

        $this->session->set_flashdata('resp_msg', $msg);
        redirect('profile/academic');
    }
    
    public function change_document()
    {
        try {
            if (!empty($_FILES['file_cv']['name'])) {
                $cv_path = $this->S3->UploadFile($_FILES['file_cv']['name'], $_FILES['file_cv']['tmp_name'], $_FILES['file_cv']['type'], 'instructor_cv');
                $resp = $this->Profile->update_user_academic($this->session->userdata('ID_USER'), ["CV" => $cv_path]);
                $msg = "<script> 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: 'Change cv file successfull'
                })
                </script>";
            }

            if (!empty($_FILES['file_porto']['name'])) {
                $port_path = $this->S3->UploadFile($_FILES['file_porto']['name'], $_FILES['file_porto']['tmp_name'], $_FILES['file_porto']['type'], 'instructor_portofolio');
                $resp = $this->Profile->update_user_academic($this->session->userdata('ID_USER'), ["PORTOFOLIO" => $port_path]);

                $msg = "<script> 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: 'Change portofolio file successfull'
                })
                </script>";
            }

            if (!empty($_FILES['file_cert']['name'][0])) {
                $tmp_cert_path = [];
                for ($i=0; $i < count($_FILES['file_cert']['name']); $i++) { 
                    $cert_path = $this->S3->UploadFile($_FILES['file_cert']['name'][$i], $_FILES['file_cert']['tmp_name'][$i], $_FILES['file_cert']['type'][$i], 'instructor_certificate');
                    array_push($tmp_cert_path, $cert_path);
                }
                $resp = $this->Profile->update_user_academic($this->session->userdata('ID_USER'), ["SERTIFIKAT" => implode(';', $tmp_cert_path)]);

                $msg = "<script> 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: 'Change certificate file successfull'
                })
                </script>";
            }

            if (!empty($_FILES['file_recom']['name'])) {
                $recom_path = $this->S3->UploadFile($_FILES['file_recom']['name'], $_FILES['file_recom']['tmp_name'], $_FILES['file_recom']['type'], 'instructor_recomend_letter');
                $resp = $this->Profile->update_user_academic($this->session->userdata('ID_USER'), ["SURAT_RECOM" => $recom_path]);

                $msg = "<script> 
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: 'Change statement letter file successfull'
                })
                </script>";
            }

            $this->session->set_flashdata('resp_msg', $msg);
            redirect('profile/document');
        } catch (Exception $err) {
            echo $err->getMessage();
        }
    }

    public function update_profile()
    {
        $data_user = array(
            'NAME' => $_POST['name_user'],
            'EMAIL' => $_POST['email'],
            'TELP' => $_POST['no_hp'],
            'JK' => $_POST['jk']
        );

        if (!empty($_FILES['foto_profile']['name'])) {
            $data_user['FOTO_PROFILE']  = $this->S3->UploadImage($_FILES['foto_profile']);
            $this->session->set_userdata(['PICT' => $data_user['FOTO_PROFILE']], NULL, 14400);
        }

        $this->Profile->update_user($data_user, $this->session->userdata('ID_USER'));
        redirect('profile');
    }

	public function apply_asinstructor()
	{
        $id_user = $this->session->userdata('ID_USER');
        $data = array(
            "ID_USER"       => $id_user,
            "STATUS"        => 0
        );

        $this->Instructor->request_instructor($data, $id_user);

        $msg = "<script> 
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: 'Apply as instructor successfully'
            })
            </script>";

        $this->session->set_flashdata('resp_msg', $msg);
        redirect($_GET['location']);
	}
}
