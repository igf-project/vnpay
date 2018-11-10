<?php
require_once('libs/cls.question_group.php');
require_once('libs/cls.question.php');
$obj = new CLS_QUESTION();
$obj_gquestion = new CLS_QUESTION_GROUP();


$MOD='question';
$obj=new CLS_MODULE;
$obj->getList(' AND `id`='.$r["id"]);
$rows=$obj->Fetch_Assoc();
$theme = 'default';
if($rows['theme']!='') 
	$theme = $rows['theme'];
?>
<div class="module<?php echo " ".$rows['class'];?>">
	<?php if($rows['viewtitle']==1){?>
	<h3 class="title" title="<?php echo $rows['title'];?>"><?php echo $rows['title'];?></h3>
	<?php }
	include(MOD_PATH."mod_$MOD/brow/".$theme.".php");
	?>
</div>
<?php
unset($obj); unset($r);unset($rows);unset($obj_gquestion);
?>