<?php
session_start();
require_once("../../includes/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.question_group.php");
$obj=new CLS_QUESTION_GROUP;
$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$sql="DELETE FROM tbl_question_group WHERE cate_id='$id'";
$objdata->Exec($sql);
$obj->getListCategory();
?>