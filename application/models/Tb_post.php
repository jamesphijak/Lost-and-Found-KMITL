<?php

class Tb_post extends CI_Model{
	private $table = 'tb_post';

	public function __construct(){
        $this->load->database();
    }

    public function get_posts(){
        $this->db->order_by('id','desc'); // เรียงลำดับ
        return $this->db->get($this->table)->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    public function get_post_like($like){
        $this->db->like($like);
        return $this->db->get($this->table)->result(); // // WHERE `title` LIKE '%match%' ESCAPE '!' AND  `page1` LIKE '%match%' ESCAPE '!' AND  `page2` LIKE '%match%' ESCAPE '!'
    }

    public function get_post_by_id($id){
        return $this->db->get_where($this->table, ['id' => $id])->row(); // select * from table where id = id
    }

    public function create_post($value){
        $this->db->insert($this->table, $value); // insert into
    }

    public function update_post($id, $value){
        $this->db->update($this->table, $value, ['id' => $id]); // update
    }

    public function delete_post($id){
        $this->db->delete($this->table, ['id' => $id]); // delete from table where id = id
    }
}

?>
