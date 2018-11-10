<?php
session_start();
require_once("../../includes/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.cate_recruitment.php");
$objuser=new CLS_USER;
$obj=new CLS_CATEGORY_RECRUITMENT;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$sql="DELETE FROM tbl_cate_recruitment WHERE cate_id='$id'";
$objdata->Exec($sql);
$obj->getListCategory();
?>