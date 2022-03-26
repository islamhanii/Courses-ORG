<?php
    if($_SERVER["REQUEST_URI"] === "/Courses-ORG/inc/header.php")   echo "<script> window.location.href = '../'; </script>";
    require_once("globals.php");
    Db::openConn();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CoursesORG | Web</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= Globals::getURL(); ?>assets/images/favicon.ico">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/nice-select.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/gijgo.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/slicknav.css">
    <link rel="stylesheet" href="<?= Globals::getURL(); ?>assets/css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid p-0">
                    <div class="row align-items-center no-gutters">
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo-img">
                                <a href="<?= Globals::getURL(); ?>index.php">
                                    <img src="<?= Globals::getURL(); ?>assets/images/logo.png" alt="">
                                </a>
                            </div>
                        </div>

                        <?php
                            $result = Db::select("cats", "*");
                            $cats = [];
                            if($result !== NULL) {
                                $cats = $result;
                            }
                        ?>

                        <div class="col-xl-7 col-lg-7">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a class="active" href="<?= Globals::getURL(); ?>index.php">home</a></li>
                                        <li><a href="<?= Globals::getURL(); ?>all-courses.php">All Courses</a></li>
                                        <li><a href="#">Categories <i class="ti-angle-down"></i></a>
                                            <?php if(count($cats)!=0) { ?>
                                            <ul class="submenu">
                                                <?php foreach($cats as $cat) { ?>
                                                        <li><a href="<?= Globals::getURL(); ?>show-category.php?id=<?= $cat["id"]; ?>"> <?= $cat["name"]; ?> </a></li>
                                                <?php } ?>
                                            </ul>
                                            <?php } ?>
                                        </li>
                                        <li><a href="<?= Globals::getURL(); ?>enroll.php">Enroll</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                            <div class="log_chat_area d-flex align-items-center">
                                <div class="live_chat_btn">
                                    <a class="boxed_btn_orange" href="<?= Globals::getURL(); ?>admin">
                                        <i class="fa fa-user-circle"></i>
                                        <span>I'm a Admin</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    