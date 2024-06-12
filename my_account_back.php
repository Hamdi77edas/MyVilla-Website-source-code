
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

if(!empty($_POST['password']))
{
  $password = hash("sha256", $_POST['password']);
  $password_update = "password='$password', ";
}

$city_id = intval($_POST['city_id']);


$sql = mysqli_query($connect, "SELECT * FROM users WHERE phone='$phone' AND id!=$_SESSION[user_id]");
$num = mysqli_num_rows($sql);


if ($num > 0) 
{
  $return_data["head"]="error";
	$return_data["body"]="رقم الهاتف موجود مسبقاً لشخص آخر ";
	echo json_encode($return_data);
	exit();
} 




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
	$img_update="img=$img_dst, ";
}

	
	
$sql="UPDATE users SET
      first_name ='$first_name',
      family_name='$family_name',
      $password_update 
      $img_update
      phone='$phone',
      city_id=$city_id,
      address='$address'
      WHERE 1
      AND id=$_SESSION[user_id]
";

$query = mysqli_query($connect, $sql);

$last_row_id = mysqli_insert_id($connect);/////mean SELECT * FROM users WHERE id = SCOPE_IDENTITY();


if(!$query)
{
  $return_data["head"]="error";
	$return_data["body"]="حدث خطأ أثناء تسجيل البيانات ";
	echo json_encode($return_data);
	exit();
}


$return_data["head"]="ok";
$return_data["body"]="تم الحفظ بنجاح";
echo json_encode($return_data);
exit();




ob_end_flush();








