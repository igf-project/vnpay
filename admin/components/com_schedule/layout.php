<?php
defined("ISHOME") or die("Can not acess this page, please come back!");
define("COMS","schedule");
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
// Begin Toolbar
$obj = new CLS_SCHEDULE();
$objcou = new CLS_COURSE();
// End toolbar
if($UserLogin->isLogin()) {
	$task=isset($_GET['viewtype'])?$_GET['viewtype']:'list';
	if(is_file(THIS_COM_PATH.'task/'.$task.'.php')){
		include_once(THIS_COM_PATH.'task/'.$task.'.php');
	}
}
unset($obj); unset($task);	unset($ids);
?>