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
            <h1 class="m-0 text-dark">All Courses</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= Globals::getURL(); ?>admin/index.php">Home</a></li>
              <li class="breadcrumb-item active">Courses</li>
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
            <?php 
                if(isset($_SESSION["failed"])) { 
            ?>
            <div class="alert alert-danger">
                <P class="mb-0"><?= $_SESSION["failed"]; ?></P>
            </div>
            <?php 
            unset($_SESSION["failed"]);
            } ?>
            
            <?php if(isset($_SESSION["success"])) { ?>
            <div class="alert alert-success">
                <P class="mb-0"><?= $_SESSION["success"]; ?></P>
            </div>
            <?php 
            unset($_SESSION["success"]);
            } ?>
            <div class="card">
                <div class="card-body table-responsive p-0" style="max-height: calc(100vh - 250px);">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Course</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <?php
                            $result = Db::select("courses JOIN cats", "courses.id, courses.name, courses.img, courses.created_at, cats.id AS catID, cats.name AS catName",
                                                 "", "courses.cat_id = cats.id");
                            $courses = [];
                            if($result !== NULL) {
                                $courses = $result;
                            }
                        ?>

                        <tbody>
                            <?php
                                if(count($courses) > 0) {
                                    foreach($courses as $key => $course) {
                            ?>
                            <tr>
                                <td class="align-middle"><?= $key+1; ?></td>
                                <td class="align-middle"><?= $course["name"]; ?></td>
                                <td class="align-middle"><img src="<?= Globals::getURL(); ?>uploads/courses/<?= $course["img"]; ?>" alt="<?= $course["img"]; ?>" width="75px"/></td>
                                <td class="align-middle"><a href="<?= Globals::getURL(); ?>show-category.php?id=<?= $course["catID"]; ?>"><?= $course["catName"]; ?></a></td>
                                <td class="align-middle"><?= $course["created_at"]; ?></td>
                                <td class="align-middle">
                                        <a href="<?= Globals::getURL(); ?>admin/edit-course.php?id=<?= $course["id"]; ?>"><button class="btn btn-info">EDIT</button></a>
                                        <a href="<?= Globals::getURL(); ?>admin/delete-course.php?id=<?= $course["id"]; ?>"><button class="btn btn-danger">DELETE</button></a>
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