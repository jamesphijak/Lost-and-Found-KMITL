<?php

class Post extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->tb_user->check_login();
    }

    public function createLost(){
        $title = 'ลงประกาศของหาย';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        //pass parameter to profile
        $body = array(
            'title' => $title,
            'categories' => $this->tb_category->get_categories(),
            'colors' => $this->tb_color->get_colors()
        );
        $this->load->view('post/create_lost',$body);
        // $this->load->view('user/profile',$body);
        $this->template->loadFooter();
    }

    public function createFound(){
        exit('Found');
    }

}

?>