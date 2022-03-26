<?php 
    session_start();
    require_once("../globals.php");
    if(isset($_SESSION["adminName"]))   Globals::redirectURL("admin/index.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CoursesORG | Log in</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <link rel="stylesheet" href="<?= Globals::getURL(); ?>admin/assets/css/fontawesome.all.css">

        <link rel="stylesheet" href="<?= Globals::getURL(); ?>admin/assets/css/adminlte.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Courses</b>ORG</a>
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    
                    <?php if(isset($_SESSION["failed"])) {?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                                $errors = $_SESSION["failed"];
                                for($i=0; $i<count($errors); $i++) {
                                    echo "<p class='mb-0'>" . $errors[$i] . "</p>";
                                }
                                unset($_SESSION["failed"]);
                            ?>
                        </div>
                    <?php } ?>
                    <?php if(isset($_SESSION["login_error"])) {?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                                echo "<p class='mb-0'>" . $_SESSION["login_error"] . "</p>";
                                unset($_SESSION["login_error"]);
                            ?>
                        </div>
                    <?php }
                    if(isset($_SESSION["post_email"])) {
                        $email = $_SESSION["post_email"];
                        unset($_SESSION["post_email"]);
                    }
                    ?>

                    <form action="<?= Globals::getURL(); ?>admin/handlers/handle-login.php" method="post">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= (isset($email))?$email:""; ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <script src="<?= Globals::getURL(); ?>admin/assets/js/jquery.js"></script>

        <script src="<?= Globals::getURL(); ?>admin/assets/js//bootstrap.bundle.js"></script>

        <script src="<?= Globals::getURL(); ?>admin/assets/js/adminlte.js"></script>
    </body>
</html>
