<?php

class My_form_validation extends CI_Form_validation{

    public function edit_unique($str, $field)
    {
        list($table, $field, $current_id) = explode(".", $params);
        $result = $this->CI->db->where($field, $value)->get($table)->row();
        return ($result && $result->id != $current_id) ? FALSE : TRUE;
    }

}