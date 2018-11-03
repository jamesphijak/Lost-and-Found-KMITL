<?php

class Template extends CI_Model {
    private $app_name = 'Lost & Found KMITL';
    private $title = 'หน้าแรก';
    private $font = 'Sukhumvit';
    private $view = 'main';

    public function __construct(){}

    public function setTemplate($title,$view){
        $this->title = $title;
        $this->view = $view;
    }

    public function loadTemplate(){
        $this->loadHeader();

        $body = array(
            'title' => $this->title,
        );

        $this->load->view($this->view,$body);
        $this->loadFooter();
    }

    public function setHeader($title){
        $this->title = $title;
    }

    public function loadHeader(){
        $header = array(
            'app_name' => $this->app_name,
            'title' => $this->title,
            'font' => $this->font
        );

        // Update session when refresh page
        if(isset($_SESSION['user_id'])){
            $this->tb_user->user_session_update($_SESSION['user_id']);
        }

        $this->load->view('template/header',$header);
    }

    public function loadFooter(){
        $this->load->view('template/footer');
    }

    public function normalDate($date) {
		return date('d-M-Y', strtotime($date));
	}

	public function normalDatetime($date) {
		return date('d-M-Y H:i:s', strtotime($date));
	}


}

?>