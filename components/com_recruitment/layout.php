<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define('COMS', 'recruitment');
define('TITLE', 'Tuyển dụng');
    $com=isset($_GET['com'])? $_GET['com']:'';
    $viewtype=isset($_GET['viewtype'])? addslashes($_GET['viewtype']):'list';
    $arr=array('list', 'block', 'seach', 'detail','related_content');
    if($com!=COMS OR in_array($viewtype, $arr)==false OR !is_file(COM_PATH.'com_'.$com.'/tem/'.$viewtype.'.php')){ //Check
        die('PAGE NOT FOUND!');
    }
    include_once('libs/cls.cate_recruitment.php');
    include_once('libs/cls.recruitment.php');
    $obj_cate = new CLS_CATEGORY_RECRUITMENT();
    $obj = new CLS_RECRUITMENT();
    include_once('tem/'.$viewtype.'.php');

    unset($viewtype); unset($com); unset($arr);unset($obj);
?>

