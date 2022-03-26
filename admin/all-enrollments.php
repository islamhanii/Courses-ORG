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
            <h1 class="m-0 text-dark">All Enrollments</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= Globals::getURL(); ?>admin/index.php">Home</a></li>
              <li class="breadcrumb-item active">Enrollments</li>
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
            <div class="card">
                <div class="card-body table-responsive p-0" style="max-height: calc(100vh - 250px);">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <?php
                            $result = Db::select("reservations JOIN courses",
                                                 "reservations.id, reservations.name, reservations.email, reservations.created_at, courses.name AS courseName",
                                                 "", "reservations.course_id = courses.id");
                            $reservations = [];
                            if($result !== NULL) {
                                $reservations = $result;
                            }
                        ?>

                        <tbody>
                            <?php
                                if(count($reservations) > 0) {
                                    foreach($reservations as $key => $reservation) {
                            ?>
                            <tr>
                                <td class="align-middle"><?= $key+1; ?></td>
                                <td class="align-middle"><?= $reservation["name"]; ?></td>
                                <td class="align-middle"><?= $reservation["email"] ?></td>
                                <td class="align-middle"><?= $reservation["courseName"]; ?></a></td>
                                <td class="align-middle"><?= $reservation["created_at"]; ?></td>
                                <td class="align-middle">
                                        <a href="<?= Globals::getURL(); ?>admin/show-enrollment.php?id=<?= $reservation["id"]; ?>"><button class="btn btn-primary">SHOW</button></a>
                                </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
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

<?php require_once("" . Globals::getRoot() . "/admin/inc/footer.php"); ?>