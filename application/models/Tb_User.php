<?php

class Tb_User extends CI_Model
{
    private $table = 'tb_user';

    public function create_user($value){
        $this->db->insert($this->table, $value); // insert into
        return $this->db->insert_id(); // return last id
    }
}