<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define('COMS', 'document');
define('TITLE', 'Tài liệu');
    $com=isset($_GET['com'])? $_GET['com']:'';
    $viewtype=isset($_GET['viewtype'])? addslashes($_GET['viewtype']):'list';
    $arr=array('list', 'block', 'seach', 'detail','related_content');
    if($com!=COMS OR in_array($viewtype, $arr)==false OR !is_file(COM_PATH.'com_'.$com.'/tem/'.$viewtype.'.php')){ //Check
        die('PAGE NOT FOUND!');
    }
    include_once('libs/cls.document_type.php');
    include_once('libs/cls.document.php');
    $obj_cate = new CLS_DOCUMENT_TYPE();
    $obj=new CLS_DOCUMENT();
    include_once('tem/'.$viewtype.'.php');

    unset($viewtype); unset($com); unset($arr);unset($obj);unset($obj_cate);
?>

