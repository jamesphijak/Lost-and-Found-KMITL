<?php

class Tb_color extends CI_Model{
	private $table = 'tb_color';

	public function __construct(){
        $this->load->database();
    }

    public function get_colors(){
        $this->db->order_by('id','desc'); // เรียงลำดับ
        return $this->db->get($this->table)->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    public function get_color_by_id($id){
        return $this->db->get_where($this->table, ['id' => $id])->row(); // select * from table where id = id
    }

    public function create_color($value){
        $this->db->insert($this->table, $value); // insert into
    }

    public function update_color($id, $value){
        $this->db->update($this->table, $value, ['id' => $id]); // update
    }

    public function delete_color($id){
        $this->db->delete($this->table, ['id' => $id]); // delete from table where id = id
    }
}

?>