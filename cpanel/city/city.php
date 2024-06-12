

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


<div align="middle" style="width:100%;">
    <div class='title' style="width:60%;" >المدينة</div>

<?php








?>
<br>
<a href="city_form.php" >
	<div align="right" class="btn btn-primary" style="background:#fdfdfd;border:1px solid #aaa;color:#222;" style="color:white;font-size:1em;margin:10px;">

		<span style="float:right;margin-right:10px;" >اضافة مدينة</span>

	</div>
</a>
<br><br>


<table class="table" style="width:60%;font-size:1em;">
    <tr class="firstTR">
        <th width="9%"></th>


        <th width="60%">اسم المدينة</th>

        <th width="9%">الترتيب</th>
        <th width="9%">تعديل</th>
        <th width="9%">حذف</th>
 
    </tr>
    <?php
    

    	
    
		$sql = "SELECT * FROM city WHERE 1 ORDER BY city.id DESC";

 
    $query = mysqli_query($connect, $sql);
    $row_number=1;
    while ($row = mysqli_fetch_array($query)) {
        $id = $row['id'];


        $row_number=$row_number+1;


		    $city_name=htmlspecialchars($row['name']);
		    $sort=intval($row['sort']);

        ?>
        <tr>
            <td><?php echo $row_number; ?></td>

            

            <td><span style="color:blue"><?php echo $city_name; ?></span></td>
            <td><span style="color:red"><?php echo $sort; ?></span></td>
            

              
            <td><a href="city_form.php?action=update_form&city_id=<?php echo $id; ?>"><img width=28 src="../../assets-cp/icons/update.png" title="تعديل معلومات المدينة"/></a></td>
            
            
            <td><a href="city_functions.php?action=_DELETE_DATA_&city_id=<?php echo $id; ?>"><img width=28 src="../../assets-cp/icons/delete.png" title="حذف المدينة" onclick="return confirm('هل تريد بالتأكيد حذف السجل ')"/></a></td>

        </tr>
    <?php 
    }
    
    
    
     ?>
</table>

