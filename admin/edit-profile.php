<?php 
  session_start();
  require_once("../globals.php");
  require_once("" . Globals::getRoot() . "/admin/inc/header.php");

  $id = $_SESSION["adminID"];
  $result = Db::select("admins", "*", "id = '$id'");
  if($result !== NULL) {
    $admin = $result[0];
  }
  else  Globals::redirectURL("admin/login.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= Globals::getURL(); ?>admin/index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Profile</a></li>
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
                    <h3 class="card-title">Edit Profile</h3>
                    </div>

                    <form action="<?= Globals::getURL(); ?>admin/handlers/handle-edit-profile.php" method="POST">
                        <div class="card-body">
                            <?php if(isset($_SESSION["failed"])) { ?>
                            
                            <div class="alert alert-danger">

                            <?php
                                    $errors = $_SESSION["failed"];
                                    for($i=0; $i<count($errors); $i++) {
                                        echo "<p class='mb-0'>" . $errors[$i] . "</p>";
                                    }
                                    unset($_SESSION["failed"]);
                            ?>
                            </div>
                            <?php } ?>

                            <?php if(isset($_SESSION["success"])) { ?>
                            <div class="alert alert-success">
                                <P class="mb-0"><?= $_SESSION["success"]; ?></P>
                            </div>
                            <?php 
                            unset($_SESSION["success"]);
                            } ?>

                            <div class="form-group">
                                <label for="exampleInputName1">Admin Name*</label>
                                <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Enter name" value="<?= (isset($admin["name"]))?$admin["name"]:""; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Admin Email*</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?= (isset($admin["email"]))?$admin["email"]:""; ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter password">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword2">Password-Confirmation</label>
                                <input type="password" name="password-confirmation" class="form-control" id="exampleInputPassword2" placeholder="Enter password confirmation">
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

<?php require_once("" . Globals::getRoot() . "/admin/inc/footer.php"); ?>