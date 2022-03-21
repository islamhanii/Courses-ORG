<?php 
  include_once("inc/header.php");
  if($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET["id"]))   header("location: all-courses.php");

  $id = $_GET["id"];
  $sql = "SELECT * FROM courses WHERE id = {$id}";
  $result = mysqli_query($connect, $sql);
  if($result && mysqli_num_rows($result)>0) {
    $course = mysqli_fetch_assoc($result);
  }
  else  header("location: all-courses.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Course</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="all-courses.php">Courses</a></li>
              <li class="breadcrumb-item active">Edit</li>
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
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Edit Course</h3>
                    </div>

                    <form action="handlers/handle-edit-course.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <?php if(isset($_SESSION["failed"])) { ?>
                            
                            <div class="alert alert-danger">

                            <?php
                                    $post = $_SESSION["post"];
                                    unset($_SESSION["post"]);
                                    $errors = $_SESSION["failed"];
                                    for($i=0; $i<count($errors); $i++) {
                                        echo "<p class='mb-0'>" . $errors[$i] . "</p>";
                                    }
                                    unset($_SESSION["failed"]);
                            ?>
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <label for="exampleInputName1">Course Name*</label>
                                <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Enter name" value="<?= (isset($post["name"]))?$post["name"]:((isset($course["name"]))?$course["name"]:""); ?>">
                            </div>

                            <div class="form-group">
                              <label for="exampleInputDesc1">Description*</label>
                              <textarea class="form-control" id="exampleInputDesc1" name="desc" placeholder="Enter description"><?= (isset($post["desc"]))?$post["desc"]:((isset($course["desc"]))?$course["desc"]:""); ?></textarea>
                            </div>

                            <?php 
                                $sql = "SELECT id, `name` FROM cats";
                                $result = mysqli_query($connect, $sql);
                                $cats = [];
                                if($result && mysqli_num_rows($result)) {
                                    $cats = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                }
                            ?>

                            <div class="form-group">
                                <label for="spec">Category*</label>
                                <select class="form-control valid" name="cat_id" id="cat_id"?>">
                                    <option selected disabled>Choose Option</option>
                                    <?php foreach($cats as $cat) { ?>
                                    <option <?= (($course["cat_id"] == $cat["id"])||(isset($post["cat_id"]) && $post["cat_id"] == $cat["id"]))?"selected":"" ?> value="<?= $cat["id"]; ?>"><?= $cat["name"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputFile">Image</label>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" name="img" class="custom-file-input" id="exampleInputFile">
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
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