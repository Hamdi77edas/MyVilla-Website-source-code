<!DOCTYPE html>
<?php
include "config.php";

if($_GET['action']=="logout")
{
  session_destroy();
  sleep(1);
  header("Location: index.php");
  exit(); 
}
?>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>My Villa</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/css/font-style.css">
        
    </head>

    <body>

        <!-- Spinner Start >
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="area"></div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar start -->
        <div class="container-fluid fixed-top px-0 mx-0" style="padding:0px !important;width:100% !important;">
            <div class="container topbar bg-primary " dir="rtl" style="width:100% !important;">
                <div class="d-flex justify-content-between" style="">
                    <div class="top-info ps-1" style="font-size: 1.1em; font-weight: bold;">
                        <small class="me-1"><i class="fas fa-map-marker-alt me-1 text-white"></i> <a href="#" class="text-white">فلسطين</a> </small>
                    </div>
                    <?php
                    if(empty($_SESSION['user_type']))
                    {
                    ?>
                    <div class="top-link" style="color: white;">
                          <i class="fa fa-check" style="margin-left:11px;font-size:1.2em;"></i>        تحتاج الى إنشاء حساب لطلب حجز في الموقع
 
                    </div>
                    <?php
                    }
                    else
                    {
                    ?>
                          <div class="top-link" style="color: white;">
                          <i class="fa fa-clock" style="margin-left:11px;font-size:1.2em;"></i>        أهلاً بك في حسابك
 
                    </div>
                    <?php
                    }
                    ?>
                    
                </div>
            </div>


            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl" dir="rtl" >
                    
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            
                            
                            <?php
                            if(empty($_SESSION['user_type']))
                            {
                            ?>
                            <a href="index.php" class="nav-item nav-link active" style="border-left:1px solid #aaa;" > <i class="fa fa-home"></i> الصفحة الرئيسية  </a>
                            <a href="about_us.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">حولنا <i class="fa fa-info"></i> </a>
                            <a href="signup.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">إنشاء حساب</a>
                            <a href="contact.php" class="nav-item nav-link" style="border-left:1px solid #aaa;"> الإبلاغ عن مشكلة</a>
                            <a href="signin.php" class="nav-item nav-link">تسجيل دخول</a>
                            <?php
                            }
                            ?>
                            
                            <?php
                            if($_SESSION['user_type']==1)
                            {
                            ?>
                            
                            <a href="cpanel/users/users.php" class="nav-item nav-link" style="border-left:1px solid #aaa;color:#55a;font-weight:bold;">المستخدمون</a>
                            <a href="cpanel/adv/adv.php" class="nav-item nav-link" style="border-left:1px solid #aaa;color:#55a;font-weight:bold;">اعلانات عامة</a>
                            <a href="cpanel/city/city.php" class="nav-item nav-link" style="border-left:1px solid #aaa;color:#55a;font-weight:bold;">المدن</a>
                            
                            <a href="my_account.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">حسابي (مدير)</a>
                            
                            <a href="all_reservation.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">كل طلبات الحجز</a>

                            <a href="villas.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">الفلل التي تم إضافتها </a>
                            
                            <a href="cpanel/contact/contact.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">البلاغات الواردة عن مشاكل </a>
                            
                            <a href="?action=logout" class="nav-item nav-link">تسجيل خروج</a>
                            <?php
                            }
                            ?>
                            
                            <?php
                            if($_SESSION['user_type']==2)
                            {
                            ?>
                            <a href="index.php" class="nav-item nav-link active" style="border-left:1px solid #aaa;"> <i class="fa fa-home"></i> الصفحة الرئيسية  </a>
                           
                            <a href="my_account.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">حسابي (صاحب فيلا)</a>
                            <a href="received_reservation.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">طلبات الحجز الواردة</a>

                            <a href="villas.php" class="nav-item nav-link" style="border-left:1px solid #aaa;">الفلل التي قمت بإضافتها</a>
                            <a href="?action=logout" class="nav-item nav-link">تسجيل خروج</a>
                            <?php
                            }
                            ?>
                            
                            <?php
                            if($_SESSION['user_type']==3)
                            {
                            ?>
                            <a href="index.php" class="nav-item nav-link active" > <i class="fa fa-home"></i> الصفحة الرئيسية  </a>
                            
                            <a href="my_account.php" class="nav-item nav-link">حسابي (مستأجر)</a>
                            <a href="sent_reservation.php" class="nav-item nav-link">طلبات الحجز الصادرة</a>

                            <a href="?action=logout" class="nav-item nav-link">تسجيل خروج</a>
                            <?php
                            }
                            ?>

                            
                        </div>

                    <a href="index.php" class="navbar-brand" ><h1 class="text-primary display-6" style="font-family: 'Ubuntu', sans-serif !important;">MyVilla</h1></a>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

