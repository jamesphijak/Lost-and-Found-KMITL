<?php

class Tb_comment extends CI_Model{
	private $table = 'tb_comment';

	public function __construct(){
        $this->load->database();
    }


    public function get_comments($post_id, $parent_id){
        $this->db->order_by('comment_id','asc'); // เรียงลำดับ
        return $this->db->get_where($this->table, ['comment_post_id' => $post_id,'comment_parent_id' => $parent_id])->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    public function get_color_by_id($id){
        return $this->db->get_where($this->table, ['color_id' => $id])->row(); // select * from table where id = id
    }

    public function create_comment($value){
        $this->db->insert($this->table, $value); // insert into
    }

    public function update_color($id, $value){
        $this->db->update($this->table, $value, ['color_id' => $id]); // update
    }

    public function delete_color($id){
        $this->db->delete($this->table, ['color_id' => $id]); // delete from table where id = id
    }
}

?>