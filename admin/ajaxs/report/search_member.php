<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.permission.php");
$objuser=new CLS_USER;
$obj_permission=new CLS_PERMISSION;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}

$strwhere='';
$keywork = isset($_POST['txt_keyword'])?stripslashes($_POST['txt_keyword']):'';
$teacher = isset($_POST['cbo_teacher'])?(int)$_POST['cbo_teacher']:0;
$course = isset($_POST['cbo_course'])?(int)$_POST['cbo_course']:0;
if($keywork!=''){
	$strwhere.=" AND mem_id IN(SELECT id FROM tbl_member WHERE isactive=1 AND `fullname` LIKE '%$keywork%')";
}
if($teacher!=0) $strwhere.=" AND user_id=$teacher ";
if($course!=0) $strwhere.=" AND course_id=$course ";

echo $strwhere;
?>