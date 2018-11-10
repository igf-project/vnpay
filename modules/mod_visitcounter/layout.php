<?php include("helper.php");
//include_once('cls.counter.php');?>
<div class="module<?php echo " ".$r['class'];?>">
	<?php if($r['viewtitle']==1){?>
	<h3 class="title" title="<?php echo $r['title'];?>"><?php echo $r['title'];?></h3>
    <?php }?>
	<?php
		$this->show_visitecount();
	?>
</div>
<?php
unset($obj); unset($r);
?>