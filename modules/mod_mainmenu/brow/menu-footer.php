<?php
include_once('libs/cls.menuitem.php');
$objmenuitem=new CLS_MENUITEM;

echo '<div class="title-item">'.$rows['title'].'</div>';
echo $objmenuitem->ListMenuFooter($rows['mnu_id'],0,0);

unset($objmenuitem);
?>