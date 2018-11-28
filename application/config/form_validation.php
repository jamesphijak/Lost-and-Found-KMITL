<?php
$required = 'กรุณาใส่%sด้วย';
$valid = 'กรุณาใส่%sให้ถูกต้อง';
$unique = '%sนี้มีในระบบแล้ว';
$matches = '%sไม่ตรงกัน';
$min_mobile = '%sต้องมี 10 ตัว';
$max_mobile = '%sต้องมี 10 ตัว';
$max_name = '%sต้องไม่มากกว่า 50 ตัว';
$max_description = '%sต้องไม่มากกว่า 200 ตัว';
$natural = '%sต้องมีแต่ตัวเลข 0-9 เท่านั้น';

$min_name = '%sต้องไม่น้อยกว่า 3 ตัว';
$min_description = '%sต้องไม่น้อยกว่า 5 ตัว';

//$alpha_numeric = '%sต้องไม่มีอักขระพิเศษ';
// $old_value = $_SESSION['user_email'];

// ($this->input->post('password')!=$old_value)
// ? $set_email = 'is_unique[tb_user.email]'
// : $set_email = ''
// ;

$min_password = '%sต้องไม่ต่ำกว่า 4 ตัว';

$config = array(
    // หน้าสมัครสมาชิก
    'auth/register' => array(
            array(
                    'field' => 'email',
                    'label' => 'อีเมล',
                    'rules' => 'required|trim|valid_email|is_unique[tb_user.user_email]',
                    'errors' => array(
                        'required' => $required,
                        'valid_email' => $valid,
                        'is_unique' => $unique
                    )
            ),
            array(
                    'field' => 'password',
                    'label' => 'รหัสผ่าน',
                    'rules' => 'required|trim|min_length[4]',
                    'errors' => array(
                        'required' => $required,
                        'min_length' => $min_password
                    )
            ),
            array(
                    'field' => 'confirm_password',
                    'label' => 'ยืนยันรหัสผ่าน',
                    'rules' => 'required|trim|min_length[4]|matches[password]',
                    'errors' => array(
                        'required' => $required,
                        'matches' => $matches,
                        'min_length' => $min_password
                    )
            ),
            array(
                    'field' => 'mobile',
                    'label' => 'เบอร์โทรศัพท์',
                    'rules' => 'required|trim|is_natural|min_length[10]|max_length[10]',
                    'errors' => array(
                        'required' => $required,
                        'is_natural' => $natural,
                        'min_length' => $min_mobile,
                        'max_length' => $max_mobile
                    )
            )
    ),
    // หน้าเข้าสู่ระบบ
    'auth/login' => array(
            array(
                'field' => 'email',
                'label' => 'อีเมล',
                'rules' => 'required|trim|valid_email',
                'errors' => array(
                    'required' => $required,
                    'valid_email' => $valid
                )
            ),
            array(
                    'field' => 'password',
                    'label' => 'รหัสผ่าน',
                    'rules' => 'required|trim',
                    'errors' => array(
                        'required' => $required
                    )
            )                
    ),

    // หน้าแก้ไขข้อมูลส่วนตัว
    // หน้าสมัครสมาชิก
    'user/edit_profile' => array(
        array(
                'field' => 'mobile',
                'label' => 'เบอร์โทรศัพท์',
                'rules' => 'required|trim|is_natural|min_length[10]|max_length[10]',
                'errors' => array(
                    'required' => $required,
                    'is_natural' => $natural,
                    'min_length' => $min_mobile,
                    'max_length' => $max_mobile
                )
            )
    ),
    'user/edit_password' => array(
        array(
                'field' => 'password',
                'label' => 'รหัสผ่านใหม่',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => $required
                )
        ),
        array(
                'field' => 'confirm_password',
                'label' => 'ยืนยันรหัสผ่านใหม่',
                'rules' => 'required|trim|matches[password]',
                'errors' => array(
                    'required' => $required,
                    'matches' => $matches
                )
        )
    ),
    'admin/category' => array(
        array(
                'field' => 'category_name',
                'label' => 'ชื่อหมวดหมู่',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => $required
                )
        )
    ),
    'admin/color' => array(
        array(
                'field' => 'color_name',
                'label' => 'ชื่อสี',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => $required
                )
        )
    )
    ,
    // หน้าโพสต์
    'post/create' => array(
        array(
            'field' => 'category',
            'label' => 'หมวดหมู่',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => $required,
                'max_length' => $max_mobile
            )
        ),
        array(
            'field' => 'color',
            'label' => 'สี',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => $required,
            )
        ),
        array(
            'field' => 'name',
            'label' => 'ชื่อของ',
            'rules' => 'required|trim|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z0-9ก-๛เ ]*$/]',
            'errors' => array(
                'required' => $required,
                'min_length' => $min_name,
                'max_length' => $max_name,
                'regex_match' => '%sห้ามมีอักขระพิเศษ'
            )
        ),
        array(
            'field' => 'description',
            'label' => 'รายละเอียด',
            'rules' => 'required|trim|min_length[5]|max_length[200]',
            'errors' => array(
                'required' => $required,
                'min_length' => $min_description,
                'max_length' => $max_description
            )
        )
    )    

);


?>