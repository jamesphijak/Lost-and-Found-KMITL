<?php
$required = 'กรุณากรอก%sด้วย';
$valid = 'กรุณากรอก%sให้ถูกต้อง';
$unique = '%sนี้มีในระบบแล้ว';
$matches = '%sไม่ตรงกัน';
$min_mobile = '%sต้องไม่น้อยกว่า 10 ตัว';
$max_mobile = '%sต้องไม่มากกว่า 10 ตัว';

$config = array(
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
                    'rules' => 'required|trim|min_length[10]|max_length[10]',
                    'errors' => array(
                        'required' => $required,
                        'min_length' => $min_mobile,
                        'max_length' => $max_mobile
                    )
            ),
    ),
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
    )
);

?>