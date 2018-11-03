<?php

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // สมัครสมาชิก
    public function register()
    {
        $input = $this->input->post();
        // if(isset($_POST['register'])){
        if(!empty($input)){
            if($this->form_validation->run('auth/register')){
                // $verification_key = md5(rand()); // Email verification key
                // $encrypted_password = $this->encrypt->encode($this->input->post('password'));
                // $decrypted_password = $this->encrypt->decode(encrypted_password);
                $encrypted_password = $this->tb_user->hash($this->input->post('password'));
                $value = array(
                    'email' => $this->input->post('email'),
                    'password' => $encrypted_password,
                    'mobile' => $this->input->post('mobile')
                );

                $result = $this->tb_user->user_register($value);
                if($result){   
                    $this->session->set_flashdata('success','สมัครสมาชิกสำเร็จ');
                    redirect(base_url('auth/register'),'refresh');
                }else{
                    $this->session->set_flashdata('error','สมัครสมาชิกไม่สำเร็จ');
                }
            }
        }

        $this->tb_user->already_login();
        $this->template->setTemplate('สมัครสมาชิก', 'auth/register');
        $this->template->loadTemplate();
    }
    
    public function login()
    {
        $input = $this->input->post();
        if(!empty($input)){
            if($this->form_validation->run('auth/login')){

                $encrypted_password = $this->tb_user->hash($this->input->post('password'));
                $value = array(
                    'email' => $this->input->post('email'),
                    'password' => $encrypted_password
                );
                $user = $this->tb_user->user_login($value);
                
                if($user){
                    $this->session->set_flashdata('success','เข้าสู่ระบบสำเร็จ');
                    $this->tb_user->user_session_set($user->id,$user->email,$user->user_type);
                    //var_dump($user);
                    // var_dump($_SESSION);
                    // echo $_SESSION['user_logged'].'<br>';
                    // echo $_SESSION['user_id'].'<br>';
                    // echo $_SESSION['user_type'].'<br>';
                    // exit();
                    redirect(base_url('/'),'refresh');
                    
                }else{
                    $this->session->set_flashdata('error','เข้าสู่ระบบไม่สำเร็จ กรุณาลองใหม่อีกครั้ง');
                }

            }
        }

        $this->tb_user->already_login();
        $this->template->setTemplate('เข้าสู่ระบบ', 'auth/login');
        $this->template->loadTemplate();
    }

    public function logout(){
        $this->tb_user->user_session_destroy(); // ทำลาย session
        redirect(base_url('auth/login'),'refresh');
    }
}

?>