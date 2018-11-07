<?php

class User extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();
    }
    
    public function index()
    {
        // select route for user type
        //var_dump($_SESSION);
        if(isset($_SESSION['user_type'])){
            if($_SESSION['user_type'] == '1'){
                exit('Admin');
            }else{
                redirect(base_url('user/profile'));
            }
        }
    }

    public function profile(){
        $title = 'จัดการข้อมูลส่วนตัว';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        // pass parameter to profile
        $body = array(
            'title' => $title,
            'user' => $this->tb_user->get_user_by_id($_SESSION['user_id']),
            'posts' => $this->tb_post->get_posts_by_field_limit('post_user_id',$_SESSION['user_id'], '', 0)
        );

        $this->load->view('user/profile',$body);
        $this->template->loadFooter();
    }

    public function editProfile(){
        $input = $this->input->post();
        if(!empty($input)){
            if($this->input->post('mobile') != $_SESSION['user_mobile']){
                if($this->form_validation->run('user/edit_profile')){
                    $id = $_SESSION['user_id'];
                    $value = array(
                        'user_mobile' => $this->input->post('mobile')
                    );
                    $result = $this->tb_user->update_user($id,$value);

                    if($result){   
                        $this->session->set_flashdata('success','แก้ไขข้อมูลสำเร็จ');
                        redirect(base_url('user/editProfile'),'refresh');
                    }else{
                        $this->session->set_flashdata('error','แก้ไขข้อมูลไม่สำเร็จ');
                    }
                }
            }else{
                $this->session->set_flashdata('error','ข้อมูลไม่มีการเปลี่ยนแปลง');
            }
        }

        $title = 'แก้ไขข้อมูลส่วนตัว';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        // pass parameter to edit
        $body = array(
            'title' => $title,
            'user' => $this->tb_user->get_user_by_id($_SESSION['user_id'])
        );

        $this->load->view('user/edit_profile',$body);
        $this->template->loadFooter();
    }

    // แก้ไขรหัสผ่าน
    public function editPassword(){
        $input = $this->input->post();
        // if(isset($_POST['register'])){
        if(!empty($input)){
            if($this->form_validation->run('user/edit_password')){
                $id = $_SESSION['user_id'];
                $encrypted_password = $this->tb_user->hash($this->input->post('password'));
                $value = array(
                    'user_password' => $encrypted_password
                );
                $result = $this->tb_user->update_user($id,$value);

                if($result){   
                    $this->session->set_flashdata('success','แก้ไขรหัสผ่านสำเร็จ');
                    redirect(base_url('user/editProfile'),'refresh');
                }else{
                    $this->session->set_flashdata('error','แก้ไขรหัสผ่านสำเร็จ');
                }
            }
        }

        // load view
        $title = 'แก้ไขรหัสผ่าน';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        // pass parameter to edit
        $body = array(
            'title' => $title,
            'user' => $this->tb_user->get_user_by_id($_SESSION['user_id'])
        );

        $this->load->view('user/edit_password',$body);
        $this->template->loadFooter();
    }
}