<?php 
    session_start();
    require_once("globals.php");
    require_once("" . Globals::getRoot() . "/inc/header.php");
?>
    
        <!-- bradcam_area_start -->
        <div class="bradcam_area breadcam_bg overlay2">
                <h3>Enroll</h3>
            </div>
            <!-- bradcam_area_end -->

    <!-- ================ contact section start ================= -->
    <section class="contact-section">
            <div class="container">
    
                <div class="row">
                    <div class="col-12">
                        <h2 class="contact-title">Enroll</h2>
                    </div>
                    <div class="col-lg-8">
                        <?php if(isset($_SESSION["failed"])) {?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                                $errors = $_SESSION["failed"];
                                for($i=0; $i<count($errors); $i++) {
                                    echo "<p class='mb-0'>" . $errors[$i] . "</p>";
                                }
                                unset($_SESSION["failed"]);
                                if(isset($_SESSION["post"])) {
                                    $post = $_SESSION["post"];
                                    unset($_SESSION["post"]);
                                }
                            ?>
                        </div>
                        <?php } ?>
                        <?php if(isset($_SESSION["success"])) {?>
                        <div class="alert alert-success" role="alert">
                            <p class="mb-0">
                            <?php
                                echo $_SESSION["success"];
                                unset($_SESSION["success"]);
                            ?>
                            </p>
                        </div>
                        <?php }
                        ?>
                    </div>
                        
                    <div class="col-lg-8">
                        <form class="form-contact contact_form" action="<?= Globals::getURL(); ?>handlers/handle-enroll.php" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="name" id="name" type="text"  placeholder="Enter your name" value="<?= (isset($post["name"]))?$post["name"]:""; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="email" id="email" type="email"  placeholder="Email" value="<?= (isset($post["email"]))?$post["email"]:""; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="phone" id="phone" type="phone" placeholder="Phone"  value="<?= (isset($post["phone"]))?$post["phone"]:""; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="spec" id="spec" type="spec" placeholder="Speciality" value="<?= (isset($post["spec"]))?$post["spec"]:""; ?>">
                                    </div>
                                </div>

                                <?php
                                    $result =Db::select("courses", "id, `name`");
                                    $courses = [];
                                    if($result !== NULL) {
                                        $courses = $result;
                                    }
                                ?>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="spec">Courses:</label>
                                        <select class="form-control valid" name="course_id" id="course_id"?>">
                                            <option selected disabled>Choose Option</option>
                                            <?php foreach($courses as $course) { ?>
                                            <option <?= (isset($post["course_id"]) && $post["course_id"] == $course["id"])?"selected":"" ?> value="<?= $course["id"]; ?>"><?= $course["name"]; ?></option>
                                            <?php } ?>
                                        </select>
                
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button name="submit" type="submit" class="button button-contactForm boxed-btn">Send</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-home"></i></span>
                            <div class="media-body">
                                <h3>Buttonwood, California.</h3>
                                <p>Rosemead, CA 91770</p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                            <div class="media-body">
                                <h3>+1 253 565 2365</h3>
                                <p>Mon to Fri 9am to 6pm</p>
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-email"></i></span>
                            <div class="media-body">
                                <h3>support@colorlib.com</h3>
                                <p>Send us your query anytime!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php require_once("" . Globals::getRoot() . "/inc/footer.php"); ?>