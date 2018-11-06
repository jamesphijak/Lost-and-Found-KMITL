<?php

class Post extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();
    }

    public function createLost(){
        $input = $this->input->post();
        if(!empty($input)){
            if($this->form_validation->run('post/createPost')){
                // var_dump($_POST);
                // exit();
                $value = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'type' => 'lost',
                    'imgurl1' => 'test1',
                    'imgurl2' => 'test2',
                    'user_id' => $_SESSION['user_id'],
                    'category_id' => $this->input->post('category'),
                    'color_id' => $this->input->post('color')
                );
    
                $result = $this->tb_post->create_post($value);
                if($result){   
                    $this->session->set_flashdata('success','ลงประกาศของหายสำเร็จ');
                    redirect(base_url('post/createLost'),'refresh');
                }else{
                    $this->session->set_flashdata('error','ลงประกาศของหายไม่สำเร็จ');
                }
            }
        }

        $title = 'ลงประกาศของหาย';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        //pass parameter to profile
        $body = array(
            'title' => $title,
            'categories' => $this->tb_category->get_categories(),
            'colors' => $this->tb_color->get_colors()
        );
        $this->load->view('post/create_lost',$body);
        // $this->load->view('user/profile',$body);
        $this->template->loadFooter();
    }

    public function createFound(){
        exit('Found');
    }

    public function loadLost(){
        $search = $_GET['search'];
        $decode = json_decode($search, true);

        $like = array('type' => 'lost','status' => 'OK','category_id' => $decode['category'], 'color_id' => $decode['color']);
        $post_result = $this->tb_post->get_post_like($like);

        if($decode['color'] == "" && $decode['category'] == ""){
            // echo "ไม่พบรายการที่คล้ายกัน";
            echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>ไม่พบประกาศของที่ถูกพบ</h5>";
            return;
        }

        echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>พบของที่หาย ". count($post_result) ." รายการ</h5>";
        foreach($post_result as $row) :
        echo "<div class='media text-muted pt-3'>";
        echo "<img alt='32x32' class='mr-2 rounded' src='".base_url("assets/upload_images/test.png")."' data-holder-rendered='true' style='width: 42px; height: 32px;'>";
        echo "<div class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>";
        echo "<div class='d-flex justify-content-between align-items-center w-100'>";
        echo "<h6 class='text-gray-dark'><strong>$row->name</strong></h6>";
        echo "<a href='". base_url('viewPost/'.$row->id) ."'>ดูประกาศ</a>";
        echo "</div>";
        echo "<span class='d-block'>หมวดหมู่ : $row->category_id , สี : $row->color_id</span>";
        echo "</div>";
        echo "</div>";
        endforeach;
    }



}

?>