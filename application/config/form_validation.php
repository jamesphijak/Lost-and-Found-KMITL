<?php
$required = 'กรุณาใส่%sด้วย';
$valid = 'กรุณาใส่%sให้ถูกต้อง';
$unique = '%sนี้มีในระบบแล้ว';
$matches = '%sไม่ตรงกัน';
$min_mobile = '%sต้องไม่น้อยกว่า 10 ตัว';
$max_mobile = '%sต้องไม่มากกว่า 10 ตัว';
$max_name = '%sต้องไม่มากกว่า 50 ตัว';
$max_description = '%sต้องไม่มากกว่า 200 ตัว';
$natural = '%sต้องมีแต่ตัวเลข 0-9 เท่านั้น';
// $old_value = $_SESSION['user_email'];

// ($this->input->post('password')!=$old_value)
// ? $set_email = 'is_unique[tb_user.email]'
// : $set_email = ''
// ;


$config = array(
    // หน้าสมัครสมาชิก
    'auth/register' => array(
            array(
                    'field' => 'email',
                    'label' => 'อีเมล',
                    'rules' => 'required|trim|valid_email|is_unique[tb_user.email]',
                    'errors' => array(
                        'required' => $required,
                        'valid_email' => $valid,
                        'is_unique' => $unique
                    )
            ),
            array(
                    'field' => 'password',
                    'label' => 'รหัสผ่าน',
                    'rules' => 'required|trim',
                    'errors' => array(
                        'required' => $required
                    )
            ),
            array(
                    'field' => 'confirm_password',
                    'label' => 'ยืนยันรหัสผ่าน',
                    'rules' => 'required|trim|matches[password]',
                    'errors' => array(
                        'required' => $required,
                        'matches' => $matches
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
    'post/createPost' => array(
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
            'rules' => 'required|trim|max_length[50]',
            'errors' => array(
                'required' => $required,
                'max_length' => $max_name
            )
        ),
        array(
            'field' => 'description',
            'label' => 'รายละเอียด',
            'rules' => 'required|trim|max_length[200]',
            'errors' => array(
                'required' => $required,
                'max_length' => $max_description
            )
        )
    )    

);

?>