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
            <h1 class="m-0 text-dark">All Courses</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
                            $sql = "SELECT courses.id, courses.name, courses.img, courses.created_at, cats.id AS catID, cats.name AS catName
                            FROM courses JOIN cats
                            ON courses.cat_id = cats.id;";
                            $result = mysqli_query($connect, $sql);
                            $courses = [];
                            if($result && mysqli_num_rows($result)>0) {
                                $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                                <td class="align-middle"><img src="../uploads/courses/<?= $course["img"]; ?>" alt="<?= $course["img"]; ?>" width="75px"/></td>
                                <td class="align-middle"><a href="../show-category.php?id=<?= $course["catID"]; ?>"><?= $course["catName"]; ?></a></td>
                                <td class="align-middle"><?= $course["created_at"]; ?></td>
                                <td class="align-middle">
                                        <a href="edit-course.php?id=<?= $course["id"]; ?>"><button class="btn btn-info">EDIT</button></a>
                                        <a href="delete-course.php?id=<?= $course["id"]; ?>"><button class="btn btn-danger">DELETE</button></a>
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

<?php include_once("inc/footer.php"); ?>