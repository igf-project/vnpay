<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=(int)$_GET["id"];
	$obj->setActive($id);
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
?>