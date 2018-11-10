<?php
session_start();
require_once("../../includes/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.document_type.php");
$obj=new CLS_DOCUMENT_TYPE;
$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
} 

$id=isset($_POST['txt_id'])?addslashes($_POST['txt_id']):0;
$par_id=isset($_POST['cbo_cate'])?addslashes($_POST['cbo_cate']):0;
$name=isset($_POST['txt_name'])?addslashes($_POST['txt_name']):'';
$code=un_unicode($name);

if($id>0){
	$sql="UPDATE `tbl_document_type` SET `par_id`='$par_id',`name`='$name',`code`='$code' WHERE doctype_id='$id'";
	$sql=$objdata->Exec($sql);
}else{
	$sql="INSERT INTO tbl_document_type (`par_id`,`name`,`code`,`isactive`) 
	VALUES ('$par_id','$name','$code',1)";
	$sql=$objdata->Exec($sql);
}
$obj->getListCategory();
?>