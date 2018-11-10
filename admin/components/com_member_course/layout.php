<?php
defined("isHOME") or die("Can not acess this page, please come back!");
define("COMS","member_course");
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
require_once("libs/cls.member_course.php");

$task=isset($_GET['task'])?$_GET['task']:'list';

if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){$task='list';}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($obj); unset($task);	unset($ids);
?>