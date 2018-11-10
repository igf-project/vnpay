<?php
require_once('libs/cls.cate_guide.php');
require_once('libs/cls.guide.php');
$objCateGuide = new CLS_CATEGORY_GUIDE();
$obj = new CLS_GUIDE();

$getcode='';
if(isset($_GET['code'])){
	$getcode = addslashes(strip_tags($_GET['code']));
}

$ID = isset($r['cate_guide_id']) ? (int)$r['cate_guide_id'] : 0;
$info = $objCateGuide->getInfo(" AND cate_id =".$ID);
$nameCate = $info['name'];
$linkCate = ROOTHOST.'tro-giup/'.$info['code'];

echo '
<div class="box-title"><a href="'.$linkCate.'" title="'.$nameCate.'">'.$nameCate.'</a></div>
<ul class="list-group">';
	$objCateGuide->getList(" AND par_id =".$ID." ORDER BY `order` ASC ");
	while ($row = $objCateGuide->Fetch_Assoc()) {
		$ids = (int)$row['cate_id'];
		$title = stripcslashes($row['name']);
		$code = stripcslashes($row['code']);
		$link = ROOTHOST.'tro-giup/'.$code;
		if($code==$getcode){
			echo '<li class="list-group-item select"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
		}else{
			echo '<li class="list-group-item"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
		}
	}
	echo '</ul>';
	?>