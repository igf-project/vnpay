<div class="container">
	<div class="title-box"><?php echo $r['title'] ?></div>
	<div class="content">
		<div id="slide-member" class="swiper-container">
			<div class="swiper-wrapper">
				<?php
				$objmysql = new CLS_MYSQL();
				$sql="SELECT * FROM tbl_partner WHERE isactive=1 ORDER BY `order` ASC ";
				$objmysql->Query($sql);
				while ($row = $objmysql->Fetch_Assoc()) {
					$title = stripcslashes($row['title']);
					$link = stripcslashes($row['link']);
					$thumb = stripcslashes($row['thumb']);
					echo '
					<div class="swiper-slide">
						<a href="'.$link.'" target="_blank" title="'.$title.'">
							<img src="'.$thumb.'" class="img-responsive">
						</a>
					</div>';
				}
				?>
			</div>
			<div id="swiper-button-next1" class="swiper-button-next"></div>
			<div id="swiper-button-prev1" class="swiper-button-prev"></div>
		</div>
	</div>
</div>