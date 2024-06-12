<?php

	include 'config.php';
	$return_data=array();
	
	if($_SESSION['user_type']!=1 && $_SESSION['user_type']!=2 && $_SESSION['user_type']!=3)
	{
		$return_data['head']="error";
		$return_data['body']="خطا في الجلسة";
		echo json_encode($return_data);
		exit();
	}
	
	$by_user_id=$_SESSION['user_id'];
	
	
	
	
	
	

	if ($_REQUEST['action'] == 'send_order') 
	{
		$villa_id = intval($_REQUEST['villa_id']);
		
    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];

    if (strtotime($from_date) > strtotime($to_date)) 
    {
        $return_data["head"] = "error";
        $return_data["body"] = "تاريخ البداية للحجز يجب أن يكون قبل تاريخ الانتهاء";
        echo json_encode($return_data);
        exit();
    } 

    
    //-----------------------------------------

    $sql = mysqli_query($connect, "SELECT * FROM reservation_list WHERE 1 AND by_user_id=$by_user_id AND villa_id=$villa_id AND del=0 AND owner_response=0");
    $num = mysqli_num_rows($sql);
    if ($num > 0) 
    {
      $return_data["head"]="error";
      $return_data["body"]="لا يمكنك إرسال طلب حجز لهذه الفيلا قبل أن يتم الرد من قبل المالك على الطلب المُرسل مسبقاً ";
      echo json_encode($return_data);
      exit();
    } 
    //-----------------------------------------
    
    //-----------------------------------------

    $sql = mysqli_query($connect, "SELECT * FROM reservation_list WHERE 1 AND (from_date <= '$to_date' AND to_date >= '$from_date') AND del=0 AND owner_response!=2");
    
    $num = mysqli_num_rows($sql);
    if ($num > 0) 
    {
      $row = mysqli_fetch_array($sql);
      
      $this_from=$row['from_date'];
      $this_to=$row['to_date'];
      
      $return_data["head"]="error";
      $return_data["body"]="هذا الموعد غير متاح للحجز من تاريخ $this_from الى تاريخ $this_to";
      echo json_encode($return_data);
      exit();
    } 
    //-----------------------------------------
    
		$sent_datetime=date("Y-m-d H:i");
		
		$sql="INSERT INTO `reservation_list`(`sent_datetime`, `villa_id`, `by_user_id`, `from_date`, `to_date`) VALUES ('$sent_datetime',$villa_id,$by_user_id,'$from_date','$to_date') ";
		$query = mysqli_query($connect, $sql);
		if (!$query) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="حدث خطا في الارسال";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم ارسال الطلب بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$ok_msg;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	
	if ($_REQUEST['action'] == 'renter_evaluation') 
	{
		$order_id = intval($_REQUEST['order_id']);
		$evaluation = intval($_REQUEST['evaluation']);

    
		
		$sql="UPDATE `reservation_list` SET renter_evaluation=$evaluation WHERE 1 AND id=$order_id and by_user_id=$by_user_id ";
		$query = mysqli_query($connect, $sql);
		if (!$query) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="لم يتم التقييم ربما لست انت مرسل الطلب";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم التقييم بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$sql;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	if ($_REQUEST['action'] == 'owner_evaluation') 
	{
		$order_id = intval($_REQUEST['order_id']);
		$evaluation = intval($_REQUEST['evaluation']);

    
		
		$sql="UPDATE `reservation_list` SET owner_evaluation=$evaluation WHERE 1 AND id=$order_id ";
		$query = mysqli_query($connect, $sql);
		if (!$query) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="لم يتم التقييم";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم التقييم بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$sql;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	if ($_REQUEST['action'] == 'delete_order') 
	{
		$order_id = intval($_REQUEST['order_id']);


		if($_SESSION['user_type']==1)
		  $sql="UPDATE `reservation_list` SET del=1 WHERE 1 AND id=$order_id ";
		if($_SESSION['user_type']==3)
		  $sql="UPDATE `reservation_list` SET del=1 WHERE 1 AND id=$order_id AND owner_response=0 ";
		  
		$query = mysqli_query($connect, $sql);
		if (!$query) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="خطا في الحذف";
			echo json_encode($return_data);
			exit();
		}
		
		$affected_rows = mysqli_affected_rows($connect);
		if($affected_rows==0)
		{
			$return_data["head"]="error";
			$return_data["body"]="لا يمكن الحذف بعد رد مالك الفيلا";
			echo json_encode($return_data);
			exit();
		}
		
		$ok_msg="تم الحذف بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$sql;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	
	if ($_REQUEST['action'] == 'send_response') 
	{
		$order_id = intval($_REQUEST['order_id']);
		
		$owner_response = intval($_REQUEST['response']);


		
		$sql="UPDATE `reservation_list` SET owner_response=$owner_response WHERE 1 AND id=$order_id ";
		$query = mysqli_query($connect, $sql);
		if (!$query) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="خطا في الرد";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم الرد بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$sql;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	
	if ($_REQUEST['action'] == 'payment_status') 
	{
		$order_id = intval($_REQUEST['order_id']);
		
		$payment_status = intval($_REQUEST['payment_status']);


		
		$sql="UPDATE `reservation_list` SET payment_status=$payment_status WHERE 1 AND id=$order_id ";
		$query = mysqli_query($connect, $sql);
		if (!$query) 
		{	
			$return_data["head"]="error";
			$return_data["body"]="خطا في تغير الحالة";
			echo json_encode($return_data);
			exit();
		}
		$ok_msg="تم تغير الحالة بنجاح";
		$return_data["head"]="ok";
		$return_data["body"]=$sql;
		echo json_encode($return_data);
		exit();
		
		
	}
	
	
	
	
	
?>
	
	
