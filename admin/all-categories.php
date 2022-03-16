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
            <h1 class="m-0 text-dark">All Categories</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Category</li>
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
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <?php
                            $sql = "SELECT * FROM cats";
                            $result = mysqli_query($connect, $sql);
                            $cats = [];
                            if(mysqli_num_rows($result)>0) {
                                $cats = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                        ?>

                        <tbody>
                            <?php
                                if(count($cats) > 0) {
                                    foreach($cats as $key => $cat) {
                            ?>
                            <tr>
                                <td><?= $key+1; ?></td>
                                <td><?= $cat["name"]; ?></td>
                                <td><?= $cat["created_at"]; ?></td>
                                <td>
                                        <a href="edit-category.php?id=<?= $cat["id"]; ?>"><button class="btn btn-info">EDIT</button></a>
                                        <a href="delete-category.php?id=<?= $cat["id"]; ?>"><button class="btn btn-danger">DELETE</button></a>
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