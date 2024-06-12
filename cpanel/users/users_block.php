

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

  var blocked_note=$("[name='blocked_note']").val();


	var is_blocked=$("[name='is_blocked']").val();
	
	var row_id=$("#row_id").val();
	
	
  //var pass_data={};
	var pass_data = new FormData();
	pass_data.append('action',action);

  pass_data.append('blocked_note',blocked_note);

	pass_data.append('is_blocked',is_blocked);
	
  pass_data.append('row_id',row_id);


	

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


if (isset($_SERVER['HTTP_REFERER'])) 
{

  $row_id = intval($_GET['row_id']);
  $sql="SELECT * FROM users WHERE users.id='$row_id'";

  //echo $sql;
  $query = mysqli_query($connect, $sql);
  $row = mysqli_fetch_array($query);

  $first_name = htmlspecialchars($row['first_name']);
  $city_id = $row['city_id'];



  $is_blocked=$row['is_blocked'];
  $family_name=$row['family_name'];
  $blocked_note=$row['blocked_note'];
  $phone=$row['phone'];

} else {
  die("error request");
}





?>




<div align="middle">
<div class="title" style="">حظر المستخدم</div>


<table dir="rtl" width="50%" class="tablein" style="border:2px solid #c55;background:#c551;max-width:400px;">
    

  <tr>
      <td width="25%">الاسم الاول</td>
      <td><?php echo $first_name; ?></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td width="25%">الاسم الاخير</td>
      <td><?php echo $family_name; ?></td>
  </tr>

  <tr>
    <td width="25%">هاتف</td>
      <td><?php echo $phone; ?></td>
  </tr>


  <tr>
    <td width="25%">حالة الحظر </td>
    <td>
      <select class="stander_select_list" name="is_blocked" required="required">
      <option value="1" <?php if($is_blocked == 1)echo "selected";?>>حظر</option>
      <option value="0" <?php if($is_blocked == 0)echo "selected";?>>الغاء الحظر</option>
      </select>
    </td>
  </tr>
  <tr>
    <td width="25%">سبب الحظر</td>
      <td><input type="text" name="blocked_note" class="cp_input" style="" required="required" value='<?php echo $blocked_note; ?>' /></td>
  </tr>

    <tr><td colspan=4><hr></td></tr>



    <tr class="control_showing" >

		    	<input type='hidden' id='row_id' value='<?php echo $row_id;?>' />
		    	<td colspan=2>
		    	
		    		<button class="btn btn-danger" type='submit' onclick="run_controller(this,'block_unblock');" >تنفيذ الاجراء</button>
		    	</td>


    </tr>
    <tr><td colspan=2 align="middle"><div id="response-msg"></div></td></tr>


</table>




