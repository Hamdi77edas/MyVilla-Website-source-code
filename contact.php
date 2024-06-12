<?php
include "header.php";
?>



<script>


function contact(element)
{
	var first_name=$("[name='first_name']").val();
  var family_name=$("[name='family_name']").val();
  var phone=$("[name='phone']").val();
  
  var content=$("[name='content']").val();
  var title=$("[name='title']").val();
  var phone=$("[name='phone']").val();

  if(title==0||title==''||title===undefined || title.length<5)
	{
		alert('يجب تعبئة الحقول بالبيانات المناسبة  ');
		return;
	}
	
	

	if(first_name=='' || family_name=='' || first_name.length<3 || family_name.length<3)
	{
		alert('يجب إدخال الاسم الاول والاخير بالشكل الصحيح');
		return;
	}
  if(phone==0||phone==''||phone===undefined || phone.length<10)
	{
		alert('تأكد أن رقم الهاتف يحتوي على 10 أرقام ');
		return;
	}

  //var pass_data={};
	var pass_data = new FormData();

	pass_data.append('first_name',first_name);
  pass_data.append('family_name',family_name);
  pass_data.append('phone',phone);
  pass_data.append('content',content);
  pass_data.append('title',title);

	$.ajax({
		type:"POST",
		url:"contact_back.php",
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
    <h1 class="text-center text-white display-6">هنا بإمكانك الإبلاغ عن أي مشكلة واجهتك أثناء استخدام الموقع</h1>

</div>
<!-- Single Page Header End -->

<br>


<!-- Checkout Page Start -->
<div class="container-fluid ">
    <div class="container " dir="rtl">
                  
        <form action="#">
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-7">

                    <h5 class="mb-4">تواصل معنا </h5>
                    <hr>
                    <div class="row">

                    
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">الإسم الاول<sup>*</sup></label>
                                <input type="text" name="first_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">اسم العائلة<sup>*</sup></label>
                                <input type="text" name="family_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-item">
                        <label class="form-label my-3">الهاتف<sup>*</sup></label>

                        
                        <input type="text"  name="phone" maxlength="10" class="form-control">
                        
                    </div>
                   

                    <div class="form-item">
                        <label class="form-label my-3">العنوان<sup>*</sup></label>

                        
                        <input type="text"  name="title" maxlength="10" class="form-control">
                        
                    </div>
                    
                    <div class="form-item">
                        <label class="form-label my-3">المحتوى <sup></sup></label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="اكتب تفاصيل المشكلة هنا ..."></textarea>
                    </div>
                    
                    
                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <button type="button" onclick="contact(this)" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">ارسال</button>
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
   
   
   
   
   
   
   
   
   
   
   
   
   
   
                        
