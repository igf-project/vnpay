<?php
$sql="SELECT * FROM view_content WHERE isactive=1 AND `code`='gioi-thieu'";
$objmysql = new CLS_MYSQL();
$objmysql->Query($sql);
if($objmysql->Num_rows()>0){
	$row = $objmysql->Fetch_Assoc();
	$intro = stripslashes($row['intro']);
	$fulltext = stripcslashes($row['fulltext']);
	$thumb = getThumb($row['thumb'],'img-responsive thumb',$row['title']);
	?>
	<div class="row">
		<div class="col-sm-8">
			<?php
			echo '<h1 class="title-info-us"><a href="'.ROOTHOST.$row["code"].'.html" title="'.$row['title'].'">Về chúng tôi</a></h1><br/>';
			echo '<div class="fulltext">'.$intro.'</div>';
			?>
			<div id="about-us" class="collapse fulltext">
				<?php echo $fulltext;?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="col-sm-4 m-hide">
			<a href="#"><?php echo $thumb;?></a>
		</div>
		<span id="readmore-about-us" class="readmore" data-toggle="collapse" data-target="#about-us">Xem thêm  <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
	</div>
	<?php 
} ?>
<script type="text/javascript">
	$('#readmore-about-us').click(function(){
		$(this).html($(this).text()=="Rút gọn" ?'Xem thêm':'Rút gọn');
	})
</script>