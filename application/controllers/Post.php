<?php

class Post extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();
    }

    public function createLost(){
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

        $like = array('type' => 'found','category_id' => $decode['category'], 'color_id' => $decode['color']);
        $post_result = $this->tb_post->get_post_like($like);

        if($decode['color']=="" && $decode['category']==""){
            // echo "ไม่พบรายการที่คล้ายกัน";
            echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>ไม่พบประกาศของที่ถูกพบ</h5>";
            return;
        }

        // echo "<table class='table table-hover'>";
        // foreach($post_result as $row) :
        //     echo "<tr class='clickable-row' data-href='viewLost.php?id=".$row->id."'>";
        //     echo "<td>" . $row->name . "</td>";
        //     echo "<td>" . $row->type . "</td>";
        //     echo "<td>" . $row->category_id. "</td>";
        //     echo "<td>" . $row->color_id . "</td>";
        //     //echo "<td><img style='width:50px;height:50px' src='picture/".$entry['row']."'>"."</td>";
        //     echo "</tr>";
        //     endforeach;
        // echo "</table>";
        
        // echo "<h4 class='d-flex justify-content-between align-items-center mb-3'>";
        // echo "<span>ของที่ถูกพบ</span>";
        // echo "<span class='badge badge-primary badge-pill'>".count($post_result)."</span></h4>";
        // echo "<ul class='list-group mb-3'>";
        // foreach($post_result as $row) :
        // echo "<li class='list-group-item d-flex justify-content-between'><a href=''>";
        // echo "<span class='pull-left'>";
        // //echo "<img src='". base_url("assets/upload_images/test.png") ."' width='80px' style='margin-top:10px;' class='img-reponsive img-rounded />";
        // echo "</span>";
        // echo "<div class='text-left' style='margin-right:90px;'> $row->name ($row->type) หมวดหมู่ : $row->category_id <br>สี : $row->color_id</div>";
        // echo "</a></li>";
        // endforeach;
        // echo "</ul>";

        echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>พบของที่หาย ". count($post_result) ." รายการ</h5>";
        foreach($post_result as $row) :
        echo "<div class='media text-muted pt-3'>";
        echo "<img alt='32x32' class='mr-2 rounded' src='".base_url("assets/upload_images/test.png")."' data-holder-rendered='true' style='width: 42px; height: 32px;'>";
        echo "<div class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>";
        echo "<div class='d-flex justify-content-between align-items-center w-100'>";
        echo "<strong class='text-gray-dark'>$row->name</strong>";
        echo "<a href='". base_url('viewPost/'.$row->id) ."'>ดูประกาศ</a>";
        echo "</div>";
        echo "<span class='d-block'>หมวดหมู่ : $row->category_id , สี : $row->color_id</span>";
        echo "</div>";
        echo "</div>";
        endforeach;
    }



}

?>