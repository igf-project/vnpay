<?php 
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");

$objmysql =  new CLS_MYSQL;

if(isset($_POST['identify'])) {
	$identify = $_POST['identify'];
	$sql = "SELECT * FROM tbl_member  WHERE identify='$identify'";
	$objmysql->Query($sql);	
	$r=$objmysql->Fetch_Assoc();
	$id=$r['id'];
	$json = "[";
	if ($objmysql->Num_rows() > 0)  {
		$json.= "{\"rep\":\"yes\", \"id\": \"$id\"}";
	} 
	else {
		$json.= "{\"rep\":\"no\", \"id\": \"\"}";
	}
	echo $json."]";
}
if(isset($_POST['update'])){
	$identify = $_POST['update'];
	$sql = "SELECT * FROM tbl_member  WHERE identify='$identify'";
	$objmysql->Query($sql);	
	$r=$objmysql->Fetch_Assoc();
	$id=$r['id'];
	$json = "[";
	if ($objmysql->Num_rows() > 1)  {
		$json.= "{\"rep\":\"yes\", \"id\": \"$id\"}";
	} 
	else {
		$json.= "{\"rep\":\"no\", \"id\": \"\"}";
	}
	echo $json."]";
}
if(isset($_POST['txt_keyword'])){
	$keyword = $_POST['txt_keyword'];
	$sql="SELECT * FROM tbl_member  WHERE identify='$keyword' OR `fullname` LIKE '%".$keyword."%'";
	$objmysql->Query($sql);	
	$r=$objmysql->Fetch_Assoc();
	$id=$r['id'];
	$json = "[";
	if ($objmysql->Num_rows() > 0)  {
		$json.= "{\"rep\":\"yes\", \"id\": \"$id\"}";
	} 
	else {
		$json.= "{\"rep\":\"no\", \"id\": \"\"}";
	}
	echo $json."]";
}
?>