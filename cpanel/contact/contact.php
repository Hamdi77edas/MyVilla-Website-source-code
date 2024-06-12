

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
		url:"contact_fun.php",
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


<div class="title">بلاغات عن مشاكل</div>
<br>


<br>
<table class="table" width="100%" >
    <tr class="firstTR">
    
        <th width="3%"></th>

        <th width="16%">الإسم</th>
        <th width="16%">الهاتف</th>
        

        <th width="12%" >العنوان</th>

        <th width="16%">المحتوى</th>
        

        <th width="4%">حذف</th>
 
    </tr>
    <?php

    
		$sql = "SELECT 
		contact.id,

		contact.first_name,
		contact.family_name,

		contact.phone,
		contact.title,
		contact.content


		FROM contact 

		WHERE 1  

		AND contact.del=0 
		ORDER BY contact.id DESC";
		
    //echo $sql;
    
    $query = mysqli_query($connect, $sql);
    $row_number=0;
    while ($row = mysqli_fetch_array($query)) {
        $id = $row['id'];
        $row_number=$row_number+1;

		    $contact_id=$row['id'];

        ?>
        <tr>
            <td><?php echo $row_number; ?></td>
           
            <td><?php echo $row['first_name']." ".$row['family_name']; ?></td>
            
            <td><?php echo $row['phone']; ?></td>
            
            <td><?php echo $row['title']; ?></td>
            
            <td><?php echo $row['content']; ?></td>
            
            <td><a class="iconDel" onclick="delete_row_fun(this,'cancel_row',<?php echo $id; ?>)" title="حذف " ></a></td>

        </tr>
    <?php 
    }
     ?>
</table>



