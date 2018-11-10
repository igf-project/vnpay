<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.permission.php");
$objdata=new CLS_MYSQL;
$obj_permission = new CLS_PERMISSION();

$id=isset($_POST['txt_id'])?(int)$_POST['txt_id']:0;
$name=isset($_POST['txt_name'])?addslashes($_POST['txt_name']):'';
$intro=isset($_POST['txt_intro'])?addslashes($_POST['txt_intro']):'';
if($id>0){
	$sql="UPDATE `tbl_permission` SET `name`='$name',`intro`='$intro' WHERE id='$id'";
	$sql=$objdata->Exec($sql);
}else{
	$sql="INSERT INTO tbl_permission(`name`,`intro`) VALUES ('$name','$intro')";
	$sql=$objdata->Query($sql);
}
$obj_permission->getGroupPermission();
?>