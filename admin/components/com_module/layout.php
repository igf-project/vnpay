<?php
	defined('ISHOME') or die("Can't acess this page, please come back!");
	define('COMS','module');
	
	$check_permission = $UserLogin->Permission(COMS);
	if($check_permission==false) die($GLOBALS['MSG_PERMIS']);

	// Begin Toolbar
	include_once('libs/cls.module.php');
	include_once('libs/cls.menu.php');
	include_once('libs/cls.category.php');
	include_once('libs/cls.catalogs.php');
	include_once('libs/cls.menuitem.php');
	
	$obj=new CLS_MODULE();
	$objmenu=new CLS_MENU();
	$objCate=new CLS_CATEGORY();
	$objCata=new CLS_CATALOGS();
	
	// End toolbar
	if(isset($_POST['cmdsave'])){
		$obj->Title=addslashes($_POST['txttitle']);
		$obj->Type=addslashes($_POST['cbo_type']);
		$obj->ViewTitle=(int)$_POST['optviewtitle'];
		if(isset($_POST['cbo_menutype'])) 			$obj->MnuID=(int)$_POST['cbo_menutype'];
		if(isset($_POST['cbo_theme'])) 				$obj->Theme=addslashes($_POST['cbo_theme']);
		if(isset($_POST['cbo_cate'])) 				$obj->Cate_ID=(int)$_POST['cbo_cate'];
		if(isset($_POST['cbo_cate_service'])) 		$obj->Cate_Service_ID=(int)$_POST['cbo_cate_service'];
		if(isset($_POST['cbo_cate_intro'])) 		$obj->Cate_Intro_ID=(int)$_POST['cbo_cate_intro'];
		if(isset($_POST['cbo_cate_guide'])) 		$obj->Cate_Guide_ID=(int)$_POST['cbo_cate_guide'];
		if(isset($_POST['txtcontent'])) 			$obj->HTML=addslashes($_POST['txtcontent']);
		$obj->Position=addslashes($_POST['cbo_position']);
		$obj->Class=addslashes($_POST['txtclass']);
		$obj->isActive=(int)$_POST['optactive'];
		
		if(isset($_POST['txtid'])){
			$obj->ID=(int)$_POST['txtid'];
			$obj->Update();
		}else{
			$obj->Add_new();
		}
		?>
		<script language="javascript">window.location='<?php echo ROOTHOST_ADMIN.COMS;?>'</script>
		<?php
	}
	if(isset($_POST['txtaction']) && $_POST['txtaction']!=''){
		$ids=$_POST['txtids'];
		$ids=str_replace(',',"','",$ids);
		switch ($_POST['txtaction']){
			case 'public': 		$obj->setActive($ids,1); 		break;
			case 'unpublic': 	$obj->setActive($ids,0); 		break;
			case 'order':
				$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
				$obj->Order($ids,$sls);	break;
			case "delete": 		$obj->Delete($ids); 			break;
		}
		?>
		<script language="javascript">window.location='<?php echo ROOTHOST_ADMIN.COMS;?>'</script>
		<?php
	}
	define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
	$task='';
	if(isset($_GET['task']))
		$task=$_GET['task'];
	if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
		$task='list';
	}
	include_once(THIS_COM_PATH.'task/'.$task.'.php');
	unset($task);	unset($ids);	unset($obj);	unset($objlag);
?>