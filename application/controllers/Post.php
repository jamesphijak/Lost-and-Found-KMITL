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

    public function loadLost(){
        // $servername = "localhost";
        // $username = "lostfoun_kmitl";
        // $password = "James0879723879";
        // $dbname = "lostfoun_lostfound";

        // $con = new mysqli($servername, $username, $password, $dbname);
        // if ($con->connect_error) {
        //     die("Connection failed: " . $con->connect_error);
        // }

        $q = $_GET['q'];

        $deq = json_decode($q, true);

            // $sql="SELECT * FROM tb_post WHERE category_id LIKE '%".$deq['type']."%' AND color_id LIKE '%".$deq['color']."%'" ;
            
            $like = array('category_id' => $deq['type'], 'color_id' => $deq['color']);
            $post_result = $this->tb_post->get_post_like($like);
            
            if($deq['text']==""&&$deq['color']==""&&$deq['type']==""){
                // echo "ไม่พบรายการที่คล้ายกัน";
                return;
            }

            // $result = mysqli_query($con,$sql);

            echo "<table class='table table-hover'>";
            foreach($post_result as $row) :
                echo "<tr class='clickable-row' data-href='viewLost.php?id=".$row->id."'>";
                echo "<td>" . $row->name . "</td>";
                echo "<td>" . $row->category_id. "</td>";
                echo "<td>" . $row->color_id . "</td>";
                //echo "<td><img style='width:50px;height:50px' src='picture/".$entry['row']."'>"."</td>";
                echo "</tr>";
            endforeach;
            echo "</table>";

            // echo "<table class='table table-hover'>";
            // while($entry = mysqli_fetch_array($result)){ 
            //     echo "<tr class='clickable-row' data-href='viewLost.php?id=".$entry['id']."'>";
            //     echo "<td>" . $entry['name'] . "</td>";
            //     echo "<td>" . $entry['category_id'] . "</td>";
            //     echo "<td>" . $entry['color_id'] . "</td>";
            //     echo "<td><img style='width:50px;height:50px' src='picture/".$entry['imgurl1']."'>"."</td>";
            //     echo "</tr>";
            // }
            // echo "</table>";
            // mysqli_close($con);

    }



}

?>