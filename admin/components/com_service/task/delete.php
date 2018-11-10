<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$id=isset($_GET['id'])?(int)$_GET['id']:0;
$obj->Delete($id);
echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
?>