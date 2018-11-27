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

    public function get_comment_by_id($id){
        return $this->db->get_where($this->table, ['comment_id' => $id])->row(); // select * from table where id = id
    }

    public function get_comments_by_post_id($parent_comment_id,$post_id,$sort){
        $this->db->select('*');
        $this->db->from('tb_comment as comment');
        $this->db->join('tb_user as user','user.user_id = comment.comment_user_id','LEFT');
        $this->db->where('comment.comment_parent_id',$parent_comment_id);
        $this->db->where('comment.comment_post_id',$post_id);
        $this->db->order_by('comment.comment_id',$sort); // เรียงลำดับ
        $query=$this->db->get();
        return $query->result();
    }

    public function get_color_by_id($id){
        return $this->db->get_where($this->table, ['color_id' => $id])->row(); // select * from table where id = id
    }

    public function create_comment($comment_parent_id,$comment_text,$user_id,$post_id){
        $value = array(
                    'comment_parent_id' => $comment_parent_id,
                    'comment_text' => $comment_text,
                    'comment_user_id' => $user_id,
                    'comment_post_id' => $post_id
                );
        $this->db->insert($this->table, $value); // insert into
        return $this->db->insert_id(); // return last insert record id
    }

    public function update_comment($id, $value){
        $this->db->update($this->table, $value, ['comment_id' => $id]); // update
    }

    public function delete_comment($id){
        $this->db->delete($this->table, ['comment_id' => $id]); // delete from table where id = id
    }

    public function delete_comment_post($post_id){
        $this->db->delete($this->table, ['comment_post_id' => $post_id]); // delete from table where id = id
    }

    public function delete_comment_child($parent_id){
        $this->db->delete($this->table, ['comment_parent_id' => $parent_id]); // delete from table where id = id
    }
}

?>