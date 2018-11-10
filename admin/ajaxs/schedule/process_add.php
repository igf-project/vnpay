<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.schedule.php");
require_once("../../libs/cls.user.php");
$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
$objSchedule = new CLS_SCHEDULE();
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
} 
$id_schedule=isset($_POST['txt_id'])?(int)$_POST['txt_id']:0;
$objSchedule->IdBoss = trim($_POST['cbo_boss']);
if (isset($_POST['txt_user_id']) && $_POST['txt_user_id'] != '') {
	$objSchedule->IdUser = trim($_POST['txt_user_id']);
}

$objSchedule->Task = trim($_POST['txt_content']);	
$objSchedule->TimeNumber = $_POST['time_number'];
$objSchedule->AttachUser = trim($_POST['attach_user']);	
$objSchedule->NumberUser = trim($_POST['txt_number']);
if($id_schedule==0){
	$objSchedule->Add_new();
}else{
	$objSchedule->ID=$id_schedule;
	$objSchedule->Update();
}
?>