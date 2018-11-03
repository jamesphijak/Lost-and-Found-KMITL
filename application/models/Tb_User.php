<?php

class Tb_User extends CI_Model
{
    private $table = 'tb_user';
    const SALT = 'PNp04n5pEkuyhRHj5a3RTAIy9M6zGs06'; // https://randomkeygen.com/

    // ใช้สมัครสมาชิก
    public function user_register($value){
        // return $this->db->insert_id(); // return last id
        return $this->db->insert($this->table, $value); // insert into
    }

    // แก้ไขข้อมูลสมาชิก
    public function update_user($id, $value){
        $this->db->set('updated','now()', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        return $this->db->update($this->table, $value, ['id' => $id]); // update
    }

    // ใช้ดึงข้อมูลเข้าสู่ระบบ by user & pass
    public function user_login($value){
        return $this->db->get_where($this->table, $value)->row(); // select * from table where username password
    }

    // ใช้ดึงข้อมูล by id
    public function get_user_by_id($id){
        return $this->db->get_where($this->table, ['id' => $id])->row(); // select * from table where id = id
    }

    // ใช้ set session
    public function user_session_set($id,$email,$type){
        $data = array(
            'user_logged' => true,
            'user_id' => $id,
            'user_email' => $email,
            'user_type' => $type
        );
        $this->session->set_userdata($data);
    }

    // ใช้ update session
    public function user_session_update($id){
        $user = $this->get_user_by_id($id);
        if($user){
            $this->user_session_set($id,$user->email,$user->user_type); // เมื่อพบ user อัพเดทข้อมูลใหม่
        }else{
            $this->user_session_destroy(); // กรณีไม่พบ user นี้แล้ว ถูกลบออกจากระบบ
        }
    }

    public function user_session_destroy(){
        // unset($_SESSION['user_logged']);
        // unset($_SESSION['user_id']);
        // unset($_SESSION['user_email']);
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

    // ใช้เข้ารหัส
    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }
 
    // ใช้ตรวจสอบรหัส
    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }

}