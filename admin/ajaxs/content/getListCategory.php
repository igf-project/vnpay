<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.category.php");

$objCategory = new CLS_CATEGORY;
$objmysql = new CLS_MYSQL();
$objCategory->getListCategory();

unset($objCategory);unset($objUser);unset($objmysql);
?>