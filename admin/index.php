<?php
    session_start();
    require_once("../globals.php");
    require_once("" . Globals::getRoot() . "/admin/inc/header.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <?php
                  $result = Db::select("cats", "COUNT(id) AS numCats");
                  $stats = 0;
                  if($result !== NULL) {
                    $stats = $result[0]["numCats"];
                  }
                ?>
                <h3><?= $stats; ?></h3>
                <p>New Categories</p>
              </div>
              <div class="icon">
                <i class="fas fa-sitemap"></i>
              </div>
              <a href="<?= Globals::getURL(); ?>admin/all-categories.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <?php
                  $result = Db::select("courses", "COUNT(id) AS numCourses");
                  $stats = 0;
                  if($result !== NULL) {
                    $stats = $result[0]["numCourses"];
                  }
                ?>
                <h3><?= $stats; ?></h3>
                <p>New Courses</p>
              </div>
              <div class="icon">
                <i class="fas fa-book"></i>
              </div>
              <a href="<?= Globals::getURL(); ?>admin/all-courses.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <?php
                  $result = Db::select("reservations", "COUNT(id) AS numReservations");
                  $stats = 0;
                  if($result !== NULL) {
                    $stats = $result[0]["numReservations"];
                  }
                ?>
                <h3><?= $stats; ?></h3>
                <p>New Enrollments</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="<?= Globals::getURL(); ?>admin/all-enrollments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php require_once("" . Globals::getRoot() . "/admin/inc/footer.php"); ?>