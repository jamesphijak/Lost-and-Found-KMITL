<?php

class Post extends CI_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function status($type = null, $id = null){
        if ($type != null) {
            if ($type == 'wait' || $type == 'ok') {
                //exit($type);
                if ($id != null) {
                    //exit($id);
                    if($type == 'ok'){
                        // change to ok
                        $this->tb_post->update_post_status($id,array('post_status' => 'OK'));
                        redirect(base_url('user/profile'));
                    }else{
                        // change to wait
                        $this->tb_post->update_post_status($id,array('post_status' => 'Wait'));
                        redirect(base_url('user/profile'));
                    }
                }else{
                    redirect(base_url(''));
                }
            }else{
                redirect(base_url(''));
            }
        }else{
            redirect(base_url(''));
        }
    }

    public function all($type = null, $id = null)
    {
        if ($type != null) {
            if ($type == 'lost' || $type == 'found' || $type == 'color' || $type == 'category') {
                $select_field = '';
                $value_field = '';
                if ($type == 'lost' || $type == 'found') {
                    $title_type = ($type == 'lost') ? 'ของหาย' : 'พบของ';
                    $select_field = 'post_type';
                    $value_field = $type;
                } else {
                    if ($id != null) {
                        if ($type == 'color') {
                            $color = $this->tb_color->get_color_by_id($id);
                            $title_type = 'ของสี' . $color->color_name;
                            $select_field = 'post_color_id';
                        } else {
                            $category = $this->tb_category->get_category_by_id($id);
                            $title_type = 'ของหมวดหมู่' . $category->category_name;
                            $select_field = 'post_category_id';
                        }
                        $value_field = $id;
                    } else {
                        redirect(base_url(''));
                    }
                }

                $title = 'รายการประกาศ' . $title_type;
                $this->template->setHeader($title);
                $this->template->loadHeader();
                //pass parameter to profile
                $body = array(
                    'title' => $title,
                    'posts' => $this->tb_post->get_posts_by_field_limit($select_field, $value_field, 'Approve', 0)
                );
                $this->load->view('post/view_all', $body);
                // $this->load->view('user/profile',$body);
                $this->template->loadFooter();

            } else {
                redirect(base_url(''));
            }
        } else {
            redirect(base_url(''));
        }
    }

    public function fetch_comment($post_id = null){
        if($post_id != null) {
            $output = '';
            $parent_comment = $this->tb_comment->get_comments_by_post_id(0, $post_id,'desc');
            foreach ($parent_comment as $pc) {
                $admin = ($pc->user_type == "Admin" )? ' bg-secondary text-white':'';
                $name = ($pc->user_type == "Admin" )? 'Administrator':$pc->user_email;
                $output .= '<div class="card" style="margin-bottom:10px;">
                            <p class="card-header '.$admin.'">โดย <b>' . $name . '</b> 
                            เมื่อ <i>' . $this->template->thaiNormalDatetime($pc->comment_created) . '</i>';

                // Only login can do this
                if(isset($_SESSION['user_logged'])) {
                    $output .= ($_SESSION['user_id'] == $pc->comment_user_id || $_SESSION['user_type'] == "Admin") ? '<a style="margin-left:5px;" class="btn btn-small btn-danger text-white remove float-right" id="' . $pc->comment_id . '">
                <i class="fas fa-times-circle"></i></a>' : '';

                 $output .= '<a class="btn btn-small btn-info text-white reply float-right" id="' . $pc->comment_id . '" comment_to="' . $pc->user_email . '"><i class="fas fa-reply"></i> ตอบกลับ</a>';
                }

                $output .=  '</p>
                            
                            <div class="card-body">
                            
                            <p class="card-text">'.$pc->comment_text.'</p>
                            </div>
                            </div>';

                $sub_comment = $this->tb_comment->get_comments_by_post_id($pc->comment_id, $post_id,'asc');
                foreach ($sub_comment as $sc) {
                    $admin = ($sc->user_type == "Admin" )? ' bg-secondary text-white':'';
                    $name = ($sc->user_type == "Admin" )? 'Administrator':$sc->user_email;
                    $output .= '<div class="card" style="margin-bottom:10px; margin-left:60px;">
                                <p class="card-header '.$admin.'">โดย <b>' . $name . '</b> 
                                เมื่อ <i>' . $this->template->thaiNormalDatetime($sc->comment_created) . '</i>';

                    // Only login can do this
                    if(isset($_SESSION['user_logged'])) {
                        $output .= ($_SESSION['user_id'] == $sc->comment_user_id || $_SESSION['user_type'] == "Admin") ? '<a class="btn btn-small btn-danger text-white remove float-right" id="' . $sc->comment_id . '">
                    <i class="fas fa-times-circle"></i></a>' : '';
                    }

                    $output .=  '</p>
                                
                                <div class="card-body">
                                
                                <p class="card-text">'.$sc->comment_text.'</p>
                                </div>
                                </div>';

                }
            }

            echo $output;
        }
    }

    public function remove_comment($id = null){
        if($id != null) {
            // check session again
            $comment = $this->tb_comment->get_comment_by_id($id);
            if(isset($comment)){
                if($_SESSION['user_id'] == $comment->comment_user_id || $_SESSION['user_type'] == "Admin"){
                    if($comment->comment_parent_id == 0) {
                        $this->tb_comment->delete_comment_child($id);
                    }
                    $this->tb_comment->delete_comment($id);
                }
            }
        }
    }


    public function add_comment($post_id = null, $user_id = null)
    {
        if($post_id != null && $user_id != null) {
            $message = '';

            if ($this->input->post('comment_content') == '') {
                $message .= '<div class="alert alert-danger">กรุณาระบุความคิดเห็นด้วย</div>';
            } else {
                $comment_parent_id = $this->input->post('comment_id');
                // htmlspecialchars(strip_tags(
                $comment_text = nl2br(strip_tags(trim($this->input->post('comment_content'))));
                // $message .= '<div class="alert alert-success">สวัสดี อิอิ Comment_ID: '.$comment_parent_id.', Text: '.$comment_text.', Post_ID: '.$post_id.', User_ID: '.$user_id.'</div>';

                if($comment_text != ""){
                    if (ctype_space($comment_text)) {
                        $message .= '<div class="alert alert-danger">เพิ่มความคิดเห็นไม่สำเร็จ (ใส่แต่ช่องว่างไม่ได้)</div>';
                    }else {
                        if (strlen($comment_text) > 250) {
                            $message .= '<div class="alert alert-danger">เพิ่มความคิดเห็นไม่สำเร็จ (ความยาวความคิดเห็นต้องไม่เกิน 250 ตัว)</div>';
                        } else {

                            $result = $this->tb_comment->create_comment($comment_parent_id, $comment_text, $user_id, $post_id);
                            if ($result > 0) {
                                $message .= '<div class="alert alert-success">เพิ่มความคิดเห็นสำเร็จ</div>';
                            } else {
                                $message .= '<div class="alert alert-danger">เพิ่มความคิดเห็นไม่สำเร็จ</div>';
                            }
                        }
                    }
                }
                else{
                    $message .= '<div class="alert alert-danger">เพิ่มความคิดเห็นไม่สำเร็จ (โปรดใส่เฉพาะข้อความ)</div>';
                }

            }

            $data = array(
                'message'  => $message
            );
            echo json_encode($data);
        }
    }

    public function view($id = null)
    {
        if ($id != null) {
            $post = $this->tb_post->get_post_by_id($id);
            if(!isset($post)){
                redirect(base_url('main'));
            }
            if(isset($_SESSION['user_id'])) {
                if($_SESSION['user_type'] != "Admin") {
                    if ($_SESSION['user_id'] != $post->post_user_id && $post->post_approve != "Approve") {
                        redirect(base_url('main'));
                    }
                }
            }else{
                if($post->post_status == "OK") { // ได้รับคืนแล้ว
                    redirect(base_url('main'));
                }

                if($post->post_is_expire == 1) { // expire
                    redirect(base_url('main'));
                }
            }
            $title = 'ดูประกาศ';
            $this->template->setHeader($title);
            $this->template->loadHeader();
            //pass parameter to profile
            $body = array(
                'title' => $title,
                'post' => $this->tb_post->get_post_by_id($id),
                'page_post_id' => $id,
                'page_login' => $this->tb_user->check_page_login()
            );
            $this->load->view('post/view', $body);
            // $this->load->view('user/profile',$body);
            $this->template->loadFooter();
        } else {
            redirect(base_url(''));
        }
    }

    public function renew($type = null,$id = null)
    {
        $this->tb_user->check_login();
        if ($id != null) {
            $post = $this->tb_post->get_post_by_id($id);
            if(!empty($post)) {
                if($post->post_is_expire == 1){
                    $this->tb_post->renew_post($id);
                    if($type == 'view'){
                        redirect(base_url('post/view/'.$id));
                    }else{
                        redirect(base_url('user/profile'));
                    }

                }else{
                    redirect(base_url('user/profile'));
                }
                // ต้องหมดอายุแล้ว
                // ต่ออายุ
            }else{
                redirect(base_url('user/profile'));
            }
        } else {
            redirect(base_url('user/profile'));
        }
    }

    public function edit($id = null)
    {
        $this->tb_user->check_login();
        if ($id != null) {
            $post = $this->tb_post->get_post_by_id($id);
            if(!empty($post)) {
                $input = $this->input->post();
                if (!empty($input)) {
                    if ($this->form_validation->run('post/create')) {
                        $value = array(
                            'post_name' => $this->input->post('name'),
                            'post_description' => nl2br(strip_tags($this->input->post('description'))),
//                            'post_imgurl1' => $img1_name,
//                            'post_imgurl2' => $img2_name,
                            'post_category_id' => $this->input->post('category'),
                            'post_color_id' => $this->input->post('color'),
                            'post_approve' => 'Unapprove',
                            'post_status' => 'Wait'
                        );

                        if($post->post_name == $value['post_name'] && $post->post_description == $value['post_description'] &&
                        $post->post_category_id == $value['post_category_id'] && $post->post_color_id == $value['post_color_id']) {
                            $this->session->set_flashdata('success', 'ข้อมูลไม่มีการเปลี่ยนแปลง');
                        }else{
                            $result = $this->tb_post->update_post($id,$value);
                            if ($result > 0) {
                                $this->session->set_flashdata('success', 'แก้ไขประกาศสำเร็จ');
                                redirect(base_url('post/view/' . $id), 'refresh');
                            } else {
                                $this->session->set_flashdata('error', 'แก้ไขประกาศไม่สำเร็จ');
                            }
                        }
                    }
                }
                $title = 'แก้ไขประกาศ';
                $this->template->setHeader($title);
                $this->template->loadHeader();
                //pass parameter to profile
                $body = array(
                    'title' => $title,
                    'post' => $this->tb_post->get_post_by_id($id),
                    'page_post_id' => $id,
                    'categories' => $this->tb_category->get_categories(),
                    'colors' => $this->tb_color->get_colors(),
                );
                $this->load->view('post/edit', $body);
                // $this->load->view('user/profile',$body);
                $this->template->loadFooter();
            }else{
                redirect(base_url('user/profile'));
            }
        } else {
            redirect(base_url('user/profile'));
        }
    }

    public function admin_remove($id = null){
        $this->tb_user->check_login();
        if ($id != null) {
            $post = $this->tb_post->get_post_by_id($id);
            if(!isset($post)){
                redirect(base_url('user/profile'));
            }
            if($_SESSION['user_type']  == 'Admin'){
                // remove image
                if($post->post_imgurl1 != ''){
                    if (@getimagesize($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl1)) {
                        unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl1);
                    }
                }
                if($post->post_imgurl2 != ''){
                    if (@getimagesize($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl2)) {
                        unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl2);
                    }
                }
                // remove comment

                // delete post
                $this->tb_post->delete_post($id);
                $this->tb_comment->delete_comment_post($id);
                redirect(base_url('admin/post'));
            }else{
                redirect(base_url('admin/post'));
            }
        }else{
            redirect(base_url('user/profile'));
        }
    }

    public function remove($id = null){
        $this->tb_user->check_login();
        if ($id != null) {
            $post = $this->tb_post->get_post_by_id($id);
            if(!isset($post)){
                redirect(base_url('user/profile'));
            }
            if($_SESSION['user_id']  == $post->post_user_id){
                // remove image
                if($post->post_imgurl1 != ''){
                    if (@getimagesize($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl1)) {
                        unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl1);
                    }
                }
                if($post->post_imgurl2 != ''){
                    if (@getimagesize($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl2)) {
                        unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$post->post_imgurl2);
                    }
                }
                // remove comment

                // delete post
                $this->tb_post->delete_post($id);
                $this->tb_comment->delete_comment_post($id);
                redirect(base_url('user/profile'));
            }else{
                redirect(base_url('user/profile'));
            }
        }else{
            redirect(base_url('user/profile'));
        }
    }

    public function create($type = null)
    {
        $this->tb_user->check_login();
        if ($type != null) {
            $input = $this->input->post();
            if (!empty($input)) {
                if ($this->form_validation->run('post/create')) {
                    $config['upload_path'] = 'uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $upload_check = false;
                    $upload_img1 = '';
                    $upload_img2 = '';
                    $img1_name = '';
                    $img2_name = '';
                    $resize_check = false;

                    $upload_path = 'uploads/';
                    if (!file_exists($upload_path)) mkdir($upload_path); // หาโฟลเดอไม่เจอ สร้างขึ้นมาใหม่
                    if (!$_FILES) redirect(base_url('post/create/' . $type)); // ถ้าไม่มีไฟล์ให้ return กลับ

                    if ($_FILES['image1']['error'] > 0 && $_FILES['image2']['error'] > 0) {
                        // Error! Image 1 and 2 empty
                        $this->session->set_flashdata('error', 'กรุณาเลือกรูปภาพด้วย');
                    } else {
                        if ($_FILES['image1']['error'] > 0 && $_FILES['image2']['error'] <= 0) {
                            // Error! Image 1 empty , Image 2 not empty
                            $this->session->set_flashdata('error', 'กรุณาเลือกรูปภาพปกด้วย');
                        } elseif ($_FILES['image2']['error'] > 0 && $_FILES['image1']['error'] <= 0) {
                            // echo "Upload only image 1 : Image 1 not empty , Image 2 empty <br>";
                            // Upload one photo
                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('image1')) {
                                $upload_img1 = $this->upload->data(); // เก็บข้อมูล
                                $upload_check = true; // เปลี่ยนสถานะว่าอัพโหลดเสร็จ
                            } else {
                                $this->session->set_flashdata('error', 'อัพโหลดภาพปกไม่สำเร็จ');
                            }

                        } else {
                            // echo "Upload image 1&2 : Image 1 and 2 not empty<br>";
                            // Upload two photo

                            $this->upload->initialize($config);
                            if ($this->upload->do_upload('image1')) {
                                $upload_img1 = $this->upload->data(); // เก็บข้อมูล
                                $upload_check = true; // เปลี่ยนสถานะว่าอัพโหลดเสร็จ

                                if ($this->upload->do_upload('image2')) {
                                    $upload_img2 = $this->upload->data(); // เก็บข้อมูล
                                    $upload_check = true; // เปลี่ยนสถานะว่าอัพโหลดเสร็จ
                                } else {
                                    $this->session->set_flashdata('error', 'อัพโหลดภาพเพิ่มเติมไม่สำเร็จ');
                                    $upload_check = false; // เปลี่ยนสถานะว่าอัพโหลดไม่เสร็จ
                                }
                            } else {
                                $this->session->set_flashdata('error', 'อัพโหลดภาพปกไม่สำเร็จ');
                            }
                        }
                    }

                    // หลังอัพโหลดภาพ ทำการ Resize
                    $config['image_library'] = 'gd2';

                    if ($upload_img1 != '' && $upload_img2 != '' && $upload_check == true) {
                        // Resize ทั้งสองรูป
                        // Resize image
                        $config['source_image'] = 'uploads/' . $upload_img1['file_name'];
                        list($width, $height) = getimagesize($config['source_image']);
                        if ($width >= $height) {
                            $config['width'] = 640;
                        } else {
                            $config['height'] = 640;
                        }
                        $config['master_dim'] = 'auto';
                        $this->load->library('image_lib', $config);

                        if ($this->image_lib->resize()) {
                            $resize_check = true;
                        } else {
                            $this->session->set_flashdata('error', 'ลดขนาดภาพไม่ปกไม่ได้');
                        }
                        // Resize image 2
                        $this->image_lib->clear();
                        $config2['source_image'] = 'uploads/' . $upload_img2['file_name'];
                        list($width, $height) = getimagesize($config2['source_image']);
                        if ($width >= $height) {
                            $config2['width'] = 640;
                        } else {
                            $config2['height'] = 640;
                        }
                        $config2['master_dim'] = 'auto';
//                        $this->load->library('image_lib', $config2);
                        $this->image_lib->initialize($config2);

                        if ($this->image_lib->resize()) {
                            $resize_check = true;
                        } else {
                            $this->session->set_flashdata('error', 'ลดขนาดภาพไม่ปกไม่ได้');
                        }


                    } elseif ($upload_img1 != '' && $upload_img2 == '' && $upload_check == true) {
                        // Resize รูปแรกรูปเดียว
                        $config['source_image'] = 'uploads/' . $upload_img1['file_name'];
                        list($width, $height) = getimagesize($config['source_image']);
                        if ($width >= $height) {
                            $config['width'] = 640;
                        } else {
                            $config['height'] = 640;
                        }
                        $config['master_dim'] = 'auto';
                        $this->load->library('image_lib', $config);

                        if ($this->image_lib->resize()) {
                            $resize_check = true;
                        } else {
                            $this->session->set_flashdata('error', 'ลดขนาดภาพไม่ปกไม่ได้');
                        }
                    } else {
                        // Resize ไม่ได้ ไม่ม่รูป
                        $this->session->set_flashdata('error', 'ลดขนาดภาพไม่ได้ ไม่พบไฟล์รูป');
                    }

                    // หลัง Resize
                    if ($resize_check == true) {
                        $img1_name = $upload_img1['file_name'];
                        if ($upload_img2 != '') {
                            $img2_name = ($upload_img2['file_name'] != '') ? $upload_img2['file_name'] : '';
                        }

                        //$textSuccess = 'Name: '.$upload_img['file_name'].' Size: '.$upload_img['file_size'].'kb. Width: '.$upload_img['image_width'].'px Height: '.$upload_img['image_height'].'px';
                        //$this->session->set_flashdata('success', 'อัพโหลดไฟล์และลดขนาดรูปสมบูรณ์ '.$textSuccess);
                        $value = array(
                            'post_name' => strip_tags($this->input->post('name')),
                            'post_description' => nl2br(strip_tags($this->input->post('description'))),
                            'post_type' => $type,
                            'post_imgurl1' => $img1_name,
                            'post_imgurl2' => $img2_name,
                            'post_user_id' => $_SESSION['user_id'],
                            'post_category_id' => $this->input->post('category'),
                            'post_color_id' => $this->input->post('color')
                        );


                            if ($value['post_name'] != "" && $value['post_description'] != "") {
                                if (ctype_space($value['post_name']) && ctype_space($value['post_description'])) {
                                    $this->session->set_flashdata('error', 'เพิ่มประกาศไม่สำเร็จ (ต้องใส่ข้อความเท่านั้น)');
                                } else {
                                    $result = $this->tb_post->create_post($value);
                                    if ($result > 0) {
                                        $this->session->set_flashdata('success', 'ลงประกาศสำเร็จ');
                                        //                                    var_dump($result);
                                        //                                    exit();
                                        redirect(base_url('post/view/' . $result));
                                    } else {
                                        $this->session->set_flashdata('error', 'ลงประกาศไม่สำเร็จ');
                                    }
                                }
                            } else {
                                $this->session->set_flashdata('error', 'เพิ่มประกาศไม่สำเร็จ (ต้องใส่ข้อความเท่านั้น)');
                            }

                    } else {
                        $this->session->set_flashdata('error', 'ไม่สามารถลงประกาศได้ ไม่ได้เลิอกรูปภาพ');
                    }
                }
            }

            $title_type = ($type == 'lost') ? 'ของหาย' : 'พบของ';
            $title = 'ลงประกาศ' . $title_type;
            $this->template->setHeader($title);
            $this->template->loadHeader();
            //pass parameter to profile
            $body = array(
                'title' => $title,
                'categories' => $this->tb_category->get_categories(),
                'colors' => $this->tb_color->get_colors(),
                'type' => $type
            );
            $this->load->view('post/create', $body);
            // $this->load->view('user/profile',$body);
            $this->template->loadFooter();
        } else {
            redirect(base_url(''));
        }
    }

    public function loadPost($type = null)
    {
        if ($type != null) {
            $search = $_GET['search'];
            $decode = json_decode($search, true);
            $searchType = ($type == 'lost') ? 'found' : 'lost';
            $searh_title = ($type == 'lost') ? 'ถูกพบ' : 'หาย';

            $like = array('post_type' => $searchType,

                'post_category_id' => $decode['category'],
                'post_color_id' => $decode['color']);
            $post_result = $this->tb_post->get_post_like($like);

            if ($decode['color'] == "" && $decode['category'] == "") {
                // echo "ไม่พบรายการที่คล้ายกัน";
                echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>ไม่พบประกาศของที่$searh_title</h5>";
                return;
            } else {

                if (count($post_result) == 0) {
                    echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>ไม่พบประกาศของที่$searh_title</h5>";
                } else {
                    echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>มีของที่$searh_title " . count($post_result) . " รายการ</h5>";
                    foreach ($post_result as $row) :
                        // :hover {background: #FFFFFF}
                        echo "<a style='color: inherit; text-decoration: none; ' target='_blank' href='" . base_url('post/view/' . $row->post_id) . "'>";
                        echo "<div class='media text-muted pt-3'>";

                        if ($row->post_imgurl1 == "") {
                            $image = "image-not-found.jpg";
                        } else {
                            $image = $row->post_imgurl1;
                        }

                        $color = $this->tb_color->get_color_by_id($row->post_color_id);
                        $category = $this->tb_category->get_category_by_id($row->post_category_id);

                        echo "<img class='mr-2 rounded' src='" . base_url("uploads/") . $image . "' data-holder-rendered='true' style='width: 42px; height: 32px;'>";
                        echo "<div class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>";
                        echo "<div class='d-flex justify-content-between align-items-center w-100'>";
                        echo "<h6 class='text-gray-dark'><strong>$row->post_name</strong></h6>";
                        echo "</div>";
                        echo "<span class='d-block'><strong>หมวดหมู่ : $category->category_name</strong>  / <strong>สี : $color->color_name</strong> </span>";
                        echo "</div>";
                        echo "</div></a>";
                    endforeach;

                }
            }
        }
    }


}

?>