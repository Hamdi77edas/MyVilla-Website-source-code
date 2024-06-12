<?php

	include '../open_session.php';


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

		
		$delete = mysqli_query($connect, "UPDATE `contact` SET del=1 WHERE id='$row_id'");
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
	







?>

