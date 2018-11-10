<?php
$MOD='mainmenu';
$obj=new CLS_MODULE;
$obj->getList(' AND `id`='.$r["id"]);
$rows=$obj->Fetch_Assoc();
$theme = 'brow1';
if($rows['theme']!='') 
	$theme=$rows['theme'];

?>
<div class="item module<?php echo " ".$rows['class'];?>">
	<?php if($rows['viewtitle']==1){?>
	<h3 class="title"><?php echo $rows['title'];?></h3>
	<?php }
	include(MOD_PATH."mod_$MOD/brow/".$theme.".php");
	?>
</div>
<?php unset($obj); unset($rows);?>