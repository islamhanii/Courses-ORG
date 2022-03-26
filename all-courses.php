<?php 
    require_once("globals.php");
    require_once("" . Globals::getRoot() . "/inc/header.php");

    $result = Db::select("courses", "COUNT(id) AS count")[0]["count"];
    $count = ceil($result/3);

    $page = (isset($_GET["page"]))?$_GET["page"]:1;
    $page = ($page<1)?1:(($page>$count)?$count:$page);
    $offset = 3*($page-1);
?>

    <!-- bradcam_area_start -->
    <div class="bradcam_area breadcam_bg overlay2">
        <h3>Our Courses</h3>
    </div>
    <!-- bradcam_area_end -->

    <!-- popular_courses_start -->
    <div class="popular_courses">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section_title text-center mb-100">
                        <h3>All Courses</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="all_courses">
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"> 
                        <?php
                            $result = Db::select("courses JOIN cats", "courses.id, courses.`name`, courses.img, cats.name AS category",
                                                 "", "courses.cat_id = cats.id", "courses.id DESC", 3, $offset);
                            $courses = [];
                            if($result !== NULL) {
                                $courses = $result;
                            }
                        ?>

                        <div class="row">
                            <?php foreach($courses as $course) { ?>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single_courses">
                                    <div class="thumb">
                                        <a href="<?= Globals::getURL(); ?>show-course.php?id=<?= $course["id"]; ?>">
                                            <img src="<?= Globals::getURL(); ?>uploads/courses/<?php echo $course["img"]; ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="courses_info">
                                        <span><?= $course["category"]; ?></span>
                                        <h3><a href="<?= Globals::getURL(); ?>show-course.php?id=<?= $course["id"]?>"><?= $course["name"]; ?></a></h3>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="col-12">
                                <div class="text-center">
                                    <?php if($page > 1) { ?>
                                    <a href="<?= Globals::getURL(); ?>all-courses.php?page=<?= $page-1?>" class="btn btn-info">Previous</a>
                                    <?php } ?>
                                    <?php if($page < $count) { ?>
                                    <a href="<?= Globals::getURL(); ?>all-courses.php?page=<?= $page+1?>" class="btn btn-info">Next</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popular_courses_end-->
    
<?php require_once("" . Globals::getRoot() . "/inc/footer.php"); ?>