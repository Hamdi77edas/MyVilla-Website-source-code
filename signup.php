<?php
include "header.php";
?>



<script>


function signup(element)
{
	var first_name=$("[name='first_name']").val();
  var family_name=$("[name='family_name']").val();
  
  var address=$("[name='address']").val();
  var phone=$("[name='phone']").val();
  if(phone==0||phone==''||phone===undefined || phone.length<9)
	{
		alert('يجب إدخال رقم الهاتف والتأكد من أنه يتكون من 10 خانات ');
		return;
	}
	
	
	var city_id=$("[name='city_id'] option:selected ").val();
	
	var user_type=$("[name='user_type'] option:selected ").val();
  

	if(first_name=='' || family_name=='' || first_name.length<3 || family_name.length<3)
	{
		alert('يجب إدخال الاسم الاول واسم العائلة  ');
		return;
	}



	if(city_id==0||city_id==''||city_id===undefined)
	{
		alert('يجب تحديد مكان الاقامة ');
		return;
	}
	
	if(user_type==0||user_type==''||user_type===undefined)
	{
		alert('يجب تحديد نوع الحساب ');
		return;
	}




	var password=$("[name=password]").val();
	var confirm_password=$("[name=confirm_password]").val();
	
	if(password!=confirm_password || password=="" || password===undefined )
	{
	  alert("كلمات المرور غير متطابقة");
	  return;
	}
	
  //var pass_data={};
	var pass_data = new FormData();

	pass_data.append('first_name',first_name);
  pass_data.append('family_name',family_name);
  pass_data.append('address',address);
  pass_data.append('phone',phone);
  pass_data.append('img',$("[name='img']")[0].files[0]);/////


	pass_data.append('city_id',city_id);
	
	pass_data.append('user_type',user_type);

	pass_data.append('password',password);



	$.ajax({
		type:"POST",
		url:"signup_back.php",
		data:pass_data,
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	processData: false, // NEEDED, DON'T OMIT THIS
		success: function(response) {
      alert("   تم إنشاء الحساب بنجاح قم بتسجيل الدخول");
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


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">انشئ حساب مجانا</h1>

</div>
<!-- Single Page Header End -->

<br>


<!-- Checkout Page Start -->
<div class="container-fluid ">
    <div class="container " dir="rtl">
                  
        <form action="#">
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-7">

                    <h5 class="mb-4">انشاء حساب جديد</h5>
                    <hr>
                    <div class="row">
                        <div class="form-item">
                            <label class="form-label my-3">نوع الحساب<sup style="color:red;">*</sup></label>
                            <select class="form-control" style="border:1px dashed red;background:#fafafa;color:red;" name="user_type"  id="user_type" style="" >
                              <option></option>
                              <option value="2">مالك فيلا</option>
                              <option value="3" selected>مستأجر</option>
                              
                            </select>   

                        </div>
                    
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">الاسم الاول<sup>*</sup></label>
                                <input type="text" name="first_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">العائلة<sup>*</sup></label>
                                <input type="text" name="family_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-item w-100">
                            <div class="form-item w-100">
                                <label class="form-label my-3"> الصورة</label>
                                <input type="file" name="img" class="form-control"> 
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
                          
                          <option value="<?php echo $row_city['id'];?>" <?php if($city_id==$row_city['id'])echo "selected";?>><?php echo $row_city['name'];?></option>
                          <?php
                          }
                        
                        ?>
                        </select>   

                    </div>
                    
                    <div class="form-item">
                        <label class="form-label my-3">العنوان <sup></sup></label>
                        <input type="text" class="form-control" name="address" placeholder="القرية / الشارع / المبنى">
                    </div>
                    

                    <div class="form-item">
                        <label class="form-label my-3">الهاتف<sup>*</sup></label>

                        
                        <input type="text"  name="phone" maxlength="10" class="form-control">
                        
                    </div>
                    
                    <div class="form-item">
                        <label class="form-label my-3">كلمة المرور<sup>*</sup></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    
                    <div class="form-item">
                        <label class="form-label my-3">تاكيد كلمة المرور<sup>*</sup></label>
                        <input type="password" name="confirm_password" class="form-control">
                    </div>
                    
                    <br>
                    
                    
                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <button type="button" onclick="signup(this)" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">انشاء حساب</button>
                    </div>
                    <br>
                    <div id="response-msg"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Checkout Page End -->


<?php
include "footer.php";
?>


<script>
function FixedNumericInput(data) {
  var element=data.element;
  
  if(data.dayaType===undefined)var dayaType='int';
  else var dayaType=data.dayaType;

  if(data.allow_minus===undefined)var allow_minus=false;
  else var allow_minus=data.allow_minus;

  if(allow_minus==true)
  {
    allow_minus=1;
  }
  else// else if(allow_minus!=true || allow_minus==false || allow_minus===undefined)
  {
    allow_minus=0;
  }

  if(dayaType=="float")
  {

    $(element).on("keypress keyup blur",function (event) 
    {
      //this.value = this.value.replace(/[^0-9\.]/g,'');

      if(allow_minus)
      {
        var check_minus=(event.which != 45 || $(this).val().length != 0);
        $(this).val($(this).val().replace(/[^0-9\.\-]/g,''));
      }
      else
      {
        var check_minus=1;
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
      }
       
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) && check_minus) 
        {
            event.preventDefault();
        }


            
            
    });
    
  }
  else if(dataType="int")
  {
     $(element).on("keypress keyup blur",function (event) 
     {    
           
      if(allow_minus)
      {
        var check_minus=(event.which != 45 || $(this).val().length != 0);
        $(this).val($(this).val().replace(/[^\d\-].+/, ""));
      }
      else
      {
        var check_minus=1;
        $(this).val($(this).val().replace(/[^\d].+/, ""));
      }
           
        if ((event.which < 48 || event.which > 57)&&check_minus) {
            event.preventDefault();
        }



      
    });
  }    
        
        
}
</script>
                        
                        
<script>
  $(document).ready(function(){FixedNumericInput({"element":$("[name=phone]"),"dataType":"int","allow_minus":false});});
</script>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
                        
