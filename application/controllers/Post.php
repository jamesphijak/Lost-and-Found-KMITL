<?php

class Post extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();
    }

    public function createLost(){
        $this->template->setTemplate('ลงประกาศของหาย', 'create_post');
        $this->template->loadTemplate();
    }

    public function createFound(){
        exit('Found');
    }

}

?>