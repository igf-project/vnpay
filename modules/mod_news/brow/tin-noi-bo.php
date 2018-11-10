<?php
require_once('libs/cls.contents.php');
require_once('libs/cls.category.php');
if(!isset($objCon)) $objCon = new CLS_CONTENTS();
if(!isset($objCate)) $objCate = new CLS_CATEGORY();


$cate_id = isset($r['cate_id']) && $r['cate_id']!='' ? (int)$r['cate_id']:0;
$info_cate = $objCate->getInfo(" AND cate_id=".$cate_id);
$linkCate = ROOTHOST.LINK_NEWS.'/'.$info_cate['code'].'-'.$info_cate['cate_id'];
$objCon->getList(" AND cate_id = $cate_id ORDER BY cdate DESC ",' LIMIT 0,5');

if($objCon->Num_rows()>0){
	echo '
	<div class="col-sm-6 item">
		<div class="title-item"><a href="'.$linkCate.'" title="'.$info_cate['name'].'">'.$info_cate['name'].'</a></div>
		<ul class="list-news">';
			while($item_r = $objCon->Fetch_Assoc()){
				$title = stripslashes($item_r['title']);
				$code = stripslashes($item_r['code']);
				$link = ROOTHOST.LINK_NEWS.'/'.$code.'.html';
				echo '<li><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
			}
			echo '
		</ul>
		<div class="bottom"><a href="'.$linkCate.'" class="view-more">'.VIEW_MORE.'...</a></div>
	</div>';
} // endwhile
unset($objCon); unset($objCate);
?>


