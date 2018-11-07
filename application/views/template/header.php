<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $app_name.' | '.$title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS loader section -->
    <link href="<?= base_url('assets/css/bootstrap.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/font/sukhumvit/sukhumvit.css')?>" rel="stylesheet">
    <!-- <link href="--><?//= base_url('assets/font/maledpan/maledpan.css')?><!--" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <!-- Javascript loader section -->
    <script src="<?= base_url('assets/js/jquery-3.3.1.js')?>"></script>
<!--    <script src="--><?//= base_url('assets/js/bootstrap.js')?><!--"></script>-->
    <script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js')?>"></script>


    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <style type="text/css">
        html, body{
            font-family: "<?= $font ?>"; // Maledpan
        }
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 60px; /* Margin bottom by footer height */
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: auto; /* Set the fixed height of the footer here */
            line-height: 60px; /* Vertically center the text there */
            background-color: #343a40;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary bg-primary fixed-top">
                <!-- Site name -->
                <a class="navbar-brand" style="font-size:22px;" href="<?= base_url() ?>"><i class="fas fa-search-location"></i> <?= $app_name ?></a>
                <!-- Mobile toggle icon -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- เมนูบน Top navigation bar -->
                <div class="collapse navbar-collapse" id="navbarMenu">
                    <ul class="navbar-nav mr-auto">
                        <!-- รายการประกาศ menu -->
                        <li class="nav-item active">
                            <a class="nav-link" style="font-size:18px;" href="<?= base_url('') ?>">
                                <i class="fas fa-home"></i> หน้าแรก
                            </a>
                        </li>

                    </ul>
                        <!-- ปุ่มก่อน Login -->
                        <?php if(!isset($_SESSION['user_logged'])){ ?>
                            <a href="<?= base_url('auth/login')?>" class="btn btn-outline-light"><i class="fas fa-key"></i> เข้าสู่ระบบ / สมัครสมาชิก</a>&nbsp;
                        <?php }else{ ?>
                        <!-- ปุ่มหลัง Login -->
                            <a href="<?= base_url('post/create/lost')?>" class="btn btn-outline-light"><i class="fas fa-plus-circle"></i> ประกาศของหาย</a>&nbsp;
                            <a href="<?= base_url('post/create/found')?>" class="btn btn-outline-light"><i class="fas fa-plus-circle"></i> ประกาศพบของ</a>
                        
                        &nbsp;
                        <ul class="navbar-nav mr-right">
                            <!-- เมนูส่วนตัว -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" style="font-size:18px;" href="#" id="dropdown-user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i> <?= $_SESSION['user_email'] ?></a>
                                <div class="dropdown-menu" aria-labelledby="dropdown-user">
                                    <!-- Admin -->
                                    <?php if($_SESSION['user_type'] == 'Admin'){?>
                                    <a class="dropdown-item" href="<?= base_url('admin')?>">
                                    หน้าจัดการของ Admin</a>
                                    <div class="dropdown-divider"></div>
                                    <?php } ?>

                                    <a class="dropdown-item" href="<?= base_url('user/profile')?>">จัดการข้อมูลส่วนตัว</a>
                                    <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">ออกจากระบบ</a>
                                </div>
                            </li>
                        </ul>
                        <?php } ?>
                </div>
            </nav>
        </div>
    </div>
</div>

<main role="main" class="container" style="margin-top:75px;">

