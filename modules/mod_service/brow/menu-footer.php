<?php
include_once('libs/cls.cate_service.php');
include_once('libs/cls.service.php');
$objCateService = new CLS_CATE_SERVICE();
$obj = new CLS_SERVICE();
?>
<div class="box-service">
	<div class="title-box">Sản phẩm & Dịch vụ</div>
	<div class="content">
		<div class="row">
			<?php
			$obj->getList(" ORDER BY cdate DESC "," LIMIT 0,4 ");
			while ($rows = $obj->Fetch_Assoc()) {
				$id = $rows['id'];
				$title = stripslashes($rows['title']);
				$code = stripslashes($rows['code']);
				$intro = strip_tags($rows['intro']);
				$thumb = stripslashes($rows['thumb']);
				$link = ROOTHOST.'san-pham-dich-vu/'.$code.'.html';
				echo '
				<div class="col-sm-6">
					<div class="item">
						<a href="'.$link.'">
							<img src="'.$thumb.'" class="img-responsive">
						</a>
						<div class="col-info">
							<div class="intro">'.$intro.'</div>
							<a href="'.$link.'" title="'.$title.'" class="title">'.$title.'</a>
							<a href="'.$link.'" title="'.$title.'" class="btn-view">Xem thêm</a>
						</div>
					</div>
				</div>';
			}
			?>
		</div>
	</div>
	<div class="bottom">
		<div class="title"><span>Xem tất cả các dịch vụ</span></div>
		<div style="margin-top:10px;text-align: center;"><span><a href="<?php echo ROOTHOST;?>san-pham-dich-vu" style="display: inline-block;"><img src="<?php echo ROOTHOST;?>images/root/icon_bt_service.png" class="img-responsive"></a></span>
		</div>
	</div>
</div>
<?php
unset($obj);
unset($objCateService);
?>