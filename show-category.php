
<?php 
    require_once("globals.php");
    require_once("" . Globals::getRoot() . "/inc/header.php");

    
    $category = "No Category Found";
    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        $result = Db::select("cats", "name AS category", "id = '$id'");
        if($result !== NULL) {
            $category = $result[0]["category"];
        }
    }
?>

    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg overlay2">
        <h3><?php echo $category; ?></h3>
    </div>
    <!-- bradcam_area_end -->

    <!-- popular_courses_start -->
    <div class="popular_courses">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center mb-100">
                        <h3><?php echo $category; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="all_courses">
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <?php
                            $courses = [];
                            if(isset($id)) {
                                $result = Db::select("courses LEFT JOIN cats", "courses.id, courses.`name`, courses.img, cats.name AS category",
                                                     "cats.id = '$id'", "courses.cat_id = cats.id", "courses.id DESC");
                                if($result !== NULL) {
                                    $courses = $result;
                                }
                            }
                        ?>

                        <div class="row">
                            <?php foreach($courses as $course) { ?>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single_courses">
                                    <div class="thumb">
                                        <a href="<?= Globals::getURL(); ?>show-course.php?id=<?= $course["id"]; ?>">
                                            <img src="<?= Globals::getURL(); ?>uploads/courses/<?= $course["img"]; ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="courses_info">
                                        <span><?= $course["category"]; ?></span>
                                        <h3><a href="<?= Globals::getURL(); ?>show-course.php?id=<?= $course["id"]?>"><?= $course["name"]; ?></a></h3>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popular_courses_end-->
    
<?php require_once("" . Globals::getRoot() . "/inc/footer.php"); ?>