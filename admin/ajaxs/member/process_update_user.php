<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");

$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
} 

$mem_id=isset($_POST['txt_user_id'])?(int)$_POST['txt_user_id']:0;
$fullname = addslashes($_POST['txt_fullname']);
$identify = addslashes($_POST['txt_cmtnd']);
$phone = (int)$_POST['txt_phone'];
$email = addslashes($_POST['txt_email']);
$address = addslashes($_POST['txt_address']);
$date = date('Y-m-d H:i:s');

$file=$file1='';

if(isset($_POST['upload_avatar']) && $_POST['upload_avatar']!=''){
	$img = $_POST['upload_avatar'];
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$data = base64_decode($img);
	$file1 = '../../uploads/'.uniqid() . '.png';
	$success = file_put_contents($file1, $data);
}
if(isset($_POST['img_base64']) && $_POST['img_base64']!=''){
	$img = $_POST['img_base64'];
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$data = base64_decode($img);
	$file = '../../uploads/'.uniqid() . '.png';
	$success = file_put_contents($file, $data);
}

if(isset($_POST['cmd_update_user'])) {
	$sql="UPDATE tbl_member SET 
	`fullname`='$fullname',
	`phone`='$phone',
	`email`='$email',
	`address`='$address',
	`avatar`='$file1',
	`imgbase64`='$file',
	`identify`='$identify'
	WHERE id=$mem_id";
	if($objdata->Query($sql)){}
		else{echo 'E04';}
}else{
	$sql="INSERT INTO tbl_member(`fullname`,`phone`,`email`,`address`,`avatar`,`imgbase64`,`identify`,`joindate`,`isactive`) VALUES('$fullname','$phone','$email','$address','".$file1."','".$file."','$identify','$date',1)";
	if($objdata->Query($sql)){}
		else{echo 'E04';}
}
?>