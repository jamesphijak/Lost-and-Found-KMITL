<?php

class Main extends CI_Controller
{
    public function index()
    {
        $this->template->setTemplate('หน้าแรก', 'main');
        $this->template->loadTemplate();
    }
}

?>