<?php

class Tb_user extends CI_Model
{
    private $table = 'tb_user';
    const SALT = 'PNp04n5pEkuyhRHj5a3RTAIy9M6zGs06'; // https://randomkeygen.com/

    // ใช้สมัครสมาชิก
    public function user_register($value){
        // return $this->db->insert_id(); // return last id
        return $this->db->insert($this->table, $value); // return result
    }

    // ใช้สมัครสมาชิก และ return id ที่พึ่งเพิ่มไป
    public function user_register_id($value){
        $this->db->insert($this->table, $value); // insert into
        return $this->db->insert_id(); // return last insert record id
    }

    // แก้ไขข้อมูลสมาชิก
    public function update_user($id, $value){
        $this->db->set('user_updated','now()', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        return $this->db->update($this->table, $value, ['user_id' => $id]); // update
    }

    // ใช้ดึงข้อมูลเข้าสู่ระบบ by user & pass
    public function user_login($value){
        return $this->db->get_where($this->table, $value)->row(); // select * from table where username password
    }

    // ดุงผู้ใช้ทั้งหมด
    public function get_users(){
        $this->db->order_by('user_created','desc'); // เรียงลำดับ
        return $this->db->get($this->table)->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    // ใช้ดึงข้อมูล by id
    public function get_user_by_id($id){
        return $this->db->get_where($this->table, ['user_id' => $id])->row(); // select * from table where id = id
    }

    // ใช้ดึงข้อมูล by email
    public function get_user_by_email($email){
        return $this->db->get_where($this->table, ['user_email' => $email])->row(); // select * from table where id = id
    }

    public function get_user_by_type($type){
        return $this->db->get_where($this->table, ['user_type' => $type])->num_rows(); // select * from table where id = id
    }

    // ใช้ set session
    public function user_session_set($id,$email,$type,$mobile,$status){
        $data = array(
            'user_logged' => true,
            'user_id' => $id,
            'user_email' => $email,
            'user_type' => $type,
            'user_mobile' => $mobile,
            'user_status' => $status
        );
        $this->session->set_userdata($data);
    }

    // ใช้ update session
    public function user_session_update($id){
        $user = $this->get_user_by_id($id);
        if($user){
            $this->user_session_set($id,$user->user_email,$user->user_type,$user->user_mobile,$user->user_status); // เมื่อพบ user อัพเดทข้อมูลใหม่
        }else{
            $this->user_session_destroy(); // กรณีไม่พบ user นี้แล้ว ถูกลบออกจากระบบ
        }
    }

    public function user_session_destroy(){
        // unset($_SESSION['user_logged']);
        // unset($_SESSION['user_id']);
        // unset($_SESSION['user_email']);
        // $this->session->unset_userdata('userData');
        // $this->facebook->destroy_session();
        unset($_SESSION);
        session_destroy();
    }

    // เข้าสู่ระบบแล้ว
    public function already_login(){
        if(isset($_SESSION['user_logged'])){
            redirect('/');
        }
    }

    // ยังไม่ได้เข้าสู่ระบบ
    public function check_login(){
        if(!isset($_SESSION['user_logged'])){
            $this->session->set_flashdata('error','โปรดเข้าสู่ระบบก่อนใช้งานหน้านี้');
            redirect('auth/login');
        }
    }

    public function check_page_login(){
        if(!isset($_SESSION['user_logged'])){
            return false;
        }else{
            return true;
        }
    }

    public function check_password(){
        if(isset($_SESSION['user_logged'])){
            $user = $this->tb_user->get_user_by_id($_SESSION['user_id']);
            if($user != null){
                if($user->user_password == null){
                    redirect(base_url('user/editPassword'));
                }else{
                    redirect(base_url('main'), 'refresh');
                }
            }
        }
    }

    public function need_password(){
        if(isset($_SESSION['user_logged'])){
            $user = $this->tb_user->get_user_by_id($_SESSION['user_id']);
            if($user != null){
                if($user->user_password == null){
                    $this->session->set_flashdata('password','คุณยังไม่ได้ตั้งค่ารหัสผ่าน กรุณาเข้าไปเปลี่ยนรหัสผ่าน <a href="'.base_url('user/editPassword').'">คลิกที่นี่</a>');
                }else{
                    unset($_SESSION['password']);
                }
            }
        }
    }

    // ใช้เข้ารหัส
    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }
 
    // ใช้ตรวจสอบรหัส
    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }

}