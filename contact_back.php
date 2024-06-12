
<?php

ob_start();
session_start();
require "config.php";

$return_data=array();


$first_name = mysqli_real_escape_string($connect, $_POST['first_name']);
$family_name = mysqli_real_escape_string($connect, $_POST['family_name']);
$title = mysqli_real_escape_string($connect, $_POST['title']);
$content = mysqli_real_escape_string($connect, $_POST['content']);
$phone = mysqli_real_escape_string($connect, $_POST['phone']);



	
$sql="INSERT INTO contact
(first_name,family_name,title,content,phone) 
VALUES
('$first_name','$family_name','$title','$content','$phone')";


$query = mysqli_query($connect, $sql);

$last_row_id = mysqli_insert_id($connect);/////mean SELECT * FROM contact WHERE id = SCOPE_IDENTITY();


if(!$query)
{
  $return_data["head"]="error";
	$return_data["body"]="حدث خطأ اثناء تسجيل البيانات ";
	echo json_encode($return_data);
	exit();
}


$return_data["head"]="ok";
$return_data["body"]="تم الارسال بنجاح";
echo json_encode($return_data);
exit();




ob_end_flush();








