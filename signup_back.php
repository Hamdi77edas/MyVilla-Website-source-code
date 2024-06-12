
<?php

ob_start();
session_start();
require "config.php";

$return_data=array();

//=======================================image_upload
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
//=======================================
  
$first_name = mysqli_real_escape_string($connect, $_POST['first_name']);
$family_name = mysqli_real_escape_string($connect, $_POST['family_name']);
$phone = mysqli_real_escape_string($connect, $_POST['phone']);
$address = mysqli_real_escape_string($connect, $_POST['address']);

$password = hash("sha256", $_POST['password']);

$user_type = intval($_POST['user_type']);
$city_id = intval($_POST['city_id']);


$sql = mysqli_query($connect, "SELECT * FROM users WHERE phone='$phone'");
$num = mysqli_num_rows($sql);


if ($num > 0) 
{
  $return_data["head"]="error";
	$return_data["body"]="رقم الهاتف موجود مسبقا لشخص اخر ";
	echo json_encode($return_data);
	exit();
} 



$img_dst="NULL";
if (!empty($_FILES['img']['name'])) 
{
	#---------------------------------------------------------------------------
	$datafile=array();
	$datafile['element_name']='img';
	$datafile['upload_folder_location']="DRIVE/";
	$img_dst=image_upload($datafile);
	#---------------------------------------------------------------------------
	$img_dst_temp=$img_dst;
	$img_dst="'$img_dst'";
	
}

	
	
$sql="INSERT INTO users
(first_name,family_name,password,phone,user_type,city_id,address,img) 
VALUES
('$first_name','$family_name','$password','$phone',$user_type,$city_id,'$address',$img_dst)";


$query = mysqli_query($connect, $sql);

$last_row_id = mysqli_insert_id($connect);/////mean SELECT * FROM users WHERE id = SCOPE_IDENTITY();


if(!$query)
{
  $return_data["head"]="error";
	$return_data["body"]="حدث خطأ اثناء تسجيل البيانات ";
	echo json_encode($return_data);
	exit();
}


$return_data["head"]="ok";
$return_data["body"]="تم انشاء الحساب بنجاح";
echo json_encode($return_data);
exit();




ob_end_flush();








