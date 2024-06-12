<?php
include "header.php";
?>









<script>


function save_info(element)
{
	var first_name=$("[name='first_name']").val();
  var family_name=$("[name='family_name']").val();
  
  var address=$("[name='address']").val();
  var phone=$("[name='phone']").val();
  if(phone==0||phone==''||phone===undefined || phone.length<9)
	{
		alert('يجب إدخال رقم الهاتف ');
		return;
	}
	
	
	var city_id=$("[name='city_id'] option:selected ").val();

	if(first_name=='' || family_name=='' || first_name.length<3 || family_name.length<3)
	{
		alert('يجب إدخال الإسم الأول والأخير بالشكل الصحيح ');
		return;
	}



	if(city_id==0||city_id==''||city_id===undefined)
	{
		alert('يجب اختيار المدينة ');
		return;
	}




	var password=$("[name=password]").val();


	
  //var pass_data={};
	var pass_data = new FormData();

	pass_data.append('first_name',first_name);
  pass_data.append('family_name',family_name);
  pass_data.append('address',address);
  pass_data.append('phone',phone);
  pass_data.append('img',$("[name='img']")[0].files[0]);/////


	pass_data.append('city_id',city_id);

	pass_data.append('password',password);



	$.ajax({
		type:"POST",
		url:"my_account_back.php",
		data:pass_data,
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	processData: false, // NEEDED, DON'T OMIT THIS
		success: function(response) {
        alert('تم تحديث البيانات بنجاح');
			//alert(3);
			response=JSON.parse(response.trim());
		
			if(response.head=="ok")
			{
				//alert(response.body);
				$("#response-msg").css({color:"green",});
				$("#response-msg").text(response.body);	
				setTimeout(function(){ 
					location.reload();
				}, 2000);
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
$sql="SELECT * FROM users WHERE 1 AND id=$_SESSION[user_id]";
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


        <h4 class="mb-4 " style="text-align:center;color:gray;">حسابي</h4>
        <hr>

            <div class="row g-5">
                <div class="col-lg-6 d-flex justify-content-center">
                    <?php if(!empty($row['img'])) { ?>
                        <div class="m-5 p-5" style="background: url('DRIVE/<?php echo $row['img'];?>');background-size:cover; width: 300px; height: 300px; border-radius: 50%;box-shadow:1px 1px 4px 1px #000;"></div>
                    <?php } ?>                   
                </div>


                
                <div class="col-lg-6 ">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">الاسم الاول<sup>*</sup></label>
                                <input name="first_name" type="text" class="form-control" value="<?php echo $row['first_name'];?>" />
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">العائلة<sup>*</sup></label>
                                <input name="family_name" type="text" class="form-control" value="<?php echo $row['family_name'];?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-item w-100">
                            <div class="form-item w-100">
                                <label class="form-label my-3"> الصورة</label>
                                <input name="img" type="file" class="form-control"> 
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-item">
                        <label class="form-label my-3">المدينة<sup>*</sup></label>
                        <select class="form-control" name="city_id"  id="city_id" style="" >
                          <option></option>
                          <?php
                          $query_city = mysqli_query($connect, "SELECT * FROM city ORDER BY id DESC ");
                          while ($row_city = mysqli_fetch_array($query_city)) {
                          ?>
                          
                          <option value="<?php echo $row_city['id'];?>" <?php if($row['city_id']==$row_city['id'])echo "selected";?>><?php echo $row_city['name'];?></option>
                          <?php
                          }
                        
                        ?>
                        </select>   
                    </div>
                    
                    <div class="form-item">
                        <label class="form-label my-3">العنوان <sup></sup></label>
                        <input name="address" type="text" class="form-control" placeholder="القرية / الشارع / المبنى" value="<?php echo $row['address'];?>" >
                    </div>
                    

                    <div class="form-item">
                        <label class="form-label my-3">الهاتف<sup>*</sup></label>
                        <input name="phone" type="tel" class="form-control" value="<?php echo $row['phone'];?>" >
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">كلمة المرور<sup>*</sup></label>
                        <input name="password" type="password" class="form-control" autocomplete="new-password">
                    </div>
                    
                    <br>
                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <button onclick="save_info(this);" type="button" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">حفظ البيانات</button>
                    </div>
                    <br>
                    <div id="response-msg"></div>
                    
                </div>
                
                
                
            </div>
            
                
            
            

    </div>
</div>
<!-- Checkout Page End -->


<?php
include "footer.php";
?>
