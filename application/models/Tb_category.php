<?php

class Tb_category extends CI_Model{
	private $table = 'tb_category';

	public function __construct(){
        $this->load->database();
    }

    public function get_categories(){
        $this->db->order_by('category_id','asc'); // เรียงลำดับ
        return $this->db->get($this->table)->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    public function get_category_by_id($id){
        return $this->db->get_where($this->table, ['category_id' => $id])->row(); // select * from table where id = id
    }

    public function create_category($value){
        $this->db->insert($this->table, $value); // insert into
    }

    public function update_category($id, $value){
        $this->db->update($this->table, $value, ['category_id' => $id]); // update
    }

    public function delete_category($id){
        $this->db->delete($this->table, ['category_id' => $id]); // delete from table where id = id
    }
}

?>