

<?php
include "../open_session.php";



if (isset($_POST['_SAVE_UPDATE_BTN_']) ) 
{



	
	$name=mysqli_real_escape_string($connect,$_POST['name']);
	$sort=intval($_POST['sort']);


	if($_POST['_SAVE_UPDATE_BTN_'] == 'حفظ')
	{//save

		#---------------------------------------------------------------------------


		$sql= "INSERT INTO city (name,sort) 
				VALUES 
				('$name',$sort)";
		
		//echo $sql;
		
	    $query = mysqli_query($connect, $sql );

	    if ($query) {
	        header('Location:city.php ');
	        exit;
	    }
		
		
		
    
        
        
        
	}//save







	else if ($_POST['_SAVE_UPDATE_BTN_'] == 'تعديل') 
	{//update
		


		$city_id=intval($_POST['city_id']);


		$sql="UPDATE city SET name='$name',sort='$sort' WHERE id='$city_id'";
		
	
	    $query = mysqli_query($connect, $sql);


	          
	    if ($query) {
	        header('Location:city.php ');
	        exit;
	    } else {
	        echo 'cant';
	    }
	

        
        
	}//update

}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == '_DELETE_DATA_') {


       if (isset($_SERVER['HTTP_REFERER'])) {

			$city_id = intval($_GET['city_id']);
			if ($city_id) {

				$del = mysqli_query($connect, "DELETE FROM `city` WHERE id='$city_id'");
				if ($del) {
	        header('Location:city.php ');
					exit;
					
						
				}
			}

	  } else {
		    die("error request");
		}
}


	

?>


