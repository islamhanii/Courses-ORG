<?php 
    include_once("inc/header.php");
    if($_SERVER["REQUEST_METHOD"] != "GET")   header("location: all-categories.php");

    $id = $_GET["id"];
    $sql = "SELECT * FROM cats WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)>0) {
        $category = mysqli_fetch_assoc($result);
    }
    else    header("location: all-categories.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Categories</a></li>
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
                    <h3 class="card-title">New Category</h3>
                    </div>

                    <form action="handlers/handle-edit-category.php?id=<?= $category["id"]; ?>" method="POST">
                        <div class="card-body">

                            <?php 
                                if(isset($_SESSION["failed"])) { 
                            ?>
                            <div class="alert alert-danger">
                                <P class="mb-0"><?= $_SESSION["failed"]; ?></P>
                            </div>
                            <?php 
                            unset($_SESSION["failed"]);
                            } ?>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name" value="<?= $category["name"]; ?>">
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Edit</button>
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