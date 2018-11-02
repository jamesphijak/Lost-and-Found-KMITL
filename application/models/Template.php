<?php

class Template extends CI_Model {
    private $app_name = 'Lost & Found';
    private $title = 'หน้าแรก';
    private $font = 'Sukhumvit';
    private $view = 'main';

    public function __construct(){}

    public function setTemplate($title,$view){
        $this->title = $title;
        $this->view = $view;
    }

    public function loadTemplate(){
        $header = array(
            'app_name' => $this->app_name,
            'title' => $this->title,
            'font' => $this->font
        );

        $body = array(
            'title' => $this->title,
        );

        $this->load->view('template/header',$header);
        $this->load->view($this->view,$body);
        $this->load->view('template/footer');
    }
}

?>