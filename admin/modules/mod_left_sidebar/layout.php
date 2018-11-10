<?php
if($UserLogin->isLogin()) {
	$PERMISSION = $UserLogin->getInfo('isroot');
}?>
<div id="left_sidebar">
	<div class="sidebar_top"></div>
	<div class="sidebar_body">
		<?php if($UserLogin->Permission('intro')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>intro" title="Giới thiệu"><i class="fa fa-info-circle" aria-hidden="true"></i> <span>Giới thiệu</span></a>
		<?php } if($UserLogin->Permission('contents')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>contents" title="Tin tức"><i class="fa fa-newspaper-o"></i> <span>Tin tức</span></a>
		<?php } if($UserLogin->Permission('recruitment')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>recruitment" title="Tuyển dụng"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Tuyển dụng</span></a>
		<?php } if($UserLogin->Permission('service')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>service" title="Sản phẩm - dịch vụ" class="dark"><i class="fa fa-cloud-download" aria-hidden="true"></i> <span>Sản phẩm - Dịch vụ</span></a>
		<?php } if($UserLogin->Permission('partner')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>partner" title="Đối tác" class="dark"><i class="fa fa-users" aria-hidden="true"></i> <span>Đối tác</span></a>
		<?php } if($UserLogin->Permission('guide')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>guide" title="Hướng dẫn"><i class="fa fa-info" aria-hidden="true"></i> <span>Trợ giúp</span></a>
		<?php } if($UserLogin->Permission('question')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>question" title="Hỏi đáp"><i class="fa fa-question-circle" aria-hidden="true"></i> <span>Hỏi đáp</span></a>
		<?php } if($UserLogin->Permission('document')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>document" title="Tài liệu"><i class="fa fa-book" aria-hidden="true"></i> <span>Tài liệu</span></a>
		<?php } if($UserLogin->Permission('config')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>config" title="Cấu hình" class="dark"><i class="fa fa-cog" aria-hidden="true"></i> <span>Cấu hình</span></a>
		<?php } if($UserLogin->Permission('user')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>user" title="Quản lý người dùng" class="dark"><i class="fa fa-user" aria-hidden="true"></i> <span>Quản lý người dùng</span></a>
		<?php } if($UserLogin->Permission('menus')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>menus" title="Menu" class="dark"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Menu</span></a>
		<?php } if($UserLogin->Permission('module')==true){ ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>module" title="Module" class="dark"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Chức năng</span></a>
		<?php } ?>
		<a href="<?php echo ROOTHOST_ADMIN;?>slider" title="Slider">
			<i class="fa fa-desktop" aria-hidden="true"></i> <span>Slider </span>
		</a>
	</div>
</div>