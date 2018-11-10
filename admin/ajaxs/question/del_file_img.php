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
$id=isset($_POST['id'])?(int)$_POST['id']:0;
$thumb=isset($_POST['thumb']) ? addslashes($_POST['thumb']):'';
$sql="UPDATE `tbl_question_group` SET `thumb`='' WHERE cate_id='$id' AND thumb = '".$thumb."'";
$objdata->Exec($sql);
echo 'OK';
?>