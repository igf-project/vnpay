<?php
include_once('libs/cls.menuitem.php');
$objmenuitem=new CLS_MENUITEM;
echo $objmenuitem->ListMenuItem($rows['mnu_id'],0,0);
unset($objmenuitem);
?>