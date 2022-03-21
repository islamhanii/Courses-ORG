<?php
  include_once("inc/header.php");
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
                  $sql = "SELECT COUNT(id) AS numCats FROM cats";
                  $result = mysqli_query($connect, $sql);
                  $stats = 0;
                  if($result && mysqli_num_rows($result)) {
                    $stats = mysqli_fetch_row($result)[0];
                  }
                ?>
                <h3><?= $stats; ?></h3>
                <p>New Categories</p>
              </div>
              <div class="icon">
                <i class="fas fa-sitemap"></i>
              </div>
              <a href="all-categories.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <?php
                  $sql = "SELECT COUNT(id) AS numCats FROM courses";
                  $result = mysqli_query($connect, $sql);
                  $stats = 0;
                  if($result && mysqli_num_rows($result)) {
                    $stats = mysqli_fetch_row($result)[0];
                  }
                ?>
                <h3><?= $stats; ?></h3>
                <p>New Courses</p>
              </div>
              <div class="icon">
                <i class="fas fa-book"></i>
              </div>
              <a href="all-courses.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <?php
                  $sql = "SELECT COUNT(id) AS numCats FROM reservations";
                  $result = mysqli_query($connect, $sql);
                  $stats = 0;
                  if($result && mysqli_num_rows($result)) {
                    $stats = mysqli_fetch_row($result)[0];
                  }
                ?>
                <h3><?= $stats; ?></h3>
                <p>New Enrollments</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="all-enrollments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once("inc/footer.php"); ?>