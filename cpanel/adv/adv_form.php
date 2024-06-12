

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
	var topic=$("[name='topic']").val();

	
  //var pass_data={};
	var pass_data = new FormData();
	pass_data.append('action',action);
	pass_data.append('topic',topic);

  pass_data.append('img',$("[name='img']")[0].files[0]);/////


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
		url:"adv_fun.php",
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
			$sql="SELECT * FROM adv WHERE adv.id='$row_id'";
			
			//echo $sql;
		    $query = mysqli_query($connect, $sql);
		    $row = mysqli_fetch_array($query);

		    $topic = htmlspecialchars($row['topic']);

        $img=htmlspecialchars($row['img']);
		    $src="../../DRIVE/$img";
		    if(!file_exists($src) || is_dir($src))//اذا الملف غير موجود او اصلا غير مخزن ملف فيكون هذا عبارة عن عضو مجلد وليس ملف
		    {
			    $src='../../public-../assets-cp/images/empty.png';
		    }
			    
		    $element_image='<img src="'.$src.'" style="max-width:100px;max-height:100px;"/>';
		    
		    
		    
			  $sql="SELECT * FROM users WHERE id='$row[user_id]'";
		    $user_query = mysqli_query($connect, $sql);
		    $user_row = mysqli_fetch_array($user_query);
        $loginname = $user_row['loginname'];

       
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
<div class="title" style="">نموذج اضافة وتعديل</div>


<table dir="rtl" width="80%" class="tablein" style="border:1px dashed #999;">
   
  <tr>
      <td width="25%">العنوان</td>
      <td><input type="text" name="topic" class="cp_input" style="" required="required" value='<?php echo $topic; ?>' /></td>
      <td></td>
      <td></td>
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




