<?php
include "header.php";
?>
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">الفلل</h1>

</div>
<!-- Single Page Header End -->

<br><br>



<script>


function do_fun(element,action,row_id)
{
  if(!confirm("هل تريد بالتأكيد حذف السجل؟")){
    return;
  }
  //var pass_data={};
	var pass_data = new FormData();

	pass_data.append('action',action);
	
	pass_data.append('row_id',row_id);


  //alert(row_id);


	$.ajax({
		type:"POST",
		url:"villa_back.php",
		data:pass_data,
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	processData: false, // NEEDED, DON'T OMIT THIS
		success: function(response) {

			//alert(response);
			response=JSON.parse(response.trim());
		
			if(response.head=="ok")
			{
				location.reload();
			}
			else if(response.head=="error")
			{
				alert(response.body);
				
			}

	 	}
	});
		
					


}

</script>



<!-- Cart Page Start -->
<div class="container-fluid py-1">
    <div class="container py-1">
        <div class="table-responsive" dir="rtl">
            <div class="m-3">
                <a href="villa_form.php"  class="btn btn-primary border-2 border-secondary py-2 px-3 rounded-pill text-white">
                  <span class="">إضافة فيلا</span> 
                </a>
            </div>
            <table class="table" dir="rtl">
                <thead>
                  <tr>
                    <th class="text-center" scope="col">#</th>
                    <th class="text-center" scope="col">وقت النشر</th>
                    <th scope="col">الفيلا</th>

                    <th class="text-center" scope="col">السعر</th>

                    <th class="text-center" width=2% scope="col">تعديل</th>
                    <th class="text-center" width=2%  scope="col">حذف</th>
                  </tr>
                </thead>
                <tbody>



                  <?php
                  if($_SESSION['user_type']==1)$sql="SELECT villas.*,city.name as city_name,concat(first_name,' ',family_name) AS user_name FROM villas LEFT JOIN city ON city.id=villas.city_id LEFT JOIN users ON users.id=villas.by_user_id WHERE 1 AND villas.del=0";
                  else if($_SESSION['user_type']==2)$sql="SELECT villas.*,city.name as city_name,concat(first_name,' ',family_name) AS user_name FROM villas LEFT JOIN city ON city.id=villas.city_id LEFT JOIN users ON users.id=villas.by_user_id  WHERE 1 AND villas.del=0 AND villas.by_user_id=$_SESSION[user_id]";
                  
                  $query = mysqli_query($connect, $sql);
                  $row_No=0;
                  while($row = mysqli_fetch_array($query))
                  {
                    $row_No+=1;
                    
                    $latitude=$row['latitude'];
                    $longitude=$row['longitude'];
                    
                  ?>


                    <tr>
                        <td class="text-center">
                            
                            <p class="mb-0 mt-4"><?php echo $row_No;?></p>
                        </td>
                        <td class="text-center">
                            
                            <p class=""><?php echo date("Y-m-d H:i",strtotime($row['insert_datetime']));?></p>
                            
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center">
                                <img src="DRIVE/<?php echo $row['img'];?>" class="img-fluid mp-5 rounded" style="width: 80px; height: 80px;" alt="" alt="">
                                <p class="m-4 mt-4"><a href="villa_details.php?villa_id=<?php echo $row['id'];?>"><?php echo $row['title'];?></a></p>
                                <?php 
                                if($_SESSION['user_type']==1)
                                {
                                ?>
                                <br>
                                <p class="m-4 mt-4" ><a href="show_profile.php?user_id=<?php echo $row['by_user_id'];?>"><?php echo $row['user_name'];?></a></p>
                                <?php
                                }
                                ?>
                                <p class="m-4 mt-4" style="font-weight:bold;"><?php echo $row['city_name'];?>  
                                <?php
                                if($latitude!="" && $longitude!="")
                                {
                                ?>
                                <img width="44px;" src="assets/img/map.png" onclick="location.href='map.php?villa_id=<?php echo $row['id'];?>';"/>
                                <?php
                                }
                                ?>
                                </p>
                                
                                
                            </div>
                        </td>
                        
                        <td class="text-center">
                            
                            <p class="mb-0 mt-4"><?php echo $row['price'];?> ₪</p>
                        </td>
                        

                        
                        <td class="text-center">
                            <a href="villa_form.php?villa_id=<?php echo $row['id'];?>">
                              <button class="btn btn-md rounded-circle bg-light border mt-4 p-1" style="width:39px;height:39px;">
                                  <i class="fa fa-edit text-primary"></i>
                              </button>
                            </a>
                        </td>
                        <td class="text-center">
                            <button onclick="do_fun(this,'delete',<?php echo $row['id'];?>);" class="btn btn-md rounded-circle bg-light border mt-4 p-1" style="width:39px;height:39px;" >
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
