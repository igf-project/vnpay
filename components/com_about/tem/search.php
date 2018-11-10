<?php
require_once(libs_path."gfclass/cls.simple_image.php");
if(!isset($clsimage)) $clsimage = new SimpleImage();

if(!isset($_SESSION["CUR_PAGE_MNU"]))
	$_SESSION["CUR_PAGE_MNU"]=1;
if(isset($_POST["cur_page"])){
	$_SESSION["CUR_PAGE_MNU"]=(int)$_POST["cur_page"];
}
$cur_page=$_SESSION["CUR_PAGE_MNU"];
if(isset($_POST["txtCurnpage"]))
		$cur_page=$_POST["txtCurnpage"];
//echo $cata;
$total_rows="";
$title="";
$ketqua=false;

if(isset($_POST["txtsearch"]))
   $title= addslashes(trim($_POST["txtsearch"]));

if(!isset($objsearch)) $objsearch=new CLS_CONTENTS();
     
// KET QUA TIM KIEM TU KHOA THEO BAI VIET

if($title!='') 
	$objsearch->getAllList(" AND `title` LIKE \"%".addslashes($title)."%\" OR `intro` LIKE \"%".addslashes($title)."%\" AND `isactive`='1'");
else 
	$objsearch->getAllList(" AND `isactive`='1'");
//echo $title;
if($objsearch->Numrows()>0){
   $ketqua=true;
   $total_rows=$objsearch->Numrows();
  if($title!='') 
  	$objsearch->getListpage(" WHERE `title` LIKE \"%".$title."%\" OR `intro` LIKE \"%".addslashes($title)."%\" AND `isactive`='1'",$cur_page);
  else 
  	$objsearch->getListpage(" WHERE `isactive`='1'",$cur_page);
  echo '<h3 class="related"> CÁC BÀI VIẾT CÓ LIÊN QUAN ĐẾN TỪ KHÓA: <span style="color:red">"'.$title.'"</span></h3>';
	$i=1;
	while($rows=$objsearch->FetchArray())
	{
		$title = stripslashes($rows["title"]);
		$intro = stripslashes($rows["intro"]);
		$fulltext = stripslashes($rows["fulltext"]);
		$link = 'index.php?com=contents&viewtype=article&item='.$rows["con_id"];
    	$img='';
		$img = $rows["thumb_img"];
		$width = "100%"; 
		if($img!='') {
			$img ='<img class="img_block" align="left"  src="'.$img.'"/>';
		}
?>
        <div class="news_block clearfix <?php if($i==2) echo 'intro_right';?>">
            <?php if($img!='') echo '<a href="'.$link.'" title="'.$title.'">'.$img.'</a>'; ?>
            <a class="news_title" href="<?php echo $link;?>" style="width:<?php echo $width;?>" title="<?php echo $title;?>">		
               <h4> <?php echo $title;?>	</h4>
            </a>       
            <?php echo $intro; ?>
            <div style="float:right; pading-right:21px; color:#647F9F; margin-top: 0px;" class="readmore">		
        <a style="text-decoration: none; color:#647F9F;" class="btn_detail" href="index.php?com=contents&viewtype=article&item=<?php echo $rows["con_id"]; ?>">Đọc thêm</a>	
    </div>	
        </div>
<?php 
	if($i==2) echo '<div class="course_space">&nbsp;</div>';
	if($i==1) $i=2; else $i=1;
	} //end while
}  // end if
?>

<?php

if($ketqua==false) echo '<h3 style="border-bottom:1px solid #ccc; padding:5px 0"> KHÔNG TÌM THẤY NỘI DUNG CÓ LIÊN QUAN ĐẾN TỪ KHÓA: <span style="color:red">"'.$title.'"</span></h3>';

unset($objdata);
unset($objsearch);
?>

<div id="paging_index" class="clearfix">
<?php 
	paging_index($total_rows,MAX_ROWS_INDEX,$cur_page);
?>
</div>