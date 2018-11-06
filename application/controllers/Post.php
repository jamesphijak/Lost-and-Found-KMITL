<?php

class Post extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        //$this->tb_user->check_login();
    }


    public function create($type = null){
        if($type != null) {
            $input = $this->input->post();
            if (!empty($input)) {
                if ($this->form_validation->run('post/create')) {
                    $config['upload_path'] = 'uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|png';

                    $upload_path = 'uploads/';
                    if(!file_exists($upload_path)) mkdir($upload_path); // หาโฟลเดอไม่เจอ สร้างขึ้นมาใหม่
                    if(!$_FILES) redirect(base_url('post/create/'.$type)); // ถ้าไม่มีไฟล์ให้ return กลับ

                    $this->upload->initialize($config);
                    if($this->upload->do_upload('image1')){ // อัพโหลดได้ให้ส่ง data ที่อัพโหลดไปให้ view

                        $upload_img = $this->upload->data();
                        // Resize image
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = 'uploads/'.$upload_img['file_name'];

                        list($width, $height) = getimagesize($config['source_image']);
                        if ($width >= $height){ $config['width'] = 640; }
                        else{ $config['height'] = 640; }
                        $config['master_dim'] = 'auto';
                        $this->load->library('image_lib', $config);

                        if ($this->image_lib->resize()){
                            $textSuccess = 'Name: '.$upload_img['file_name'].' Size: '.$upload_img['file_size'].'kb. Width: '.$upload_img['image_width'].'px Height: '.$upload_img['image_height'].'px';
                            //$this->session->set_flashdata('success', 'อัพโหลดไฟล์และลดขนาดรูปสมบูรณ์ '.$textSuccess);

                            $value = array(
                                'post_name' => $this->input->post('name'),
                                'post_description' => $this->input->post('description'),
                                'post_type' => $type,
                                'post_imgurl1' => $upload_img['file_name'],
                                'post_imgurl2' => 'test2',
                                'post_user_id' => $_SESSION['user_id'],
                                'post_category_id' => $this->input->post('category'),
                                'post_color_id' => $this->input->post('color')
                            );

                            $result = $this->tb_post->create_post($value);
                            if ($result) {
                                $this->session->set_flashdata('success', 'ลงประกาศสำเร็จ');
                                redirect(base_url('post/create/'.$type), 'refresh');
                            } else {
                                $this->session->set_flashdata('error', 'ลงประกาศไม่สำเร็จ');
                            }
                        }else{
                            $this->session->set_flashdata('error', $this->image_lib->display_errors());
                        }

                    }else{
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                    }


                }
            }

            $title_type = ($type == 'lost')? 'ของหาย':'พบของ';
            $title = 'ลงประกาศ'.$title_type;
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
        }else{
            redirect(base_url(''));
        }
    }

    public function file_check($str){
//        $allowed_mime_type_arr = array('image/jpeg','image/png','image/x-png');
//        $mime = get_mine_by_extension($_FILES['file']['image1']);
//        if(isset($_FILES['file']['image1']) && $_FILES['file']['image1'] != ''){
//            if(in_array($mime, $allowed_mime_type_arr)){
//                return true;
//            }else{
//                $this->form_validation->set_message('file_check','ไฟล์ไม่รองรับ โปรดเลือกรูปภาพที่เป็น jpg/jpeg/png');
//                return false;
//            }
//        }else{
//            $this->form_validation->set_message('file_check','ไฟล์ไม่รองรับ โปรดเลือกรูปภาพที่เป็น jpg/jpeg/png');
//            return false;
//        }
    }

    public function loadPost($type = null){
        if($type != null) {
            $search = $_GET['search'];
            $decode = json_decode($search, true);
            $searchType = ($type == 'lost')? 'found':'lost';
            $searh_title = ($type == 'lost') ? 'ถูกพบ' : 'หาย';

            $like = array('post_type' => $searchType, 'post_status' => 'OK', 'post_category_id' => $decode['category'], 'post_color_id' => $decode['color']);
            $post_result = $this->tb_post->get_post_like($like);

            if ($decode['color'] == "" && $decode['category'] == "") {
                // echo "ไม่พบรายการที่คล้ายกัน";
                echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>ไม่พบประกาศของที่$searh_title</h5>";
                return;
            }else {

                if (count($post_result) == 0) {
                    echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>ไม่พบประกาศของที่$searh_title</h5>";
                } else {
                    echo "<h5 class='d-flex border-bottom border-gray pb-2 mb-0'>มีของที่$searh_title " . count($post_result) . " รายการ</h5>";
                    foreach ($post_result as $row) :
                        echo "<a style='color: inherit; text-decoration: none;' href='" . base_url('viewPost/' . $row->post_id) . "'>";
                        echo "<div class='media text-muted pt-3'>";

                        echo "<img alt='32x32' class='mr-2 rounded' src='" . base_url("assets/upload_images/test.png") . "' data-holder-rendered='true' style='width: 42px; height: 32px;'>";
                        echo "<div class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>";
                        echo "<div class='d-flex justify-content-between align-items-center w-100'>";
                        echo "<h6 class='text-gray-dark'><strong>$row->post_name</strong></h6>";
                        echo "</div>";
                        echo "<span class='d-block'>หมวดหมู่ : $row->post_category_id , สี : $row->post_color_id</span>";
                        echo "</div>";
                        echo "</div></a>";
                    endforeach;

                }
            }
        }
    }



}

?>