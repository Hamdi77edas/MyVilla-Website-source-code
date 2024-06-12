<?php
include "header.php";
?>

<?php
if($_GET['search']!="yes")
{
?>
<!-- Hero Start -->
<div class="container-fluid py-2 mb-1 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7" dir="rtl">
                <h4 class="mb-3 text-secondary">أهلاً وسهلاً بكم زوارنا </h4>
                <h1 class="mb-5 display-5 text-primary">الموقع مختص في عرض وتأجير الفلل في فلسطين</h1>
                <div class="position-relative mx-auto" dir="rtl">
                    <?php
                    if(empty($_SESSION['user_type']))
                    {
                    ?>
                    
                    <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100 " onclick="location.href='signin.php';" style="top: 0; left: 25%;height:66px !important;">تسجيل دخول</button>
                    <?php
                    }
                    ?>
                    <?php
                    if($_SESSION['user_type']==1 ||$_SESSION['user_type']==2)
                    {
                      $your_name=mysqli_fetch_array(mysqli_query($connect,"SELECT concat(first_name,' ',family_name) as name FROM users WHERE 1 AND id=".intval($_SESSION['user_id'])))['name'];
                    ?>
                    
                    
                    <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" onclick="location.href='?action=logout';" style="top: 0; left: 25%;height:66px !important;">تسجيل خروج</button>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $sql="SELECT * FROM adv WHERE 1 ";
                        $query = mysqli_query($connect, $sql);
                        $first='active';
                        while ($row = mysqli_fetch_array($query)) 
                        {
                        ?>
                        <div class="carousel-item <?php echo $first;?> rounded">
                            <img src="DRIVE/<?php echo $row['img'];?>" class="img-fluid w-100 h-100 bg-secondary rounded" style="height:300px !important;" alt="First slide">
                            <a href="#" class="btn px-1 py-1 text-white rounded " style="font-size:1.0em;margin-left:90px !important;background:#8FE3C6bb !important;color:#fff !important;text-shadow:0px 0px 3px #000;"><?php echo $row['topic'];?></a>
                        </div>
                        <?php
                        $first='';
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<?php
}
else
{
?>
<div class="container-fluid py-2 mb-1 ">
    <div class="container py-5">

    </div>
</div>
<?php
}
?>


<?php
include "shop_subPage.php";
?>







<?php
include "footer.php";
?>
