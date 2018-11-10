<?php
session_start();
require_once("../../includes/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.document_type.php");
$obj=new CLS_DOCUMENT_TYPE;
$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$sql="DELETE FROM tbl_document_type WHERE doctype_id='$id'";
$objdata->Exec($sql);
$obj->getListCategory();
?>