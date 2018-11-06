<?php

class Main extends CI_Controller
{
    public function index()
    {
        $title = 'หน้าแรก';
        $this->template->setHeader($title);
        $this->template->loadHeader();
        //pass parameter to profile
        $body = array(
            'title' => $title,
            'posts_lost' => $this->tb_post->get_posts_by_type_limit('lost','OK',3),
            'posts_found' => $this->tb_post->get_posts_by_type_limit('found','OK',3)
        );
        $this->load->view('main', $body);
        $this->template->loadFooter();
    }
}

?>