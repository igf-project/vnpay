<?php
session_start();
require_once("../../includes/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.cate_intro.php");
$objuser=new CLS_USER;
$obj=new CLS_CATEGORY_INTRO;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}
$id=isset($_POST['id'])?(int)$_POST['id']:0;
$thumb=isset($_POST['thumb']) ? addslashes($_POST['thumb']):'';
$sql="UPDATE `tbl_cate_intro` SET `thumb`='' WHERE cate_id='$id' AND thumb = '".$thumb."'";
$objdata->Exec($sql);
echo 'OK';
?>