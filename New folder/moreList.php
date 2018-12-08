<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Krub" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="jsAll.js"></script>
        <title>Lost & Found KMITL</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            *[data-href] {
                cursor: pointer;
              }
        </style>
    </head>
    <body>
        <?php include 'func.php';
            $type = $_GET['type'];
            //connect_sql
            $con = connect();
            
            if($type=='lost'){
                $result = showLostItems($con);
            }
            else{
                $result = showFoundItems($con);
            }
        ?>
        <form name="form" action="" method="get" hidden>
            <input type="number" name="count" id="count" value="" hidden>
        </form>
        <nav class="navbar navbar-expand-lg navbar-light bg-lnf">
            <a class="navbar-brand" href="index.html" style="color: white"> Lost & Found KMITL</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto"></ul>
                <form class="form-inline my-2 my-lg-0">
                    <a class="btn btn-outline-light my-2 my-sm-0" href="register.html" role="button"> เข้าสู่ระบบ / สมัครสมาชิก </a>
                </form>
            </div>
        </nav>
        <h1 class="headLine">ประกาศของหาย</h1>
        <div class="container">      
            <table class="table table-hover"  style="width: 100%">
                <thead>
                    <tr>
                        <th style='width:20%'>ชื่อสิ่งของ</th>
                        <th style='width:15%'>หมวดหมู่</th>
                        <th style='width:15%'>สี</th>
                        <th style='width:20%'>รูปภาพ</th>
                        <th style='width:20%'>วันที่ประกาศ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($entry = mysqli_fetch_array($result)){ 
                            echo "<tr class='clickable-row' data-href='item.php?id=".$entry['id']."'>";
                            echo "<td>" . $entry['name'] . "</td>";
                            echo "<td>" . $entry['category_id'] . "</td>";
                            echo "<td>" . $entry['color_id'] . "</td>";
                            echo "<td><img class='imgBorder' src='picture/".$entry['imgurl1']."'>"."</td>";
                            echo "<td>" . $entry['create_at'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div><br><br>
        <div class="footer">Copyright © 2018 Lost & Found KMITL. All rights reserved.</div>
    </body>
</html>
