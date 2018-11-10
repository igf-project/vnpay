<?php
session_start();
require_once("../../includes/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.cate_recruitment.php");
$obj=new CLS_CATEGORY_RECRUITMENT;
$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$status=isset($_GET['status'])?(int)$_GET['status']:0;
$sql="UPDATE tbl_cate_recruitment SET isactive=$status WHERE cate_id='$id'";
$objdata->Exec($sql);
$obj->getListCategory();
?>