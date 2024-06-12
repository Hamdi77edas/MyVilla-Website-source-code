

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
        
        
        
<?php
$where_user_type="";
if(is_numeric($_GET['user_type']))
{
  $where_user_type=" AND user_type=".intval($_GET['user_type']);  
}


?>


<script>


function delete_row_fun(element,action,row_id)
{

	var ok=confirm("هل تريد بالتاكيد حذف السجل؟");
	if(!ok)return;
	
	var pass_data={
		'action':action,
		'row_id':row_id,
	}


	$.ajax({
		type:"POST",
		url:"users_fun.php",
		data:pass_data,
		success: function(response) {

			response=JSON.parse(response.trim());
		
			if(response.head=="ok")
			{
				$(element).parent().parent().fadeOut('slow');
	
			}
			else if(response.head=="error")
			{
				alert(response.body);
			}
			

	 	}
	});
		
					


}



</script>


<div class="title">سجل الأعضاء</div>
<br>
<center>
<a class="btn btn-primary" style="background:#fdfdfd;border:1px solid #aaa;color:#222;" href="users_form.php?action=add_row&city_id=<?php echo $city_id;?>&specialty_id=<?php echo $specialty_id;?>" >
		<span style="float:right;margin-right:10px;" >اضافة مستخدم جديد</span>
</a>

</center>
<a class="btn btn-light" style="text-decoration:none;" href="?user_type=all">الجميع</a>
<a class="btn btn-light" style="text-decoration:none;" href="?user_type=1">الاداريين</a>
<a class="btn btn-light" style="text-decoration:none;" href="?user_type=2">أصحاب الفلل</a>
<a class="btn btn-light" style="text-decoration:none;" href="?user_type=3">المستأجرين</a>

<br>

<br>
<table class="table" width="100%" >
    <tr class="firstTR">
    
        <th width="3%"></th>
        <th width="7%">الصورة</th>
        <th width="16%">الإسم</th>
        <th width="16%">الهاتف</th>
        

        <th width="5%">نوع الحساب</th>

        <th width="12%" >المدينة</th>

        <th width="16%">العنوان</th>
        
        <th width="8%" ><strong style="color:red;">قائمة الحظر</strong></th>

        <th width="4%">حظر</th>
        <th width="4%">تعديل</th>
        <th width="4%">حذف</th>
 
    </tr>
    <?php

    
		$sql = "SELECT 
		users.id,
		users.is_blocked,
		users.first_name,
		users.family_name,
		users.img,
		users.phone,
		users.address,
		users.user_type,
		city.name as city_name 
		FROM users 
		LEFT JOIN city ON users.city_id=city.id   
		WHERE 1  
		$where_user_type
		AND users.del=0 
		ORDER BY users.id DESC";
		
    //echo $sql;
    
    $query = mysqli_query($connect, $sql);
    $row_number=0;
    while ($row = mysqli_fetch_array($query)) {
        $id = $row['id'];
        $row_number=$row_number+1;

		    $users_id=$row['id'];

        ?>
        <tr>
            <td><?php echo $row_number; ?></td>
            <td><?php if($row['img']){?><img src="../../DRIVE/<?php echo $row['img']; ?>" style="width:77px;border-radius:5px;" /><?php }?></td>
            <td><?php echo $row['first_name']." ".$row['family_name']; ?></td>
            
            <td><?php echo $row['phone']; ?></td>
            
            <td><?php echo array(1=>"اداري",2=>"صاحب فيلا",3=>"مستأجر")[$row['user_type']]; ?></td>

   
            <td><span style="color:#555;font-weight:bold;"><?php echo $row['city_name']; ?></span></td>
            
            <td><?php echo $row['address']; ?></td>
            <td><?php echo array(0=>"",1=>"<i class='fa fa-check' style='font-size:1.8em;color:red;'></i>")[$row['is_blocked']]; ?></td>

            <td><a class="fa fa-chain-broken" style="font-size:1.5em;text-decoration:none;" title="حظر" href="users_block.php?action=block&row_id=<?php echo $id; ?>"> </a></td>
            
            <td><a class="iconEdit" title="تعديل  " href="users_form.php?action=edit_row&row_id=<?php echo $id; ?>"> </a></td>
            <td><a class="iconDel" onclick="delete_row_fun(this,'cancel_row',<?php echo $id; ?>)" title="حذف " ></a></td>

        </tr>
    <?php 
    }
     ?>
</table>



