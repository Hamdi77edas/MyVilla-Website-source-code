<?php

	include '../open_session.php';
  function image_upload($datafile)
  {

	  #----------------------------------------------------------
	  $element_name = $datafile['element_name'];
	  $upload_folder_location = $datafile['upload_folder_location'];
	  #----------------------------------------------------------

	  $targetFile = $upload_folder_location .basename($_FILES[$element_name]["name"]);
    
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    $new_name=strval(rand())."_image_upload_".strval(time()).".".strval($imageFileType);
    
    $targetFile = $upload_folder_location.$new_name;
    

    if(move_uploaded_file($_FILES[$element_name]["tmp_name"], $targetFile)){
      return $new_name;
    } else {
      return -1;
    }

  }


	$return_data=array();


	
	$user_id=$_SESSION['user_id'];

	
	if ($_REQUEST['action'] == 'cancel_row') 
	{
		$row_id = intval($_REQUEST['row_id']);

		
		$delete = mysqli_query($connect, "DELETE FROM `adv` WHERE id='$row_id'");
		if (!$delete) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا في الحذف ";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم حذف السجل بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$ok_msg;
		echo json_encode($return_data);
		exit();
		
		
	}

			
	//---------------------------------------------------------------------

	if ($_POST['action'] == 'add_row' || $_POST['action'] == 'edit_row') 
	{
	
		$topic = mysqli_real_escape_string($connect, $_POST['topic']);
		if(!empty($topic))$topic="'$topic'";
		else
		{
			$return_data["head"]="error";
			$return_data["body"]="يجب كتابة العنوان";
			echo json_encode($return_data);
			exit();
		}
		
		

    $img_dst="NULL";
		if (!empty($_FILES['img']['name'])) 
		{
			#---------------------------------------------------------------------------
			$datafile=array();
			$datafile['element_name']='img';
			$datafile['upload_folder_location']="../../DRIVE/";
			$img_dst=image_upload($datafile);
			#---------------------------------------------------------------------------
			$img_dst_temp=$img_dst;
			$img_dst="'$img_dst'";
			
		}
    if($img_dst!="NULL")$img_update="img=$img_dst,";

	}

	if ($_POST['action'] == 'add_row') 
	{

		
		 $sql="
		 INSERT INTO adv 
		        (topic,img)
		 VALUES
		        ($topic,$img_dst)";

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



	if ($_POST['action'] == 'edit_row') 
	{
		$row_id = intval($_POST['row_id']);

		$sql="UPDATE adv SET 
		    $img_update
				topic=$topic
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

