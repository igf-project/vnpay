<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='0';
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];
	$obj->setActive($id);
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
?>