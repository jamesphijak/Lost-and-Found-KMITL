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
                // 1 = staff
                exit('Staff');
            }elseif($_SESSION['user_type'] == '2'){
                // 2 = admin
                exit('Admin');
            }else{
                // 0 = member
                exit('Member');
            }
        }

    }

    public function profile(){
        $this->template->setTemplate('จัดการข้อมูลส่วนตัว', 'user/index');
        $this->template->loadTemplate();
    }
}