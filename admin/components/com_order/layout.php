<?php
defined("isHOME") or die("Can not acess this page, please come back!");
define("COMS","order");
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
// Begin Toolbar

// End toolbar
if(isset($_POST["cmdsave"])){
	$obj->Title		=addslashes($_POST["txttitle"]);
	$obj->Code		=un_unicode($_POST["txttitle"]);
	$obj->CatID		=(int)$_POST["cbo_cate"];
	$obj->Mnu_ID	=$_SESSION['MENUS'];
	$obj->Intro		=addslashes($_POST["txtintro"]);
	$obj->Fulltext	=addslashes($_POST['txtdesc']);
	if(isset($_POST["txtthumb"]))
		$obj->ThumbIMG=addslashes($_POST["txtthumb"]);
	
	if(isset($_POST["txtmodify"])){
	$txtjoindate	=trim($_POST["txtcreadate"]);
	$joindate 		=mktime(0,0,0,substr($txtjoindate,3,2),substr($txtjoindate,0,2),substr($txtjoindate,6,4));
	$obj->CDate = date("Y-m-d",$joindate);
	}
	
	if(isset($_POST["txtmodify"])) {
		$txtjoindate2=trim($_POST["txtmodify"]);
		$joindate2 = mktime(0,0,0,substr($txtjoindate2,3,2),substr($txtjoindate2,0,2),substr($txtjoindate2,6,4));
		$obj->MDate = date("Y-m-d",$joindate2);
	}
	$obj->Author	=addslashes($_POST["txtauthor"]);
	$obj->Meta_title	=addslashes($_POST["txtmetatitle"]);
	$obj->Meta_key	=addslashes($_POST["txtmetakey"]);
	$obj->Meta_desc	=addslashes($_POST["textmetadesc"]);
	$obj->GmID		=addslashes($_POST["cbo_groupmem"]);
	$obj->IsActive	=(int)$_POST["optactive"];
	if(isset($_POST["txtid"])){
		$obj->ID	=(int)$_POST["txtid"];
		$obj->Update();
	}else{
		$obj->Add_new();
	}
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
}
if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=$_POST["txtids"];
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 		$obj->setActive($ids,1); 		break;
		case "unpublic": 	$obj->setActive($ids,0); 		break;
		case "edit": 	
			$id=explode("','",$ids);
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&id=".$id[0]."'</script>";
			exit();
			break;
		case 'order':
			$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
			$obj->Orders($ids,$sls); 	break;	
		case "delete": 		$obj->Delete($ids); 		break;
	}
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
}

$task=isset($_GET['task'])?$_GET['task']:'list';
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){$task='list';}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($obj); unset($task);	unset($ids);
?>