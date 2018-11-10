<?php
session_start();
define("isHOME",true);
$flag = isset($_POST['language']) ? addslashes($_POST['language']) : '';

if($flag=='en'){
	$_SESSION['LANGUAGE']='en';
}else{
	$_SESSION['LANGUAGE']='vi';
}
?>
