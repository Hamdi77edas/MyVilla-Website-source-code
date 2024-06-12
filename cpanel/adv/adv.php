

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
		url:"adv_fun.php",
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


<div class="title">الاعلانات</div>

<?php 
		$sql = "SELECT 
		adv.id,
		adv.img,
		adv.topic
		FROM adv 
		WHERE 1  
		ORDER BY adv.id DESC";
    //echo $sql;
    
    $query = mysqli_query($connect, $sql);
    $rows_num=mysqli_num_rows($query);
    
    if($rows_num<4)
    {
?>
    <br>
    <center>
    <a class="btn btn-primary" style="background:#fdfdfd;border:1px solid #aaa;color:#222;" href="adv_form.php?action=add_row" >
		    <span style="float:right;margin-right:10px;" >اضافة اعلان</span>
    </a>
    </center>
  <?php
  }
  ?>

<br>
<table class="table" width="100%" >
    <tr class="firstTR">
    
        <th width="3%"></th>
        <th width="7%">الصورة</th>
        <th width="16%">العنوان</th>

        <th width="1%">تعديل</th>
        <th width="1%">حذف</th>
 
    </tr>
    <?php


    $row_number=0;
    while ($row = mysqli_fetch_array($query)) {
        $id = $row['id'];
        $row_number=$row_number+1;



		    $adv_id=$row['adv_id'];

        

        ?>
        <tr>
            <td><?php echo $row_number; ?></td>
            <td><?php if($row['img']){?><img src="../../DRIVE/<?php echo $row['img']; ?>" style="width:77px;border-radius:5px;" /><?php }?></td>
            <td><?php echo $row['topic']; ?></td>

            
            <td><a class="iconEdit" title="تعديل  " href="adv_form.php?action=edit_row&row_id=<?php echo $id; ?>"> </a></td>
            <td><a class="iconDel" onclick="delete_row_fun(this,'cancel_row',<?php echo $id; ?>)" title="حذف " ></a></td>

        </tr>
    <?php 
    }
     ?>
</table>



