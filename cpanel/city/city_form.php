
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



$name="";


$action_function="new";

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_form') {

   if (isset($_SERVER['HTTP_REFERER'])) 
   {
		$action_function="update";

		$city_id=$_GET['city_id'];

		$sql="SELECT * FROM city WHERE 1 AND city.id=$city_id";  
		   
		//echo $sql;

		$query=mysqli_query($connect,$sql);
		$row = mysqli_fetch_array($query);



		$name=htmlspecialchars($row['name']);
		
		$sort=intval($row['sort']);



			

   
	} 
	else 
	{
	    die("error request");
	}
}


?>

<form method="POST" action="city_functions.php" enctype="multipart/form-data">

    <table dir="rtl" width="70%" class="tablein">

        
        <tr>
            <td width=25%>اسم المدينة</td>
            <td><input class="cp_input" style="width:260px;" type="text" name="name" required="required" value='<?php echo $name; ?>' required/></td>
        </tr>
        <tr>
            <td width=25%>ترتيب العرض</td>
            <td><input class="cp_input" style="width:260px;" type="number" name="sort" required="required" value='<?php echo $sort; ?>' required/></td>
        </tr>
        

        <tr>
            <td></td>
            
			<?php 
		    if($action_function=="update")
		    {
		    ?>
		    
		    	<input type='hidden' name='city_id' value='<?php echo $city_id;?>' />
		    	<td><input type='submit' name='_SAVE_UPDATE_BTN_' value='تعديل'/></td>				    
		    <?php
		    }
		    else if($action_function=="new")
		    {
		    ?>							    
					    
            	<td><input type='submit' name='_SAVE_UPDATE_BTN_' value='حفظ' /></td>
            	
		    <?php
		    }
		    ?>                    	
        </tr>
        
        
        
    </table>
</form>

        

