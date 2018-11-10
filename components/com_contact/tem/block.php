<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$code='';
if(isset($_GET["code"])) 
	$code = addslashes($_GET["code"]);
if(!isset($_SESSION["CUR_PAGE_CON"]))
	$_SESSION["CUR_PAGE_CON"]=1;
if(isset($_POST["txtCurnpage"])){	
	$_SESSION["CUR_PAGE_CON"]=$_POST["txtCurnpage"];
}
$cur_page=$_SESSION["CUR_PAGE_CON"];
if(!isset($objcat)) $objcat = new CLS_CATE;
$objcat->getList(" AND alias='$code' ");
$row_cat=$objcat->Fetch_Assoc();
$catename= $objcat->getNameById($row_cat['cat_id']);
$id = $row_cat['cat_id']."','".$objcat->getCatIDChild('',$row_cat['cat_id']);
unset($objcat);
?>
<div class="content_body">
	<h2 class='title'><a><?php echo $catename;?></a></h2>
<?php
$where=" AND `cat_id` in ('$id') ";
$obj->getList($where);
$total_rows=$obj->Num_rows();
$max_rows=MAX_ITEM;
$cur_page=1;
if(isset($_POST['txtCurnpage'])){$cur_page=$_POST['txtCurnpage'];}
$start=($cur_page-1)*$max_rows;
if($total_rows>0){
$start_r=($cur_page-1)*MAX_ITEM;
	$obj->getList($where,' ORDER BY `order` ASC,con_id DESC'," LIMIT $start_r,$max_rows");
?>
<ul class='cnt'>
<?php
while($rows=$obj->Fetch_Assoc()){
	$title = stripslashes($rows["title"]);
?>
<li class='clearfix'><h3 class='title'><a href='<?php echo ROOTHOST.$rows['code'].'.html';?>'><?php echo $title;?></a></h3>
	<a href='<?php echo ROOTHOST.$rows['code'].'.html';?>' class='read_more'>Chi tiết</a>
</li>
<?php }?>
</ul>
<?php paging_index($total_rows,$max_rows,$cur_page);?>
<?php 
} else { echo '<div>Hệ thống đang cập nhật. Vui lòng quay lại mục này sau.</div>';}?>
</div>