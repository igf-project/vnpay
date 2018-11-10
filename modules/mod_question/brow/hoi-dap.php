<?php
include_once('libs/cls.question_group.php');
$obj = new CLS_QUESTION_GROUP();
$obj->getList();

$getCode='';
if(isset($_GET['code'])) $getCode = stripcslashes(strip_tags($_GET['code']));
if($obj->Num_rows()>0){
	echo '<div class="box-title"><a href="'.ROOTHOST.LINK_QUESTION.'" title="'.QUESTION.'">'.QUESTION.'</a></div>';
	echo '<ul class="list-group">';
	while ($row = $obj->Fetch_Assoc()) {
		$name = stripcslashes($row['name']);
		$code = stripcslashes($row['code']);
		$link = ROOTHOST.LINK_QUESTION.'/'.$code;
		if($code == $getCode){
			echo '<li class="list-group-item select"><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" title="'.$name.'">'.$name.'</a></li>';
		}else{
			echo '<li class="list-group-item"><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" title="'.$name.'">'.$name.'</a></li>';
		}
	}
	echo '</ul>';
}
unset($obj);
?>