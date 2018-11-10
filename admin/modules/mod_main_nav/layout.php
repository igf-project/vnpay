<a href="<?php echo ROOTHOST_ADMIN;?>" class="navbar-brand"><img src="<?php echo ROOTHOST_ADMIN;?>images/logo.png" class="img-responsive"/></a>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<button type="button" data-toggle="collapse" data-target="left_sidebar" aria-expanded="false" aria-controls="navbar" id="main-sidebar" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>

		<button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
	</div>
	<div id="navbar" class="navbar-collapse collapse" menu="">
		<div class="pull-right user_module" style="padding-top:8px; padding-right:10px;">
			<div class="btn-group form-profile bright">

				<?php
				if(isset($_SESSION['LANGUAGE_ADMIN']) && $_SESSION['LANGUAGE_ADMIN']==1){
					echo '<span id="txt_language">Tiếng Anh </span>';
					echo '<a href="#" id="language_vi" data="0"><img src="'.ROOTHOST.'images/flag-vi.png"/></a>';
					echo '<a href="#" id="language_en" data="1" class="active"><img src="'.ROOTHOST.'images/flag-en.png"/></a>';
				}else{
					echo '<span id="txt_language">Tiếng Việt </span>';
					echo '<a href="#" id="language_vi" data="0" class="active"><img src="'.ROOTHOST.'images/flag-vi.png"/></a>';
					echo '<a href="#" id="language_en" data="1" style="opacity:0.3"><img src="'.ROOTHOST.'images/flag-en.png"/></a>';
				}
				?>
			</div>
			<?php if($UserLogin->Permission('mail')==true){ ?>
			<div class="btn-group form-profile bright">
				<div class="mailbox">
					<a href="<?php echo ROOTHOST_ADMIN;?>mail"><i class="fa fa-envelope" aria-hidden="true"></i> Hòm thư </a>
				</div>
				<ul class="dropdown-menu pull-right">
					<li><a href="<?php echo ROOTHOST_ADMIN;?>profile"><i class="fa fa-info-circle"></i> Thông tin tài khoản</a></li>
					<li><a href="<?php echo ROOTHOST_ADMIN;?>logout" rel="nofollow,noindex"><i class="fa fa-power-off"></i> Đăng xuất</a></li>
				</ul>
			</div>
			<?php } ?>
			<div class="btn-group form-profile ">
				<div class="action dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<a href="#" id="nav_registry" ><span class='avatar-small'><i class="fa fa-user fa-2" aria-hidden="true"></i></span> <?php echo $UserLogin->getInfo('lastname').' '.$UserLogin->getInfo('firstname');?> </a><i class="fa fa-caret-down" aria-hidden="true"></i>
				</div>
				<ul class="dropdown-menu pull-right">
					<li><a href="<?php echo ROOTHOST_ADMIN;?>profile"><i class="fa fa-info-circle"></i> Thông tin tài khoản</a></li>
					<li><a href="<?php echo ROOTHOST_ADMIN;?>logout" rel="nofollow,noindex"><i class="fa fa-power-off"></i> Đăng xuất</a></li>
				</ul>
			</div>
		</div>
	</div>
</nav>
