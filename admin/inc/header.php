<?php
  session_start();
  include_once("../globals.php");
  if(!isset($_SESSION["adminName"])) Globals::redirectURL("admin/login.php");
  include_once("../globals.php");
  include_once("" . Globals::getRoot() . "/admin/inc/db-connect.php");
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>CoursesORG | Admin</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= Globals::getURL(); ?>admin/assets/css/fontawesome.all.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= Globals::getURL(); ?>admin/assets/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?= Globals::getURL(); ?>admin/assets/images/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CoursesORG</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= Globals::getURL(); ?>admin/assets/images/user-profile.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION["adminName"]; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= Globals::getURL(); ?>admin/all-categories.php" class="nav-link">
                  <i class="far fa-list-alt nav-icon"></i>
                  <p>All Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= Globals::getURL(); ?>admin/add-category.php" class="nav-link">
                  <i class="fas fa-plus-square nav-icon"></i>
                  <p>Add Category</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Courses
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= Globals::getURL(); ?>admin/all-courses.php" class="nav-link">
                  <i class="far fa-list-alt nav-icon"></i>
                  <p>All Courses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= Globals::getURL(); ?>admin/add-course.php" class="nav-link">
                  <i class="fas fa-plus-square nav-icon"></i>
                  <p>Add Course</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= Globals::getURL(); ?>admin/all-enrollments.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Enrollments</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= Globals::getURL(); ?>admin/edit-profile.php" class="nav-link">
              <i class="nav-icon fas fa-user-edit"></i>
              <p>Edit Profile</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= Globals::getURL(); ?>admin/logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Log out</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>