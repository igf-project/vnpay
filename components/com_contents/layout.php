<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define('COMS', 'contents');
define('TITLE', 'Tin tức');
    $com=isset($_GET['com'])? $_GET['com']:'';
    $viewtype=isset($_GET['viewtype'])? addslashes($_GET['viewtype']):'list';
    $arr=array('list', 'block', 'seach', 'detail','related_content');
    if($com!=COMS OR in_array($viewtype, $arr)==false OR !is_file(COM_PATH.'com_'.$com.'/tem/'.$viewtype.'.php')){ //Check
        die('PAGE NOT FOUND!');
    }
    include_once('libs/cls.contents.php');
    include_once('libs/cls.category.php');
    $obj_cate = new CLS_CATEGORY();
    $obj=new CLS_CONTENTS();
    include_once('tem/'.$viewtype.'.php');

    unset($viewtype); unset($com); unset($arr);unset($obj);unset($obj_cate);
?>

