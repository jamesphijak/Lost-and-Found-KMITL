<?php

class Post extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();
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
                    'posts' => $this->tb_post->get_posts_by_field_limit($select_field, $value_field, 'OK', 0)
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

                // parent comment
                $output .= '
                <div class="media text-muted pt-3">
                <div class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                <div class="d-flex justify-content-between align-items-center ">
                    <strong class="text-gray-dark">โดย <b>' . $pc->user_email . '</b> เมื่อ <i>' . $this->template->thaiNormalDatetime($pc->comment_created) . '</i></strong>
                    <div class="btn-group" role="group">
                        <a class="btn btn-info text-white reply" id="'.$pc->comment_id.'" ><i class="fas fa-reply"></i> ตอบกลับ</a>';

                $output .= ($_SESSION['user_id'] == $pc->comment_user_id)? '<a class="btn btn-danger text-white remove" id="'.$pc->comment_id .'"><i class="fas fa-times-circle"></i></a>':'';

                $output .= '</div> 
                </div>
                <span class="d-block">'.$pc->comment_text.'</span>
                </div></div>';

                // sub comment
                $sub_comment = $this->tb_comment->get_comments_by_post_id($pc->comment_id, $post_id,'asc');
                foreach ($sub_comment as $sc) {
                    $output .= '
                     <div class="media text-muted pt-3" style="margin-left:50px;">
                     <div class="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-gray-dark">โดย <b>' . $sc->user_email . '</b> เมื่อ <i>' . $this->template->thaiNormalDatetime($sc->comment_created) . '</i></strong>
                             <div class="btn-group" role="group">';
                    $output .= ($_SESSION['user_id'] == $sc->comment_user_id)? '<a class="btn btn-danger text-white remove" id="'.$sc->comment_id .'"><i class="fas fa-times-circle"></i></a>':'';
                    $output .= '</div>
                        </div>
                        <span class="d-block">'.$sc->comment_text.'</span>
                     </div>
                     </div>    
                    ';
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
                if($_SESSION['user_id'] == $comment->comment_user_id){
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
                $comment_text = $this->input->post('comment_content');
                // $message .= '<div class="alert alert-success">สวัสดี อิอิ Comment_ID: '.$comment_parent_id.', Text: '.$comment_text.', Post_ID: '.$post_id.', User_ID: '.$user_id.'</div>';

                $result = $this->tb_comment->create_comment($comment_parent_id,$comment_text,$user_id,$post_id);
                if($result > 0){
                    $message .= '<div class="alert alert-success">เพิ่มความคิดเห็นสำเร็จ</div>';
                }else{
                    $message .= '<div class="alert alert-danger">เพิ่มความคิดเห็นไม่สำเร็จ</div>';
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
            $title = 'ดูประกาศ';
            $this->template->setHeader($title);
            $this->template->loadHeader();
            //pass parameter to profile
            $body = array(
                'title' => $title,
                'post' => $this->tb_post->get_post_by_id($id),
                'page_post_id' => $id
            );
            $this->load->view('post/view', $body);
            // $this->load->view('user/profile',$body);
            $this->template->loadFooter();
        } else {
            redirect(base_url(''));
        }
    }

    public function create($type = null)
    {
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

                            $config['source_image'] = 'uploads/' . $upload_img2['file_name'];
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
                                $this->session->set_flashdata('error', 'ลดขนาดภาพเพิ่มเติมไม่ได้');
                                $resize_check = false;
                            }
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

                        // $textSuccess = 'Name: '.$upload_img['file_name'].' Size: '.$upload_img['file_size'].'kb. Width: '.$upload_img['image_width'].'px Height: '.$upload_img['image_height'].'px';
                        //$this->session->set_flashdata('success', 'อัพโหลดไฟล์และลดขนาดรูปสมบูรณ์ '.$textSuccess);

                        $value = array(
                            'post_name' => $this->input->post('name'),
                            'post_description' => $this->input->post('description'),
                            'post_type' => $type,
                            'post_imgurl1' => $img1_name,
                            'post_imgurl2' => $img2_name,
                            'post_user_id' => $_SESSION['user_id'],
                            'post_category_id' => $this->input->post('category'),
                            'post_color_id' => $this->input->post('color')
                        );

                        $result = $this->tb_post->create_post($value);
                        if ($result) {
                            $this->session->set_flashdata('success', 'ลงประกาศสำเร็จ');
                            redirect(base_url('post/create/' . $type), 'refresh');
                        } else {
                            $this->session->set_flashdata('error', 'ลงประกาศไม่สำเร็จ');
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

//    public function file_check($str){
//        $allowed_mime_type_arr = array('image/jpeg','image/png','image/jpg');
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
//    }

    public function loadPost($type = null)
    {
        if ($type != null) {
            $search = $_GET['search'];
            $decode = json_decode($search, true);
            $searchType = ($type == 'lost') ? 'found' : 'lost';
            $searh_title = ($type == 'lost') ? 'ถูกพบ' : 'หาย';

            $like = array('post_type' => $searchType, 'post_status' => 'OK', 'post_category_id' => $decode['category'], 'post_color_id' => $decode['color']);
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
                        echo "<a style='color: inherit; text-decoration: none;' target='_blank' href='" . base_url('post/view/' . $row->post_id) . "'>";
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