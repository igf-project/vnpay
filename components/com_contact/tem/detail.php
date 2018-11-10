<?php
$content_code='';
if(isset($_GET['code'])){
	$code=addslashes($_GET['code']);
}
else die("PAGE NOT FOUND");
?>

	<div class="container">
		<div class="page-content detail-content">
		<?php
		//var_dump($content_code);
		$strWhere='WHERE `tbl_contents`.`code`="'.$code.'"';
		$obj->getList($strWhere);
		$row=$obj->Fetch_Assoc();
		$intro=strip_tags(Substring($row['intro'], 0, 100));
		$fulltext=html_entity_decode($row['fulltext']);
		?>
            <div class='path'>Trang chủ » <a href="<?php echo ROOTHOST."tin-tuc/";?>">Tin tức</a> » <a class="active" href="#"><?php echo $row['title'];?></a></div>
            <div class="row">
                <div class="col-md-8 column-item ">
                    <div class="box-item">
                        <h3 class="">
                            <?php echo $row['title'];?>
                        </h3>
                        <p class="intro">
                            <?php echo $intro;?>
                        </p>
                        <div class="fulltext">
                            <?php echo $fulltext;?>
                        </div>
                        <div class="author">
                            Tác giả: <?php echo $row['author'];?>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 column-item col-right">

                </div>
            </div>
        </div>
    </div>
 <?php
 unset($objPoCon);
 ?>