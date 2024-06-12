<?php
include "header.php";
?>
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">جميع الطلبات</h1>

</div>
<!-- Single Page Header End -->

<br><br>

<style>
    .star {
        font-size: 20px;
        cursor: pointer;
        color: grey;
    }
    .star.checked{
        color: gold;
    }
</style>


<script>


function delete_order(element,order_id)
{
  
  //var pass_data={};
	var pass_data = new FormData();
  pass_data.append('action','delete_order');
	pass_data.append('order_id',order_id);


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
				//$("#response-msg").css({color:"green",});
				//$("#response-msg").text(response.body);	
				location.reload();
			}
			else if(response.head=="error")
			{
				alert(response.body);
				//$("#response-msg").css({color:"red",});
				//$("#response-msg").text(response.body);	
			}

	 	}
	});
		
					


}

</script>

<!-- Cart Page Start -->
<div class="container-fluid py-1">
    <div class="container py-1">
        <div class="table-responsive">
            <table class="table" dir="rtl" style="font-size:0.9em;">
                <thead>
                  <tr>
                    <th class="text-center" scope="col">#</th>
                    <th class="text-center" scope="col">وقت الطلب</th>
                    <th scope="col">الفيلا</th>
                    <th scope="col">الأطراف</th>

                    <th class="text-center" scope="col">تاريخ الحجز</th>

                    
                    <th class="text-center" scope="col">الرد</th>
                    <th class="text-center" scope="col">حالة الدفع</th>

                    <th class="text-center" scope="col">التقييم </th>
                    
                    <th class="text-center" scope="col">حذف السجل</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if($_SESSION['user_type']==1)$sql="SELECT 
                  reservation_list.renter_evaluation, 
                  reservation_list.owner_evaluation,
                  reservation_list.id as order_id,
                  reservation_list.payment_status,
                  reservation_list.sent_datetime as order_sent_datetime,
                  reservation_list.owner_response,
                  reservation_list.from_date, reservation_list.to_date,
                  villas.*,
                  concat(renters.first_name,' ',renters.family_name) AS renter_name,
                  concat(owners.first_name,' ',owners.family_name) AS owner_name 
                  FROM reservation_list 
                  LEFT JOIN villas ON villas.id=reservation_list.villa_id 
                  LEFT JOIN users as renters ON renters.id=reservation_list.by_user_id 
                  LEFT JOIN users as owners ON owners.id=villas.by_user_id 
                  WHERE 1 AND reservation_list.del=0";
                  
                  //echo $sql;
                  
                  $query = mysqli_query($connect, $sql);
                  $row_No=0;
                  while($row = mysqli_fetch_array($query))
                  {
                    $row_No+=1;
                  ?>
                    <tr>
                        <td class="text-center">
                            
                            <p class="mb-0 mt-4"><?php echo $row_No;?></p>
                        </td>
                        <td class="text-center">
                            
                            <p class="mb-0 mt-4 "><?php echo date("Y-m-d",strtotime($row['order_sent_datetime']));?><br><?php echo date("H:i",strtotime($row['order_sent_datetime']));?></p>
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center">
                                <img src="DRIVE/<?php echo $row['img'];?>" class="img-fluid mp-5 rounded" style="width: 80px; height: 80px;" alt="" alt="">
                                <p class="m-4 mt-4"><a href="villa_details.php?villa_id=<?php echo $row['id'];?>"><?php echo $row['title'];?></a><br>
                                لليوم الواحد: <?php echo $row['price'];?> ₪</p>
                                
                                </p>
                            </div>
                        </td>
                        <td class="text-center">
                            
                           <p class="mb-0 mt-3"> المالك: <?php echo $row['owner_name'];?> </p>

                            
                       <p class="mb-0 mt-2"> المستأجر: <?php echo $row['renter_name'];?> </p>
                        </td>

                        <td class="text-center">
                          <p class="mb-0 mt-4" dir="rtl">
                            <?php
                            if(!empty($row['from_date']))
                            {
                              echo "[".$row['from_date']."]";
                             
                            }
                            if(!empty($row['to_date']) && $row['to_date']!=$row['from_date'])
                            {
                              echo " <i class='fa fa-arrow-left' ></i> [".$row['to_date']."]"; 
                            }
                            ?>
                          </p> 
                        </td>

                        
                        
                        

                        <td class="text-center">
                            <p class="mb-0 mt-4"><?php echo array(0=>"بالإنتظار",1=>"تمت الموافقة",2=>"تم الرفض")[intval($row['owner_response'])];?> </p>
                        </td>
                        

                        <td class="text-center">
                            <p class="mb-0 mt-4"><?php echo array(0=>"بالإنتظار",1=>"تم الدفع")[intval($row['payment_status'])];?> </p>
                        </td>
                        
                        <td class="text-center">
                            
                            
                            
                            <span style="font-size:0.9em;font-weight:bold;">رأي المالك</span>
                            <div style="margin-top:0px;"  dir="rtl">
                                <span class="star <?php if($row['owner_evaluation']>=1)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['owner_evaluation']>=2)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['owner_evaluation']>=3)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['owner_evaluation']>=4)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['owner_evaluation']>=5)echo "checked";?>" >★</span>
                            </div>
                            
                            <span style="font-size:0.9em;font-weight:bold;">رأي المستأجر</span>  
                            <div style="margin-top:0px;"  dir="rtl">
                                <span class="star <?php if($row['renter_evaluation']>=1)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['renter_evaluation']>=2)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['renter_evaluation']>=3)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['renter_evaluation']>=4)echo "checked";?>" >★</span>
                                <span class="star <?php if($row['renter_evaluation']>=5)echo "checked";?>" >★</span>
                            </div>
                            
                            

                        </td>
                        
                        <td class="text-center">
                            <button class="btn btn-md rounded-circle bg-light border mt-4" onclick="delete_order(this,<?php echo $row['order_id'];?>)" >
                                <i class="fa fa-times text-danger"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <?php
                    }
                    ?>
                    
                    
                </tbody>
            </table>
        </div>
        
        
        
    </div>
</div>
<!-- Cart Page End -->


<?php
include "footer.php";
?>
