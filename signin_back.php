
<?php

require "config.php";


$return_data=array();



$phone = mysqli_real_escape_string($connect, $_POST['phone']);
$password = hash("sha256", $_POST['password']);



if ($phone AND $password ) 
{

    $sql="SELECT * FROM users WHERE phone='$phone' AND password='$password' AND is_blocked=1";
    $blocked = mysqli_query($connect, $sql) or die("mysql error");

    if (mysqli_num_rows($blocked) != 0) 
    {
      if($row = mysqli_fetch_object($blocked))
      {
        $blocked_note=$row->blocked_note;
      }
		  $return_data["head"]="error";
		  $return_data["body"]="هذا الحساب محظور بسبب $blocked_note";
		  echo json_encode($return_data);
		  exit;
    }
    
      
	  $sql="SELECT * FROM users WHERE phone='$phone' AND password='$password' AND del=0 AND is_blocked=0";
    $finder = mysqli_query($connect, $sql) or die("mysql error");

    if (mysqli_num_rows($finder) != 0) 
    {
      while ($row = mysqli_fetch_object($finder)) 
      {
          $user_id = $row->id;
          $phone = $row->phone;
          $password = $row->password;
          $user_type = $row->user_type;
      }
      
        


      unset($_SESSION['user_id']);
      unset($_SESSION['phone']);
      unset($_SESSION['password']);
      unset($_SESSION['user_type']);




	    //sleep(2);

	    $_SESSION['user_id'] = $user_id;
	    $_SESSION['phone'] = $phone;
	    $_SESSION['password'] = $password;
	    $_SESSION['user_type'] = $user_type;

	    $return_data["body"]="";
	    $return_data["head"]="ok";
	    echo json_encode($return_data);
	    exit;
	        
	  }
	  else
	  {
		  $return_data["head"]="error";
		  $return_data["body"]="اسم المستخدم أو كلمة المرور غير صحيحة";
		  echo json_encode($return_data);
		  exit;
	  }
		
  
} 
else 
{
	$return_data["head"]="error";
  $return_data["body"]="الرجاء ادخال اسم المستخدم وكلمة المرور ";
  echo json_encode($return_data);
  exit;
}









