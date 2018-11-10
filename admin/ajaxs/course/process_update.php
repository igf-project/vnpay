<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
} 
$mem_id=isset($_POST['txt_user_id'])?(int)$_POST['txt_user_id']:0;
$name = addslashes($_POST['txt_name']);
$price = (int)$_POST['txt_price'];
$intro = addslashes($_POST['txt_intro']);

if(isset($_POST['cmd_update_user'])) {
	$sql="UPDATE tbl_course SET 
	`name`='$name',
	`price`='$price',
	`intro`='$intro'
	WHERE id=$mem_id";
	if($objdata->Query($sql)){}
		else{echo 'E04';}
}else{
	$sql="INSERT INTO tbl_course(`name`,`price`,`intro`,`isactive`) VALUES('$name','$price','$intro',1)";
	if($objdata->Query($sql)){}
		else{echo 'E04';}
}
?>