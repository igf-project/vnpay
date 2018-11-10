<?php
include_once('global/libs/gfinit.php');
include_once('global/libs/gfconfig.php');
include_once('libs/cls.mysql.php');
include_once('libs/cls.document.php');
$objDocument = new CLS_DOCUMENT();

if(isset($_GET['code'])){
    $getcode = addslashes(strip_tags($_GET['code']));
    $objDocument->updateView($getcode);
    $strWhere=' AND `code`="'.$getcode.'"';
}
$objDocument->getList($strWhere);
$row=$objDocument->Fetch_Assoc();
$url = str_replace(ROOTHOST,'',$row['fullurl']);

$file=$url;

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="the.pdf"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
@readfile($file);
?>