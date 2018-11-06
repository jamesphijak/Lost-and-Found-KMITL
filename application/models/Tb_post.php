<?php

class Tb_post extends CI_Model{
	private $table = 'tb_post';

	public function __construct(){
        $this->load->database();
    }

    public function get_posts(){
        $this->db->order_by('post_id','desc'); // เรียงลำดับ
        return $this->db->get($this->table)->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    public function get_posts_by_type($type){
        $this->db->order_by('post_id','desc'); // เรียงลำดับ
        return $this->db->get_where($this->table, ['post_type' => $type])->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    public function get_posts_by_type_limit($type, $status,$limit){
        $this->db->order_by('post_id','desc'); // เรียงลำดับ
        $this->db->limit($limit,0);
        return $this->db->get_where($this->table, ['post_type' => $type,'post_status' => $status])->result(); // ดึงข้อมูลทั้งหมด , row = ดึงแค่ row เดียว
    }

    public function get_posts_by_status($status){
        $this->db->select('*');
        $this->db->from('tb_post as post');
        $this->db->join('tb_user as user','user.user_id = post.post_user_id','LEFT');
        $this->db->join('tb_color as color','color.color_id = post.post_color_id','LEFT');
        //$this->db->join('tb_color','tb_color.id=tb_post.color_id');
        $this->db->where('post.post_status',$status);
        $query=$this->db->get();
        return $query->result();
    }

    public function get_post_like($like){
        $this->db->like($like);
        return $this->db->get($this->table)->result(); // // WHERE `title` LIKE '%match%' ESCAPE '!' AND  `page1` LIKE '%match%' ESCAPE '!' AND  `page2` LIKE '%match%' ESCAPE '!'
    }

    public function get_post_by_id($id){
        return $this->db->get_where($this->table, ['post_id' => $id])->row(); // select * from table where id = id
    }

    public function create_post($value){
        return $this->db->insert($this->table, $value); // insert into
    }

    public function update_post($id, $value){
        $this->db->set('post_updated','now()', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        $this->db->set('post_expire','DATE_ADD(now(), INTERVAL 30 DAY)', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        $this->db->update($this->table, $value, ['post_id' => $id]); // update
    }

    public function delete_post($id){
        $this->db->delete($this->table, ['post_id' => $id]); // delete from table where id = id
    }
}

?>
