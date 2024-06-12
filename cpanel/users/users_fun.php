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



	
	if($_SESSION['user_type']!=1)
	{
		$return_data['head']="error";
		$return_data['body']="لا تملك صلاحيات";
		echo json_encode($return_data);
		exit();
	}
	
	

	
	if ($_REQUEST['action'] == 'cancel_row') 
	{
		$row_id = intval($_REQUEST['row_id']);

		
		$delete = mysqli_query($connect, "UPDATE `users` SET del=1 WHERE id='$row_id'");
		if (!$delete) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا في حذف الملف";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم حذف السجل بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$ok_msg;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	
	if ($_REQUEST['action'] == 'block_unblock') 
	{
		$row_id = intval($_REQUEST['row_id']);
		$is_blocked = intval($_REQUEST['is_blocked']);
		$blocked_note = mysqli_real_escape_string($connect, $_POST['blocked_note']);

		
		$delete = mysqli_query($connect, "UPDATE `users` SET is_blocked=$is_blocked,blocked_note='$blocked_note' WHERE id='$row_id'");
		if (!$delete) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا اثناء تنفيذ الاجراء";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم تنفيذ الاجراء بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$ok_msg;
		echo json_encode($return_data);
		exit();
		
		
	}
	

			
	//---------------------------------------------------------------------

	if ($_POST['action'] == 'add_row' || $_POST['action'] == 'edit_row') 
	{
	
		$first_name = mysqli_real_escape_string($connect, $_POST['first_name']);
		if(!empty($first_name))$first_name="'$first_name'";
		else
		{
			$return_data["head"]="error";
			$return_data["body"]="يجب كتابة الاسم الاول";
			echo json_encode($return_data);
			exit();
		}
		
		$family_name = mysqli_real_escape_string($connect, $_POST['family_name']);
		if(!empty($family_name))$family_name="'$family_name'";
		else
		{
			$return_data["head"]="error";
			$return_data["body"]="يجب كتابة الاسم الاخير";
			echo json_encode($return_data);
			exit();
		}
		
    $address = mysqli_real_escape_string($connect, $_POST['address']);
		if(!empty($address))$address="'$address'";
		else $address="NULL";
		
		$phone = mysqli_real_escape_string($connect, $_POST['phone']);
		if(!empty($phone))$phone="'$phone'";
		else
		{
			$return_data["head"]="error";
			$return_data["body"]="يجب ادخال رقم الهاتف";
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
    
    
    

		$city_id = intval($_POST['city_id']);

		
		$user_type = intval($_POST['user_type']);

    
	 	$password =$_POST['password'];
	 	if(!empty($password))
	 	{
	 	  $password=hash("sha256",$password);
	 	  $password_update="password='$password', ";
	 	}
		else if($_POST['action'] == 'add_row')
		{
			$return_data["head"]="error";
			$return_data["body"]="يجب ادخال كلمة مرور";
			echo json_encode($return_data);
			exit();
		}

	}

	if ($_POST['action'] == 'add_row') 
	{
      //-----------------------------------------

      $sql = mysqli_query($connect, "SELECT * FROM users WHERE phone=$phone");
      $num = mysqli_num_rows($sql);


      if ($num > 0) 
      {
        $return_data["head"]="error";
        $return_data["body"]="رقم الهاتف موجود مسبقا لشخص اخر ";
        echo json_encode($return_data);
        exit();
      } 
      //-----------------------------------------

		 $sql="
		 INSERT INTO users 
		        (first_name,family_name,address,phone,img,city_id,user_type,password)
		 VALUES
		        ($first_name,$family_name,$address,$phone,$img_dst,$city_id,$user_type,'$password')";

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
    
    //-----------------------------------------
    $sql = mysqli_query($connect, "SELECT * FROM users WHERE phone=$phone AND id!=$row_id");
    $num = mysqli_num_rows($sql);


    if ($num > 0) 
    {
      $return_data["head"]="error";
	    $return_data["body"]="رقم الهاتف موجود مسبقا لشخص اخر ";
	    echo json_encode($return_data);
	    exit();
    } 
    //-----------------------------------------

		$sql="UPDATE users SET 
				first_name=$first_name,
				family_name=$family_name,
				address=$address,
				phone=$phone,
				$img_update
				$password_update
				city_id=$city_id,
				user_type=$user_type
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

