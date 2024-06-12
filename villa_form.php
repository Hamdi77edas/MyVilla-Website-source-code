<?php
include "header.php";
?>



<!-- Single Page Header start -->
<div class="container-fluid py-5">

</div>
<!-- Single Page Header End -->


<?php
if(is_numeric($_GET['villa_id']))
{
  if($_SESSION['user_type']==1)
    $sql="SELECT * FROM villas WHERE 1 AND villas.del=0 AND villas.id=$_GET[villa_id] ";
  if($_SESSION['user_type']==2)
    $sql="SELECT * FROM villas WHERE 1 AND villas.del=0 AND villas.id=$_GET[villa_id] AND by_user_id=$_SESSION[user_id]";
    
  $query = mysqli_query($connect, $sql);
  if($row = mysqli_fetch_array($query))
  {
    $villa_id=$row['id'];
    $title=$row['title'];
    $latitude=$row['latitude'];
    $longitude=$row['longitude'];
    $description=$row['description'];
    $img=$row['img'];
    $video=$row['video'];

    $city_id=$row['city_id'];
    $area=$row['area'];
    $price=$row['price'];

  }
  else
  {
    echo "المنشور غير موجود أو لا تملك الصلاحيات المناسبة";
  }
}
?>





<script>


function publish_villa(element,action,row_id)
{
	var latitude=$("[name='latitude']").val();
	var longitude=$("[name='longitude']").val();
	var img=$("[name='img']").val();
  var video=$("[name='video']").val();

  if(video==0||video==''||video===undefined || img==0||img==''||img===undefined)
  {
		alert('يجب إضافة صورة للفيلا و جولة فيديو داخل الفيلا المراد إضافتها');
		return;
	}
  
	var title=$("[name='title']").val();
	if(title.length<3 || title===undefined)
	{
		alert('يجب إدخال اسم الفيلا');
		return;
	}

  var description=$("textarea[name='description']").val();
  //alert(description);
  
  var area=$("[name='area']").val();
  if(area==0||area==''||area===undefined )
	{
		alert('يجب تحديد المساحة الخاصة بالفيلا');
		return;
	}

	var city_id=$("[name='city_id'] option:selected ").val();
	if(city_id==0||city_id==''||city_id===undefined)
	{
		alert('يجب تحديد مدينة ');
		return;
	}




	var price=$("[name='price']").val();


  //var pass_data={};
	var pass_data = new FormData();

	pass_data.append('action',action);
	
	pass_data.append('row_id',row_id);
	
	pass_data.append('title',title);
	pass_data.append('latitude',latitude);
	pass_data.append('longitude',longitude);
	
  pass_data.append('description',description);
  pass_data.append('area',area);

  pass_data.append('img',$("[name='img']")[0].files[0]);/////
  pass_data.append('video',$("[name='video']")[0].files[0]);/////

  pass_data.append('price',price);
	pass_data.append('city_id',city_id);


  //alert(row_id);


	$.ajax({
		type:"POST",
		url:"villa_back.php",
		data:pass_data,
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	processData: false, // NEEDED, DON'T OMIT THIS
		success: function(response) {
    alert('تم إضافة الفيلا بنجاح');
			//alert(response);
			response=JSON.parse(response.trim());
		
			if(response.head=="ok")
			{
				//alert(response.body);
				$("#response-msg").css({color:"green",});
				$("#response-msg").text(response.body);	
				setTimeout(function(){ 
					location.reload();
					//alert(response.body);
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







<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 rounded">
            <div class="row g-4" dir="rtl">
                <h6>بيانات الفيلا</h6>
                <hr>
                
                
                <div class="col-lg-6">

                        <input type="text" name="title" class="w-100 form-control border-1 py-3 mb-4" placeholder="اسم الفيلا" value="<?php echo $title;?>">
                        
                        <input type="text" name="latitude" class="w-100 form-control border-1 py-3 mb-4" placeholder="latitude" value="<?php echo $latitude;?>">
                        
                        <input type="text" name="longitude" class="w-100 form-control border-1 py-3 mb-4" placeholder="longitude" value="<?php echo $longitude;?>">
                        
                        <select class="form-control py-3 mb-4" name="city_id"  id="city_id" style="" >
                          <option>اختر مدينة</option>
                          <?php
                          $query_city = mysqli_query($connect, "SELECT * FROM city WHERE 1 AND delete_area=0 ORDER BY id DESC ");
                          while ($row_city = mysqli_fetch_array($query_city)) {
                          ?>
                          
                          <option value="<?php echo $row_city['id'];?>" <?php if($city_id==$row_city['id'])echo "selected";?>><?php echo $row_city['name'];?></option>
                          <?php
                          }
                        
                        ?>
                        </select>   
                        
                        صورة:
                        <input type="file" name="img" class="w-100 form-control border-1 bg-white py-3 mb-4" placeholder="صورة">
                        
                        فيديو:
                        <input type="file" name="video" class="w-100 form-control border-1 bg-white py-3 mb-4" placeholder="صورة">
                        <div style="position: relative;">
                            <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 2em;">₪</span>
                            <input type="number" name="price" value="<?php echo $price;?>" class="w-100 form-control border-1 py-3 mb-4 pl-4" placeholder=" السعر">
                        </div>

                        <textarea name="description" class="w-100 form-control border-1 mb-4" rows="5" cols="10" placeholder="الوصف"><?php echo $description;?></textarea>
                        

                        
                        <select class="form-control py-3 mb-4" name="area"  id="area" style="" >
                          <option>المساحة</option>
                          <option value="1" <?php if($area==1)echo "selected"?>>كبيرة</option>
                          <option value="2" <?php if($area==2)echo "selected"?>>متوسطة</option>
                          <option value="3" <?php if($area==3)echo "selected"?>>صغيرة</option>
                        </select> 

                        
                       
                      <?php
                      if(empty($_GET['villa_id']))
                      {   
                      ?>
                        <button onclick="publish_villa(this,'insert_villa',null)" class="w-100 btn form-control border-secondary py-3 bg-white text-primary " type="submit">نشر</button>
                      <?php
                      }
                      else
                      {
                      ?>  
                        <button onclick="publish_villa(this,'update_villa',<?php echo $villa_id;?>)" class="w-100 btn form-control border-secondary py-3 bg-white text-primary " type="submit">حفظ التعديلات</button>
                       <?php
                       }
                       ?> 
                        <br>
                        <div id="response-msg"></div>

                </div>
                <div class="col-lg-6 ">
                <?php
                if(!empty($img))
                {   
                ?>
                   <img src="DRIVE/<?php echo $img;?>" class="img-fluid  rounded"  alt="" alt="">
                <?php
                }
                ?>
                
                <?php
                if(!empty($video))
                {   
                ?>
                   <br><br>
                   <a href="DRIVE/<?php echo $video;?>" target="_blank"> شاهد الفيديو</a>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->






<?php
include "footer.php";
?>
