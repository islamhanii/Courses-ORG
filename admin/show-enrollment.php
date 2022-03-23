<?php 
  include_once("../globals.php");
  include_once("" . Globals::getRoot() . "/admin/inc/header.php");
  if($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET["id"]))  Globals::redirectURL("admin/all-enrollments.php");

  $id = $_GET["id"];
  $sql = "SELECT reservations.*, courses.name AS courseName FROM reservations JOIN courses ON reservations.course_id = courses.id WHERE reservations.id = $id";
  $result = mysqli_query($connect, $sql);
  if($result && mysqli_num_rows($result)>0) {
    $student = mysqli_fetch_assoc($result);
  }
  else {
    Globals::redirectURL("admin/all-enrollments.php");
  }
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Show Enrollment</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= Globals::getURL(); ?>index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= Globals::getURL(); ?>all-enrollments.php">Enrollments</a></li>
              <li class="breadcrumb-item active">Show</li>
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
        <div class="col-12">
            <div class="card mb-3" style="max-width: 600px;">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center justify-content-center card-body">
                        <i class="fas fa-user-circle" style="font-size: 120px;"></i>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <h5 class="card-title mb-4"><strong> <?= $student["name"]; ?> </strong></h5>
                            <p class="card-text"><strong>Email: </strong> <?= $student["email"]; ?></p>
                            <p class="card-text"><strong>Phone: </strong> <?= $student["phone"]; ?></p>
                            <p class="card-text"><strong>Course: </strong> <?= $student["courseName"]; ?></p>
                            <p class="card-text"><strong>Speciality: </strong> <?= ($student["spec"]!==NULL)?$student["spec"]: "UNKNOWN"; ?></p>
                            <?php
                              $date1 = $student["created_at"];
                              $date2 = date("Y-m-d h:i:sa");
                              
                              $diff = abs(strtotime("now") - strtotime($date1));
                              
                              $days = floor($diff / (60*60*24));
                            ?>
                            <p class="card-text"><small class="text-muted">Enrolled from <?= $days; ?> days ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once("" . Globals::getRoot() . "/admin/inc/footer.php"); ?>