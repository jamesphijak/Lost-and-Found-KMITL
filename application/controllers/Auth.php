<?php

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('tb_user');
    }

    public function register()
    {
        $input = $this->input->post();
        // if(isset($_POST['register'])){
        if(!empty($input)){
            if($this->form_validation->run('auth/register')){
                // $verification_key = md5(rand()); // Email verification
                $encrypted_password = $this->encrypt->encode($this->input->post('password'));
                $value = array(
                    'email' => $this->input->post('email'),
                    'password' => $encrypted_password,
                    'mobile' => $this->input->post('mobile')
                );

                $result = $this->tb_user->create_user($value);
                if($result > 0){   
                    $this->session->set_flashdata('success','สมัครสมาชิกสำเร็จ');
                }else{
                    $this->session->set_flashdata('error','สมัครสมาชิกไม่สำเร็จ');
                }
            } 
        }
        $this->template->setTemplate('สมัครสมาชิก', 'auth/register');
        $this->template->loadTemplate();
    }
    public function login()
    {
        $input = $this->input->post();
        if(!empty($input)){
            if($this->form_validation->run('auth/login')){
            
            }
        }

        $this->template->setTemplate('เข้าสู่ระบบ', 'auth/login');
        $this->template->loadTemplate();
    }

    public function logout(){
        exit('logout');
        $this->template->setTemplate('ออกระบบ', 'auth/logout');
        $this->template->loadTemplate();
    }
}

?>