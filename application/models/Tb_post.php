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

    public function get_posts_by_field_limit($field_name,$field_value, $status,$limit){
        $this->db->select('*');
        $this->db->from('tb_post as post');
        $this->db->join('tb_user as user','user.user_id = post.post_user_id','LEFT');
        $this->db->join('tb_category as category','category.category_id = post.post_category_id','LEFT');
        $this->db->join('tb_color as color','color.color_id = post.post_color_id','LEFT');
        $this->db->where($field_name,$field_value);
        if($status != '') {
            $this->db->where('post.post_approve', $status);
        }
        $this->db->where('post.post_status', "Wait"); // Need to find
        $this->db->where('post.post_is_expire', 0); // Non Expire
        if($limit != 0) {
            $this->db->limit($limit, 0);
        }
        $this->db->order_by('post.post_updated','desc'); // เรียงลำดับ
        $query=$this->db->get();
        return $query->result();
    }

    public function get_my_post($field_name,$field_value){
        $this->db->select('*');
        $this->db->from('tb_post as post');
        $this->db->join('tb_user as user','user.user_id = post.post_user_id','LEFT');
        $this->db->join('tb_category as category','category.category_id = post.post_category_id','LEFT');
        $this->db->join('tb_color as color','color.color_id = post.post_color_id','LEFT');
        $this->db->where($field_name,$field_value);
        $this->db->order_by('post.post_id','desc'); // เรียงลำดับ
        $query=$this->db->get();
        return $query->result();
    }

    public function get_posts_by_status($status){
        $this->db->select('*');
        $this->db->from('tb_post as post');
        $this->db->join('tb_user as user','user.user_id = post.post_user_id','LEFT');
        $this->db->join('tb_color as color','color.color_id = post.post_color_id','LEFT');
        $this->db->join('tb_category as category','category.category_id = post.post_category_id','LEFT');
        $this->db->where('post.post_status',$status);
        $query=$this->db->get();
        return $query->result();
    }

    public function get_posts_by_approve($status){
        $this->db->select('*');
        $this->db->from('tb_post as post');
        $this->db->join('tb_user as user','user.user_id = post.post_user_id','LEFT');
        $this->db->join('tb_color as color','color.color_id = post.post_color_id','LEFT');
        $this->db->join('tb_category as category','category.category_id = post.post_category_id','LEFT');
        $this->db->where('post.post_approve',$status);
        $query=$this->db->get();
        return $query->result();
    }

    public function get_post_by_id($id){
        $this->db->select('*');
        $this->db->from('tb_post as post');
        $this->db->join('tb_category as category','category.category_id = post.post_category_id','LEFT');
        $this->db->join('tb_color as color','color.color_id = post.post_color_id','LEFT');
        $this->db->where('post.post_id',$id);
        $query=$this->db->get();
        return $query->row();
    }

    public function get_post_like($like){
        $this->db->like($like);
        $this->db->where('post_approve', 'Approve');
        $this->db->where('post_status', 'Wait'); // Need to find
        $this->db->where('post_is_expire', 0); // Non Expire
        return $this->db->get($this->table)->result(); // // WHERE `title` LIKE '%match%' ESCAPE '!' AND  `page1` LIKE '%match%' ESCAPE '!' AND  `page2` LIKE '%match%' ESCAPE '!'
    }

    public function update_expire_post(){
//        foreach ($this->get_posts() as $post) {
//            echo $post->post_id.':'.$post->post_is_expire.' <br>';
//        }
//
//        echo "=========================<br>";

        foreach ($this->get_posts() as $post) {
            // Loop to find expire
            if($this->template->findDayLeft($post->post_expire) == "-") {
                //echo $post->post_id.' expire <br>';
                $count = (int)($this->template->dayLeft($post->post_expire));
                $count = $count+1;
                if($count > 10) { // 10 วัน remove
                    // remove
                    //echo $count." Remove ".$post->post_id."<br>";
                    //exit();
                    $this->tb_post->delete_post($post->post_id);
                    $this->tb_comment->delete_comment_post($post->post_id);
                }else{
                    //echo $count." Non ".$post->post_id."<br>";
                    //exit();
                    $this->update_post($post->post_id, array('post_is_expire' => 1));
                }
            }else{
                $this->update_post($post->post_id,array('post_is_expire' => 0));
            }
	    }

//        foreach ($this->get_posts() as $post) {
//            echo $post->post_id.':'.$post->post_is_expire.' <br>';
//        }

    }

    public function renew_post($id){
        $this->db->set('post_expire','DATE_ADD(now(), INTERVAL 30 DAY)', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        $this->db->update($this->table); // update
        $this->db->where('post_id', $id);
        return $this->db->affected_rows();
    }

    public function create_post($value){
        $this->db->set('post_expire','DATE_ADD(now(), INTERVAL 30 DAY)', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        $this->db->insert($this->table, $value);
        $insert_id = $this->db->insert_id();
        return $insert_id; // insert into
    }

    public function update_post($id, $value){
        $this->db->set('post_updated','now()', false); // set update ล่าสุด ใส่ false ให้มองเป็น code
        if(isset($value['post_approve'])) {
            if ($value['post_approve'] == 'Approve') {
                $this->db->set('post_expire', 'DATE_ADD(now(), INTERVAL 30 DAY)', false);
            }
        }
        //$this->db->set('post_expire','DATE_ADD(now(), INTERVAL 30 DAY)', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        $this->db->update($this->table, $value, ['post_id' => $id]); // update
        return $this->db->affected_rows();
    }

    public function update_post_status($id, $value){
        $this->db->set('post_updated','now()', false); // set update ล่าสุด ใส่ false ให้มองเป็น code sql
        $this->db->update($this->table, $value, ['post_id' => $id]); // update
        return $this->db->affected_rows();
    }

    public function delete_post($id){
        $this->db->delete($this->table, ['post_id' => $id]); // delete from table where id = id
    }
}

?>
