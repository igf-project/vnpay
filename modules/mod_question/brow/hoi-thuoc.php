<?php
$gquestion_id='';
if(isset($r['question_group'])) $gquestion_id = (int)$r['question_group'];
if($gquestion_id!=''){
	$glink = ROOTHOST.'question/'.un_unicode($r['title']).'-'.$r['question_group'];
	$obj->getList(" AND gquestion_id= $gquestion_id ORDER BY cdate DESC LIMIT 0,4");
	if($obj->Num_rows()>0){
		echo '<h3 class="mod_title_question"><a href="'.$glink.'" title="'.$r['title'].'">'.$r['title'].'</a><span class="view_all"><a href="'.$glink.'" title="'.$r['title'].'">Xem thêm<i class="fa fa-caret-right fa_user" aria-hidden="true"></i></a></span></h3>';
		echo '<ul class="list-question">';
		while ($row = $obj->Fetch_Assoc()) {
			$name = stripslashes($row['fullname']);
			$title = stripslashes($row['title']);
			$txt_question = Substring(strip_tags(stripslashes($row['text_question'])),0,30);
			echo '<li><span class="name">'.$name.'</span><span>'.$title.'</span><p><span>'.$txt_question.'</span></p><div class="txt_answer"><b>Trả lời: </b><span>'.$txt_question.'</span></div></li>';
		?>
		<?php
		}
		echo '</ul>';
	}
}
?>