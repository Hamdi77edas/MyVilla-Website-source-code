<?php
include "header.php";
?>


<script>

function signin(element)
{

  var phone=$("[name='phone']").val();

	if(phone==0||phone==''||phone===undefined || phone.length<9)
	{
		alert('يجب ادخال رقم الهاتف بالشكل الصحيح- تأكد من عدد الارقام- ');
		return;
	}


	var password=$("[name=password]").val();

	
	if(password=="")
	{
	  alert("يجب ادخال كلمة المرور");
	  return;
	}
	
  //var pass_data={};
	var pass_data = new FormData();


  pass_data.append('phone',phone);


	pass_data.append('password',password);
	




	$.ajax({
		type:"POST",
		url:"signin_back.php",
		data:pass_data,
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	processData: false, // NEEDED, DON'T OMIT THIS
		success: function(response) {

			//alert(3);
			response=JSON.parse(response.trim());
		
			if(response.head=="ok")
			{
				//alert(response.body);
				$("#response-msg").css({color:"green",});
				$("#response-msg").text("تم تسجيل الدخول بنجاح");	
				setTimeout(function(){ 
					location.href="index.php";
				}, 1000);
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
    <h1 class="text-center text-white display-6">اهلا وسهلا بك</h1>

</div>
<!-- Single Page Header End -->

<br>


<!-- Contact Start -->
<div class="container-fluid contact ">
    <div class="container ">
        <div class="p-1 rounded">
            <div class="row g-4" dir="rtl">
                <div class="col-lg-7">
 
                    <h5>تسجيل دخول</h5>
                    <hr>

                        <input type="text" name="phone" class="w-100 form-control border-0 py-3 mb-4" placeholder="الهاتف">
                        <input type="password" name="password" class="w-100 form-control border-0 py-3 mb-4" placeholder="كلمة المرور">

                        <br>
                        
                        <button onclick="signin(this);" class="w-100 btn form-control border-secondary py-3 bg-white text-primary " type="submit">تسجيل دخول</button>
                        <br>
                        <div id="response-msg"></div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->






<?php
include "footer.php";
?>
