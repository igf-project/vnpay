<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
include_once('libs/cls.menu.php');
define('COMS','menus');

$check_permission = $UserLogin->Permission(COMS);
if($check_permission==false) die($GLOBALS['MSG_PERMIS']);

$flag=false;
if(!isset($UserLogin)) $UserLogin=new CLS_USERS;
if($UserLogin->isLogin()==true)
    $flag=true;
if($flag==false){
    echo ('<div id="action" style="background-color:#fff"><h4>Bạn không có quyền truy cập. <a href="index.php">Vui lòng quay lại trang chính</a></h4></div>');
    return false;
}

$obj=new CLS_MENU();
$title_manager="Danh sách Menu";
if(isset($_GET['task']) && $_GET['task']=='add')
    $title_manager = "Thêm mới Menu";
if(isset($_GET['task']) && $_GET['task']=='edit')
    $title_manager = "Sửa Menu";

if(isset($_POST['txttask']) && $_POST['txttask']==1){
    $obj->Code=addslashes($_POST['txtcode']);
    $obj->Name=addslashes($_POST['txtname']);
    $sContent=addslashes($_POST['txtdesc']);
    $obj->Desc=addslashes($sContent);
    $obj->isActive=(int)$_POST['optactive'];
    if(isset($_POST['txtid'])){
        $obj->ID=(int)$_POST['txtid'];
        $obj->Update();
    }else{
        $obj->Add_new();
    }
    echo '<script language="javascript">window.location="'.ROOTHOST_ADMIN.COMS.'"</script>';
}


if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
{
    $ids=$_POST['txtids'];
    $ids=str_replace(',',"','",$ids);
    switch ($_POST['txtaction'])
    {
        case 'public': 		$obj->setActive($ids,1); 		break;
        case 'unpublic': 	$obj->setActive($ids,0); 		break;
        case "edit":
        $id=explode("','",$ids);
        echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."/edit/".$id[0]."'</script>";
        exit();
        break;
        case 'delete': 		$obj->Delete($ids); 			break;
    }
    echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
$task='';
if(isset($_GET['task']))
    $task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
    $task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($task);	unset($ids);
unset($obj);	unset($objlag);

?>