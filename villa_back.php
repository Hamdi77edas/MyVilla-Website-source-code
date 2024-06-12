<?php

	include 'config.php';
	$return_data=array();
	
	if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2)
	{
		$return_data['head']="error";
		$return_data['body']="خطا في الجلسة";
		echo json_encode($return_data);
		exit();
	}
	
	$by_user_id=$_SESSION['user_id'];
	
	
  function file_upload($datafile)
  {

	  #----------------------------------------------------------
	  $element_name = $datafile['element_name'];
	  $upload_folder_location = $datafile['upload_folder_location'];
	  #----------------------------------------------------------

	  $targetFile = $upload_folder_location .basename($_FILES[$element_name]["name"]);
    
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    $new_name=strval(rand())."_file_upload_".strval(time()).".".strval($imageFileType);
    
    $targetFile = $upload_folder_location.$new_name;
    

    if(move_uploaded_file($_FILES[$element_name]["tmp_name"], $targetFile)){
      return $new_name;
    } else {
      return -1;
    }

  }
  


	
	

	
	if ($_REQUEST['action'] == 'delete') 
	{
		$row_id = intval($_REQUEST['row_id']);

		
		$delete = mysqli_query($connect, "UPDATE `villas` SET del=1 WHERE id='$row_id'");
		if (!$delete) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا في حذف";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم حذف السجل بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$ok_msg;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	
	if ($_REQUEST['action'] == 'send_order') 
	{
		$villa_id = intval($_REQUEST['villa_id']);

    //-----------------------------------------

    $sql = mysqli_query($connect, "SELECT * FROM reservation_list WHERE 1 AND by_user_id=$by_user_id AND villa_id=$villa_id AND del=0 AND owner_response=0");
    $num = mysqli_num_rows($sql);
    if ($num > 0) 
    {
      $return_data["head"]="error";
      $return_data["body"]="لا يمكنك إرسال طلب حجز لهذه الفيلا قبل أن يتم الرد من قبل المالك على الطلب المُرسل مسبقاً";
      echo json_encode($return_data);
      exit();
    } 
    //-----------------------------------------
    
		$sent_datetime=date("Y-m-d H:i");
		
		$sql="INSERT INTO `reservation_list`(`sent_datetime`, `villa_id`, `by_user_id`) VALUES ('$sent_datetime',$villa_id,$by_user_id) ";
		$query = mysqli_query($connect, $sql);
		if (!$query) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا في الارسال";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم إرسال طلب لحجز لهذه الفيلا بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$ok_msg;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	

			
	//---------------------------------------------------------------------

	if ($_POST['action'] == 'insert_villa' || $_POST['action'] == 'update_villa') 
	{
	
		$latitude = mysqli_real_escape_string($connect, $_POST['latitude']);
		$latitude="'$latitude'";
		$longitude = mysqli_real_escape_string($connect, $_POST['longitude']);
		$longitude="'$longitude'";
		
		$title = mysqli_real_escape_string($connect, $_POST['title']);
		if(!empty($title))$title="'$title'";
		else
		{
			$return_data["head"]="error";
			$return_data["body"]="يجب كتابة العنوان";
			echo json_encode($return_data);
			exit();
		}
		
		
		$description = mysqli_real_escape_string($connect, $_POST['description']);
		if(!empty($description))$description="'$description'";
    else $description="NULL";
		

    $img_dst="NULL";
		if (!empty($_FILES['img']['name'])) 
		{
			#---------------------------------------------------------------------------
			$datafile=array();
			$datafile['element_name']='img';
			$datafile['upload_folder_location']="DRIVE/";
			$img_dst=file_upload($datafile);
			#---------------------------------------------------------------------------
			$img_dst_temp=$img_dst;
			$img_dst="'$img_dst'";
			
		}
		if($img_dst!="NULL")$img_update="img=$img_dst,";
		
		$video_dst="NULL";
		if (!empty($_FILES['video']['name'])) 
		{
			#---------------------------------------------------------------------------
			$datafile=array();
			$datafile['element_name']='video';
			$datafile['upload_folder_location']="DRIVE/";
			$video_dst=file_upload($datafile);
			#---------------------------------------------------------------------------
			$video_dst_temp=$video_dst;
			$video_dst="'$video_dst'";
			
		}
    
    
    if($video_dst!="NULL")$video_update="video=$video_dst,";
    


    $price = round(floatval($_POST['price']),2);

		$area = intval($_POST['area']);

		
		$city_id = intval($_POST['city_id']);



	}

	if ($_POST['action'] == 'insert_villa') 
	{

		 $sql="
		 INSERT INTO villas
		        (title,latitude,longitude,description,img,video,area,city_id,price,by_user_id)
		 VALUES
		        ($title,$latitude,$longitude,$description,$img_dst,$video_dst,$area,$city_id,$price,$by_user_id)";

		//echo  $insert_sql;

		$insert1 = mysqli_query($connect, $sql);

		

		if ( !$insert1) 
		{
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا في الاضافة";
			echo json_encode($return_data);
			exit();

		}
	
		$ok_msg="تم حفظ السجل بنجاح";
	}



	if ($_POST['action'] == 'update_villa') 
	{
		$row_id = intval($_POST['row_id']);

		$sql="UPDATE villas SET 
				title=$title,
				latitude=$latitude,
				longitude=$longitude,
				description=$description,
				$img_update
				$video_update
				area=$area,
				price=$price,
				city_id=$city_id
				WHERE id=$row_id ";
		//echo $sql;
		//exit;
		
		$update = mysqli_query($connect, $sql);
		
		if (!$update)
		{
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا في حفظ التعديلات";
			echo json_encode($return_data);
			exit();
		   
		}

		$ok_msg="تم تحديث البيانات بنجاح";
	}
	//-----------------------------------------------------------
	
	
	
	$return_data["head"]="ok";
	$return_data["body"]=$ok_msg;
	echo json_encode($return_data);
	exit();











?>

