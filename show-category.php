
<?php 
    include_once("inc/header.php");

    
    $category = "No Category Found";
    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT name AS category FROM cats
            WHERE id = {$id}";
        $result = mysqli_query($connect, $sql);
        if($result && mysqli_num_rows($result)>0) {
            $category = mysqli_fetch_row($result)[0];
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
                                $sql = "SELECT courses.id, courses.`name`, courses.img, cats.name AS category
                                        FROM courses LEFT JOIN cats
                                        ON courses.cat_id = cats.id
                                        WHERE cats.id = {$id}
                                        ORDER BY courses.id DESC";
                                $result = mysqli_query($connect, $sql);
                                if($result && mysqli_num_rows($result)>0) {
                                    $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                }
                            }
                        ?>

                        <div class="row">
                            <?php foreach($courses as $course) { ?>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single_courses">
                                    <div class="thumb">
                                        <a href="show-course.php?id=<?= $course["id"]; ?>">
                                            <img src="assets/images/<?php echo $course["img"]; ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="courses_info">
                                        <span><?= $course["category"]; ?></span>
                                        <h3><a href="show-course.php?id=<?= $course["id"]?>"><?= $course["name"]; ?></a></h3>
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
    
<?php include_once("inc/footer.php"); ?>