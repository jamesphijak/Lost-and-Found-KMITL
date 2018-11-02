<?php

class Auth extends CI_Controller
{
    public function login()
    {
        if(isset($_POST['login'])){
            var_dump($_POST['input']);
            exit();

            $this->form_validation->set_rules('email','email','required|valid_email');
            $this->form_validation->set_rules('password','password','required');
            // if form checked and return true
            if($this->form_validation->run()){
                //echo 'form validated';
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                $this->db->select('*');
                $this->db->from('user');
                $this->db->where(array(
                    'email' => $email,
                    'password' => $password
                ));
                $query = $this->db->get();
                $user = $query->row();

                // $num = $query->num_rows();
                // here you can do something with $query
                // if ($num > 0) {﻿

                if(!empty($user)){
                    // temporary message
                    $this->session->set_flashdata("success","เข้าสู่ระบบสำเร็จ");
                    $_SESSION['user_logged'] = true;
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_email'] = $user->email;
                    redirect('user/profile','refresh');

                }else{
                    $this->session->set_flashdata("error","ไม่พบัญชีผู้ใช้นี้อยู่ในระบบ");
                    //redirect('auth/login','refresh');
                }
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