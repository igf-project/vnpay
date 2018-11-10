<?php 
$MOD='html';
$obj=new CLS_MODULE;
$obj->getList('AND `id`='.$r["id"]);
$rows=$obj->Fetch_Assoc();
$theme = 'default';
if($rows['theme']!='') 
	$theme = $rows['theme'];
?>
<div class="module module-html<?php echo " ".$rows['class'];?>">
	<?php if($rows['viewtitle']==1){?>
	<h3 class="title"><?php echo R_title;?></h3>
	<?php }
	echo stripslashes($rows['content']);
	?>
</div>
<?php
unset($obj); unset($rows);
?>