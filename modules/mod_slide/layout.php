<div class="slide-banner">
	<div id="slide-main">
		<div id="slider-main" class="slider-main swiper-container">
			<div class="swiper-wrapper">
				<?php
				$objmysql = new CLS_MYSQL();
				$sql="SELECT * FROM tbl_slider WHERE isactive=1 ORDER BY `order` ASC ";
				$objmysql->Query($sql);
				while ($row = $objmysql->Fetch_Assoc()) {
					$title = stripcslashes($row['slogan']);
					$intro = stripcslashes($row['intro']);
					$link = stripcslashes($row['link']);
					$thumb = stripcslashes($row['thumb']);
					echo '
					<div class="swiper-slide">
						<div class="container">
							<div class="content">
								<h1>'.$title.'</h1>
								<p class="intro">'.$intro.'</p>
								<a href="'.$link.'" class="btn btn-view" title="'.VIEW_MORE.'">'.VIEW_MORE.'</a>
							</div>
						</div>
						<img src="'.$thumb.'" class="img-responsive" alt=""/>
					</div>';
				}
				?>

			</div>
			<div class="swiper-pagination show-mobile"></div>
		</div>
	</div>
</div>