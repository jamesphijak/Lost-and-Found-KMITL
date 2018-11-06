<?php

class Admin extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();  
    }

    public function index(){
    	$title = 'Admin Dashboard';
    	$this->template->setHeader($title);
        $this->template->loadHeader();
        $this->load->view('admin/menu');
        
        // pass parameter to profile
        $body = array(
            'title' => $title
        );
        $this->load->view('admin/main',$body);
        // $this->load->view('user/profile',$body);
        $this->template->loadFooter();

    }

    public function postApprove(){
    $title = 'อนุมัติรายการประกาศ';
    	$this->template->setHeader($title);
        $this->template->loadHeader();
        $this->load->view('admin/menu');

        //pass parameter to profile
        $body = array(
            'title' => $title,
            'posts' => $this->tb_post->get_posts_by_status('Wait')
        );
        $this->load->view('admin/postApprove',$body);
        

        // $this->load->view('user/profile',$body);
        $this->template->loadFooter();
    }

    public function user(){
    	$title = 'รายการผู้ใช้งาน';
    	$this->template->setHeader($title);
        $this->template->loadHeader();
        $this->load->view('admin/menu');

        //pass parameter to profile
        $body = array(
            'title' => $title,
            'users' => $this->tb_user->get_users()
        );
        $this->load->view('admin/user',$body);
        

        // $this->load->view('user/profile',$body);
        $this->template->loadFooter();

    }

    public function category($id = null){ // load id from index page assign to null becasue when page is not in edit mode
        // echo '<br><br><br>';
        // var_dump($_POST['name']);
        $this->save_category(); // load for save function

        $title = 'หมวดหมู่';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        $this->load->view('admin/menu');

        //pass parameter to profile
        $body = array(
            'title' => $title,
            'category' => $this->tb_category->get_category_by_id($id),
            'categories' => $this->tb_category->get_categories()
        );
        $this->load->view('admin/category',$body);
        // $this->load->view('user/profile',$body);
        $this->template->loadFooter();
    }

    private function save_category(){
        $input = $this->input->post(); // ส่ง post มาจาก form
        if(!empty($input)){ // ถ้า post ไม่ว่าง
            if($this->form_validation->run('admin/category')){ // ถ้า valid ก็จะเข้า
                if(empty($input['id'])){ // id ว่าง
                    $this->tb_category->create_category($input); // create new user
                    redirect(base_url('admin/category')); // มาจาก config
                }else{
                    // แก้ไขข้อมูล
                    $this->tb_category->update_category($input['id'], $input);
                }
            } 
        }
    }

    public function deleteCategory($id){
        // exit('Delete is : '.$id);
        $this->tb_category->delete_category($id);
        redirect(base_url('admin/category')); // redirect 
    }

    public function color($id = null){ // load id from index page assign to null becasue when page is not in edit mode
        // echo '<br><br><br>';
        // var_dump($_POST['name']);
        $this->save_color(); // load for save function

        $title = 'สี';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        $this->load->view('admin/menu');

        //pass parameter to profile
        $body = array(
            'title' => $title,
            'color' => $this->tb_color->get_color_by_id($id),
            'colors' => $this->tb_color->get_colors()
        );
        $this->load->view('admin/color',$body);
        // $this->load->view('user/profile',$body);
        $this->template->loadFooter();
    }

    private function save_color(){
        $input = $this->input->post(); // ส่ง post มาจาก form
        if(!empty($input)){ // ถ้า post ไม่ว่าง
            if($this->form_validation->run('admin/color')){ // ถ้า valid ก็จะเข้า
                if(empty($input['id'])){ // id ว่าง
                    $this->tb_color->create_color($input); // create new user
                    redirect(base_url('admin/color')); // มาจาก config
                }else{
                    // แก้ไขข้อมูล
                    $this->tb_color->update_color($input['id'], $input);
                }
            } 
        }
    }

    public function deleteColor($id){
        // exit('Delete is : '.$id);
        $this->tb_color->delete_color($id);
        redirect(base_url('admin/color')); // redirect 
    }


}

?>