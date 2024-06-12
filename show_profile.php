<?php
include "header.php";
?>




<?php
$sql="SELECT users.*,city.name as city_name FROM users LEFT JOIN city ON city.id=users.city_id WHERE 1 AND users.id=$_GET[user_id]";
$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($query);

?>
   
   
<!-- Single Page Header start -->
<div class="container-fluid  py-5">
</div>
<!-- Single Page Header End -->


<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5" dir="rtl">
        <hr>

        <form action="#">
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="row">
                        <div class="col-lg-12">
                          <div class="d-flex align-items-center justify-content-start">
                              <div class="rounded m-4" style="width: 200px; height: 200px;">
                                 <?php if(!empty($row['img'])) { ?>
                                      <img src="DRIVE/<?php echo $row['img'];?>" class="img-fluid rounded-circle" alt="">
                                  <?php } ?> 
                              </div>
                              <div>
                                  <h6 class="mb-2">الاسم: <?php echo $row['first_name'].' '.$row['family_name'];?></h6>
                                  <div class="d-flex mb-2">
                                      <div class="fw-bold me-2 text-danger ">الهاتف: <?php echo $row['phone'];?></div>
                                  </div>
                                  <hr>
                                  <div class="d-flex mb-2">
                                      <div class="fw-bold me-2">المدينة: <?php echo $row['city_name'];?></div>
                                  </div>
                                  
                                  <div class="d-flex mb-2">
                                      <div class="fw-bold me-2">العنوان: <?php echo $row['address'];?></div>
                                  </div>
                                  
                                  <hr>
                                  
                            </div>
                        </div>
                      </div>        

                </div>
            </div>
        </form>
        <hr>
    </div>
</div>
<!-- Checkout Page End -->


<?php
include "footer.php";
?>
