<?php

class User extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();
        
    }

}

?>