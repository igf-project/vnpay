<?php
$MOD='service';
$obj = new CLS_MODULE;
$obj->getList(' AND `id`='.$r["id"]);
$row_mod = $obj->Fetch_Assoc();

$theme = 'brow1';
if($row_mod['theme']!='') 
	$theme=$row_mod['theme'];
?>
<div class="module<?php echo " ".$row_mod['class'];?>">
	<?php if($row_mod['viewtitle']==1){?>
	<h3 class="title"><a href='#' title="<?php echo $row_mod['title'];?>"><?php echo $row_mod['title'];?></a></h3>
	<?php 
}

include(MOD_PATH."mod_$MOD/brow/".$theme.'.php'); ?>
</div>
<?php unset($obj); unset($row_mod);?>