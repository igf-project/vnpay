<?php
session_start();
require_once("../../includes/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.category.php");
$objuser=new CLS_USER;
$obj=new CLS_CATEGORY;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$sql="DELETE FROM tbl_category WHERE cate_id='$id'";
$objdata->Exec($sql);
$obj->getListCategory();
?>