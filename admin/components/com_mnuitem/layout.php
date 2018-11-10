<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$flag=false;
if(!isset($UserLogin)) $UserLogin=new CLS_USERS;
if($UserLogin->isLogin()==true)
	$flag=true;
if($flag==false){
	echo ('<div id="action" style="background-color:#fff"><h4>Bạn không có quyền truy cập. <a href="index.php">Vui lòng quay lại trang chính</a></h4></div>');
	return false;
}
define('COMS','mnuitem');
	// Begin Toolbar
require_once('libs/cls.menuitem.php');
require_once('libs/cls.category.php');
require_once('libs/cls.contents.php');
require_once('libs/cls.catalogs.php');
require_once('libs/cls.menu.php');
$obj_cata = new CLS_CATALOGS();
$obj_cate = new CLS_CATEGORY();
$obj_con = new CLS_CONTENTS();
$obj_mnu=new CLS_MENU();


$title_manager = 'Quản lý danh sách Menu';
if(isset($_GET['task']) && $_GET['task']=='add')
	$title_manager = 'Thêm mới Menu';
if(isset($_GET['task']) && $_GET['task']=='edit')
	$title_manager = 'Sửa Menu';


if(!isset($_SESSION['ids'])){
	$_SESSION['ids']="";
}
	//------------------------------------------------
if(!isset($_SESSION['mnuid'])){
	$_SESSION['mnuid']='';
}
$mnuid='';
if(isset($_GET['mnuid']) && $_GET['mnuid']!='') {
	$_SESSION['mnuid']=(int)$_GET['mnuid'];
}
if($_GET['com']=='menus' && isset($_GET['id'])==true){
	$_SESSION['mnuid']=(int)$_GET['id'];
}
if(isset($_POST['cbo_menutype'])){
	$mnuid=(int)$_POST['cbo_menutype'];
	$_SESSION['mnuid']=$mnuid;
}
$mnuid=$_SESSION['mnuid'];
	//----------------------------------------------
$obj=new CLS_MENUITEM();
if(isset($_POST['cmdsave'])){
	$obj->Par_ID=(int)$_POST['cbo_parid'];
	$level = $obj->getLevelChild($obj->Par_ID);
	$obj->Name=addslashes($_POST['txtname']);
	$obj->Code=addslashes(un_unicode($_POST['txtname']));
	$obj->Intro=addslashes($_POST['txtdesc']);
	$obj->Mnu_ID=(int)$mnuid; 
	$obj->Viewtype=addslashes($_POST['cbo_viewtype']);

	if($obj->Viewtype=='block'){
		$obj->Cate_ID=(int)$_POST['cbo_cate'];
	}
	else if($obj->Viewtype=='article'){		
		$obj->Con_ID=(int)$_POST['cbo_article'];
	}

	else if($obj->Viewtype=='cate_service'){		
		$obj->Cate_service=(int)$_POST['cbo_cate_service'];
	}
	else if($obj->Viewtype=='service'){		
		$obj->Service=(int)$_POST['cbo_service'];
	}

	else if($obj->Viewtype=='cate_intro'){		
		$obj->Cate_intro=(int)$_POST['cbo_cate_intro'];
	}
	else if($obj->Viewtype=='introduct'){		
		$obj->Introduct=(int)$_POST['cbo_introduct'];
	}

	else if($obj->Viewtype=='cate_partner'){		
		$obj->Cate_partner=(int)$_POST['cbo_cate_partner'];
	}
	else if($obj->Viewtype=='partner'){		
		$obj->Partner=(int)$_POST['cbo_partner'];
	}

	else if($obj->Viewtype=='document_type'){		
		$obj->Gdoc_ID=(int)$_POST['cbo_document_type'];
	}
	else if($obj->Viewtype=='document'){		
		$obj->Document=(int)$_POST['cbo_document'];
	}

	else if($obj->Viewtype=='question_group'){		
		$obj->Question_group=(int)$_POST['cbo_question_group'];
	}
	else if($obj->Viewtype=='question'){		
		$obj->Question=(int)$_POST['cbo_question'];
	}

	else if($obj->Viewtype=='cate_guide'){		
		$obj->Cate_guide=(int)$_POST['cbo_cate_guide'];
	}
	else if($obj->Viewtype=='guide'){		
		$obj->Guide=(int)$_POST['cbo_guide'];
	}

	else if($obj->Viewtype=='cate_recruitment'){		
		$obj->Cate_recruitment=(int)$_POST['cbo_cate_recruitment'];
	}
	else if($obj->Viewtype=='recruitment'){		
		$obj->Recruitment=(int)$_POST['cbo_recruitment'];
	}

	else{
		$obj->Link=addslashes($_POST['txtlink']);
	}
	
	$obj->Class=addslashes($_POST['txtclass']);
	$obj->isActive=(int)$_POST['optactive'];
	if(isset($_POST['txtid'])){
		$obj->ID=(int)$_POST['txtid'];
		$obj->Update();
	}else{
		$obj->Add_new();
	}
	echo '<script language="javascript">window.location="'.ROOTHOST_ADMIN.COMS.'/'.$mnuid.'"</script>';
}
if(isset($_POST['txtaction']) && $_POST['txtaction']!='')
{
	$ids=$_POST['txtids'];
	$ids=str_replace(',',"','",$ids);
	switch ($_POST['txtaction'])
	{
		case 'public': 		$obj->setActive($ids,1); 		break;
		case 'unpublic': 	$obj->setActive($ids,0); 		break;
		case 'edit': 	
		$id=explode("','",$ids);
		echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."/edit/".$id[0]."'</script>";
		break;
		case 'order':
		$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
		$obj->Order($ids,$sls); 	break;
		case 'delete': 		$obj->Delete($ids); 		break;
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS.'/'.$mnuid."'</script>";
}

define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
$task='';
if(isset($_GET['task']))
	$task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($task); unset($ids); unset($obj); unset($objlang);
?>