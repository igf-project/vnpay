<?php
$MOD='news';
$obj=new CLS_MODULE;
$obj->getList(' AND `id`='.$r["id"]);
$rows=$obj->Fetch_Assoc();
$theme = 'default';
// var_dump($rows['theme']);
if($rows['theme']!='') 
	$theme = $rows['theme'];
?>
<div class="module<?php echo " ".$rows['class'];?>">
	<?php if($rows['viewtitle']==1){?>
	<h3 class="title"><?php echo $rows['title'];?></h3>
	<?php }
	include(MOD_PATH."mod_$MOD/brow/".$theme.".php");
	?>
</div>
<?php
unset($obj); unset($rows);
?>