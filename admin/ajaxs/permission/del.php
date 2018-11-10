<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.permission.php");
$objdata=new CLS_MYSQL;
$obj_permission=new CLS_PERMISSION;

/*if(!$objuser->isLogin()){
	die("E01");
}*/
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$obj_permission->getList(" AND id=$id");
$r=$obj_permission->Fetch_Assoc();
// if($r['isroot']==1) die('E02');
$sql="DELETE FROM tbl_permission WHERE id='$id'";
$objdata->Exec($sql);
$obj_permission->getGroupPermission();
?>