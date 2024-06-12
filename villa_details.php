
<?php
include "header.php";
?>


<style>
    .star {
        font-size: 27px;
        cursor: pointer;
        color: grey;
    }
    .star.checked {
        color: gold;
    }
</style>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    /* إضافة تنسيقات مخصصة */
    .custom-highlight {
        background-color: #EE3232;
        color: #fff;
    }
</style>


<script>


function send_order(element,villa_id)
{
  
  var from_date=$("[name=from_date]").val();
  var to_date=$("[name=to_date]").val();
  //alert(from_date);
  
  if(from_date=="" || to_date=="")
  {
    alert("يجب تحديد موعد الحجز بالضبط");
    return;
  }
  //var pass_data={};
	var pass_data = new FormData();
  pass_data.append('action','send_order');
	pass_data.append('villa_id',villa_id);
	pass_data.append('from_date',from_date);
	pass_data.append('to_date',to_date);
	

  //alert(row_id);


	$.ajax({
		type:"POST",
		url:"order_back.php",
		data:pass_data,
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	processData: false, // NEEDED, DON'T OMIT THIS
		success: function(response) {

			//alert(response);
			response=JSON.parse(response.trim());
		
			if(response.head=="ok")
			{
				//alert(response.body);
				$("#response-msg").css({color:"green",});
				$("#response-msg").text(response.body);	
			}
			else if(response.head=="error")
			{
				//alert(response.body);
				$("#response-msg").css({color:"red",});
				$("#response-msg").text(response.body);	
			}

	 	}
	});
		
					


}

</script>












<?php
if(is_numeric($_GET['villa_id']))
{
  $sql="SELECT villas.*,city.name as city_name,concat(first_name,' ',family_name) AS user_name FROM villas LEFT JOIN city ON city.id=villas.city_id LEFT JOIN users ON users.id=villas.by_user_id  WHERE 1 AND villas.del=0 AND villas.id=$_GET[villa_id]";
  $query = mysqli_query($connect, $sql);
  if($row = mysqli_fetch_array($query))
  {
    $villa_id=$row['id'];
    $title=$row['title'];
    $description=$row['description'];
    $img=$row['img'];
    $video=$row['video'];
    $payment_type=$row['payment_type'];
    $city_name=$row['city_name'];
    $area=$row['area'];
    $price=$row['price'];
    $by_user_name=$row['user_name'];
    $by_user_id=$row['by_user_id'];
    
    $latitude=$row['latitude'];
    $longitude=$row['longitude'];

  }
}
?>







<!-- Single Page Header start -->
<div class="container-fluid  py-5">
    <h1 class="text-center text-white display-6"></h1>
    
</div>
<!-- Single Page Header End -->

<!-- Single Product Start -->
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-12 col-xl-12" >
                <div class="row g-4" dir="rtl">
                    <div class="col-lg-6" >
                        <div class="border rounded">
                            <a href="#">
                              <?php 
                              if(!empty($row['img']))
                              {
                              ?>
                                <img src="DRIVE/<?php echo $img;?>" class="img-fluid rounded" style="min-height:400px;" alt="Image">
                              <?php
                              }
                              else
                              {
                              ?>
                                <img src="assets/img/empty.png" class="img-fluid rounded" style="min-height:400px;" alt="Image">
                              <?php
                              }
                              ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3"><?php echo $title;?></h4>
                        
                        <div >

                          <?php
                          $sql="
                            SELECT AVG(renter_evaluation) as evaluation_rate  FROM `reservation_list` WHERE 1 AND villa_id=$row[id] 
                            ";
                          //echo $sql;
                          $q_rate = mysqli_query($connect, $sql);
                          $r_rate = mysqli_fetch_array($q_rate);
                          $evaluation_rate=$r_rate['evaluation_rate'];
                          ?>
                          <div style="margin-top:-9px;"  dir="rtl">
                              <span class="star <?php if($evaluation_rate>=1)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,1);">★</span>
                              <span class="star <?php if($evaluation_rate>=2)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,2);">★</span>
                              <span class="star <?php if($evaluation_rate>=3)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,3);">★</span>
                              <span class="star <?php if($evaluation_rate>=4)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,4);">★</span>
                              <span class="star <?php if($evaluation_rate>=5)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,5);">★</span>
                          </div>
                      
                      </div>
                        
                        
                        <p class="mb-3">المدينة: <?php echo $city_name;?> 
                        <?php
                        if($latitude!="" && $longitude!="")
                        {
                        ?>
                        <img width="44px;" src="assets/img/map.png" onclick="location.href='map.php?villa_id=<?php echo $row['id'];?>';"/>
                        <?php
                        }
                        ?>
                        </p>
    المالك: 
                        <a href="show_profile.php?user_id=<?php echo $by_user_id;?>"> <?php echo $by_user_name;?> </a>
                        <br><br>
                        <h5 class="fw-bold mb-3">السعر لليوم الواحد: <strong style="color:red;"><?php echo $price;?>₪</strong></h5>
                        
                        <hr>
                        
                        
                        <p class="mb-4"><?php echo $description;?></p>

                        
                        <hr>
                            
                        <?php
                        if($_SESSION['user_type']==3)
                        {
                          if($by_user_id!=$_SESSION['user_id'])
                          {
                            ?>
                            
                            <h5 >موعد الحجز</h5>
                            <div class="row col-lg-12">
                              <div class="col-lg-6">
                                <div class="form-item">
                                    <label class="form-label my-3">من تاريخ <sup>*</sup></label>
                                    <input type="date" class="form-control" name="from_date" id="from_date" >
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="form-item">
                                    <label class="form-label my-3">إلى تاريخ<sup>*</sup></label>
                                    <input type="date" name="to_date" id="to_date" class="form-control">
                                                                          
                                      <?php
                                      $list="";
                                      $sql="SELECT * FROM reservation_list WHERE 1 AND reservation_list.del=0 AND villa_id=$_GET[villa_id]";
                                      $q = mysqli_query($connect, $sql);
                                      while($r = mysqli_fetch_array($q))
                                      {
                                      
                                        $list.="{ start: new Date(\"$r[from_date]\"), end: new Date(\" $r[to_date]\") },";
                                      }
                                      ?>
                                    <script>

                                    
                                      const dateRanges = [
                                          <?php echo $list;?>
                                      ];
                                      // وظيفة للتحقق إذا كان تاريخ معين يقع ضمن أي من الفترات المحددة
                                      function isDateInRange(date, ranges) {
                                          return ranges.some(range => date >= range.start && date <= range.end);
                                      }
      
      
                                      flatpickr("#from_date", {
                                          onDayCreate: function(dObj, dStr, fp, dayElem) {
                                              const date = dayElem.dateObj;

                                              if (isDateInRange(date, dateRanges)) {

                                                  dayElem.classList.add("custom-highlight");
                                              }
                                          }
                                      });
                                      
                                      flatpickr("#to_date", {
                                          onDayCreate: function(dObj, dStr, fp, dayElem) {
                                              const date = dayElem.dateObj;
                                              
                                              if (isDateInRange(date, dateRanges)) {
                                                  dayElem.classList.add("custom-highlight");
                                              }
                                          }
                                      });
                                        
                                    </script>
                                </div>
                              </div>
                            </div>
                            <hr>
                            
                            <a onclick="send_order(this,<?php echo $villa_id;?>)" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i class="fa fa-paper-plane me-2 text-primary"></i> طلب حجز</a>
                            <br>
                            <div id="response-msg"></div>
                            <?php
                          }
                          else
                          {
                          ?>
                            <a href="villa_form.php?villa_id=<?php echo $villa_id;?>">تعديل بيانات الفيلا  </a>
                          <?php
                          }
                        }
                        ?>
                    </div>
                    <?php
                    if(!empty($video))
                    {   
                    ?>
                    <div class="row col-lg-12">
                    <div class="col-lg-6">

                    <video style="width:100%;" controls>
                      <source src="DRIVE/<?php echo $video;?>" type="video/<?php echo pathinfo($video, PATHINFO_EXTENSION); ?>">
                    </video>

                    </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
        
     </div>   
  </div>
</div>




<?php
include "footer.php";
?>
