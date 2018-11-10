<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define('COMS', 'partner');
define('TITLE', 'Sản phẩm dịch vụ');
    $com=isset($_GET['com'])? $_GET['com']:'';
    $viewtype=isset($_GET['viewtype'])? addslashes($_GET['viewtype']):'list';
    $arr=array('list', 'block', 'seach', 'detail','related_content');
    if($com!=COMS OR in_array($viewtype, $arr)==false OR !is_file(COM_PATH.'com_'.$com.'/tem/'.$viewtype.'.php')){ //Check
        die('PAGE NOT FOUND!');
    }
    include_once('libs/cls.cate_partner.php');
    include_once('libs/cls.partner.php');
    $obj_cate = new CLS_CATE_PARTNER();
    $obj = new CLS_SERVICE();
    include_once('tem/'.$viewtype.'.php');

    unset($viewtype); unset($com); unset($arr);unset($obj);
?>

