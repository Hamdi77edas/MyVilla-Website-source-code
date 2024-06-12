

<?php
include "../open_session.php";
?>
<html>
    <head>
    <meta charset="UTF-8"/>
        <title></title>
        <link rel='stylesheet' type='text/css' href='../../assets-cp/css/style.css'/>
        <link rel='stylesheet' type='text/css' href="../../assets-cp/css/font_family.css" rel="stylesheet">
        <link rel='stylesheet' type='text/css' href="../../assets-cp/css/fontAwesome.css" rel="stylesheet">
        
        <script src="../../assets-cp/js/jquery-2.2.4.min.js"></script>



        </head>
        <body style="background-color:#fff;">
        
        <style>
            .fixed-image {
                position: fixed;
                top: 30px; /* Adjust as needed */
                right: 30px;
                transform: translateY(-50%);
                width:66px;
                z-index:999;
            }
        </style>  
		        
        <a href="../../index.php">
                <img src="../../assets-cp/images/home.png"  class="fixed-image">
        </a> 
        
        
		
<script>


function run_controller(element,action)
{
	var first_name=$("[name='first_name']").val();
  var family_name=$("[name='family_name']").val();
  
  var address=$("[name='address']").val();
  var phone=$("[name='phone']").val();

	

	var user_type=$("[name='user_type']").val();
	
	
	var city_id=$("[name='city_id'] option:selected ").val();

	




	
	

	if(first_name=='' || family_name=='' || first_name.length<3 || family_name.length<3)
	{
		alert('يجب ادخال الاول والاخير بالشكل الصحيح');
		return;
	}
	
	if(city_id==0||city_id==''||city_id===undefined)
	{
		alert('يجب تحديد مكان الاقامة ');
		return;
	}





	var password=$("#password").val();

	
	
	
  //var pass_data={};
	var pass_data = new FormData();
	pass_data.append('action',action);
	pass_data.append('first_name',first_name);
  pass_data.append('family_name',family_name);
  pass_data.append('address',address);
  pass_data.append('phone',phone);
  pass_data.append('img',$("[name='img']")[0].files[0]);/////

	pass_data.append('user_type',user_type);
	


	pass_data.append('city_id',city_id);



	pass_data.append('password',password);



	if(action=='edit_row')
	{
		var row_id=$("#row_id").val();
		if(row_id==0||row_id==''||row_id===undefined)
		{
			alert('حدث خلل رقم السجل');
			return;
		}

		pass_data.append('row_id',row_id);
	}

	

	$.ajax({
		type:"POST",
		url:"users_fun.php",
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
					if(action=='add_row')window.history.back();
					else location.reload(); 
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

$action_function="add_row";

if ($_GET['action'] == 'edit_row' || $_GET['action'] == 'view_data') {

	
       if (isset($_SERVER['HTTP_REFERER'])) 
       {
       
			$row_id = intval($_GET['row_id']);
			$sql="SELECT * FROM users WHERE users.id='$row_id'";
			
			//echo $sql;
		    $query = mysqli_query($connect, $sql);
		    $row = mysqli_fetch_array($query);

		    $first_name = htmlspecialchars($row['first_name']);
		    $city_id = $row['city_id'];



        $user_type=$row['user_type'];
        $family_name=$row['family_name'];
        $address=$row['address'];
        $phone=$row['phone'];
        
        $img=htmlspecialchars($row['img']);
		    $src="../../DRIVE/$img";
		    if(!file_exists($src) || is_dir($src))//اذا الملف غير موجود او اصلا غير مخزن ملف فيكون هذا عبارة عن عضو مجلد وليس ملف
		    {
			    $src='../assets-cp/images/empty.png';
		    }
			    
		    $element_image='<img src="'.$src.'" style="max-width:100px;max-height:100px;"/>';
		    
		    
       
	  } else {
		    die("error request");
		}
}


if ($_GET['action'] == 'edit_row') 
{
	$action_function="edit_row";
}



?>




<div align="middle">
<div class="title" style="">معلومات المستخدم</div>


<table dir="rtl" width="80%" class="tablein" style="border:1px dashed #999;">
    <tr>
    <td>نوع الحساب</td>
    <td>
      <select class="stander_select_list" name="user_type" required="required">
      <option value="1" <?php if($user_type == 1)echo "selected";?>>مدير</option>
      <option value="2" <?php if($user_type == 2)echo "selected";?>>صاحب فيلا</option>
      <option value="3" <?php if($user_type == 3)echo "selected";?>>مستأجر</option>
      </select>
    </td>
  </tr>
  
  <tr>
      <td width="25%">الاسم الاول</td>
      <td><input type="text" name="first_name" class="cp_input" style="" required="required" value='<?php echo $first_name; ?>' /></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td width="25%">الاسم الاخير</td>
      <td><input type="text" name="family_name" class="cp_input" style="" required="required" value='<?php echo $family_name; ?>' /></td>
  </tr>

  <tr>
    <td width="25%">هاتف</td>
      <td><input type="text" name="phone" class="cp_input" style="" required="required" value='<?php echo $phone; ?>' /></td>
  </tr>
  <tr>
    <td>صورة </td>
    <td>
        <input type="file" name="img" />
        <div class="clear"></div>
        <?php echo $element_image; ?>
        <input type="hidden" name="oldimg" value="<?php echo $img ?>"  />
    </td>
  </tr>


 
  

  <tr>
      <td width="25%">المدينة </td>
      
        <td>
          <select class="stander_select_list" name="city_id"  id="city_id"  style="" >
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

      </td>
  </tr>

  <tr>
    <td width="25%">العنوان</td>
      <td><input type="text" name="address" class="cp_input" style="" required="required" value='<?php echo $address; ?>' /></td>
  </tr>

    <tr><td colspan=4><hr></td></tr>


    <tr>
      <td  style="color:black;">كلمة المرور</td><td><input dir="ltr" type="password" style="text-align:center;font-size:1.0em;font-weight:bold;color:black;" class="cp_input" value="" id="password" autocomplete="new-password" placeholder="كلمة المرور"/></td>
    </tr> 

      

    <tr class="control_showing" >
    		<?php 
		    if($action_function=="edit_row")
		    {
		    ?>
		    	<input type='hidden' id='row_id' value='<?php echo $row_id;?>' />
		    	<td colspan=2>
		    	
		    		<button class="btn btn-success" type='submit' onclick="run_controller(this,'edit_row');" >حفظ</button>
		    	</td>
		    <?php
		    }
		    else if($action_function=="add_row")
		    {
		    ?>
		    	<td colspan=2>
		    		<button class="btn btn-success" type='submit' onclick="run_controller(this,'add_row');" >اضافة</button>
		    	</td>
		    <?php
		    }
		    ?>
    </tr>
    <tr><td colspan=2 align="middle"><div id="response-msg"></div></td></tr>


</table>




