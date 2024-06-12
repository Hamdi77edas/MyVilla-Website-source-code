<?php
include "header.php";

$about=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='about'"))['info_value'];
$goal=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='goal'"))['info_value'];
$team=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='team'"))['info_value'];
$audience=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='audience'"))['info_value'];
$roles=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='roles'"))['info_value'];


?>



<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">MyVilla </h1>

</div>
<!-- Single Page Header End -->

<br>

<!-- Contact Start -->
<div class="container-fluid contact py-2">
    <div class="container py-1">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h2 class="text-primary">حولنا</h2>
                        <p class="mb-4" dir="rtl"><?php echo $about;?></p>
                    </div>
                </div>
                
                
                
                <div class="col-lg-12" dir="rtl">
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-sitemap fa-2x text-primary me-4"></i>
                        <div class="me-2">
                            <h4>الاهداف</h4>
                            <p class="mb-2" dir="rtl"><?php echo $goal;?></p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-handshake fa-2x text-primary me-4"></i>
                        <div class="me-2">
                            <h4>الفريق</h4>
                            <p class="mb-2" dir="rtl"><?php echo $team;?></p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded bg-white">
                        <i class="fa fa-users fa-2x text-primary me-4"></i>
                        <div class="me-2">
                            <h4>الجمهور المستهدف</h4>
                            <p class="mb-2" dir="rtl"><?php echo $audience;?></p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-handshake fa-2x text-primary me-4"></i>
                        <div class="me-2">
                            <h4>القوانين والقواعد</h4>
                            <p class="mb-2" dir="rtl"><?php echo $roles;?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->






<?php
include "footer.php";
?>
