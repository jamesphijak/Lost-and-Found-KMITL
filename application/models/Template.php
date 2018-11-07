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


    public function thaiNormalDate($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }

    public function dayLeft($strDate){
        $date1=date_create(date("d-M-Y"));
        $date2=date_create($strDate);
        $diff=date_diff($date1,$date2);
        //return $diff->format("%R%a วัน"); + -
        return $diff->format("%a วัน");
    }

    public function thaiNormalDatetime($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
    }

    public function normalDate($date) {
		return date('d-M-Y', strtotime($date));
	}

	public function normalDatetime($date) {
		return date('d-M-Y H:i:s', strtotime($date));
	}


}

?>