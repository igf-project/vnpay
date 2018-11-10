<?php
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
session_start();
define("ISHOME",true);
if(!isset($_SESSION['LANGUAGE'])){
	$_SESSION['LANGUAGE']='0';
}

require_once("global/libs/gfinit.php");
require_once("global/libs/gfconfig.php");
require_once("global/libs/gffunc.php");


if(isset($_POST['txtlang'])){
	$_SESSION['LANGUAGE']=(int)$_POST['txtlang'];
	echo "<script language=\"javascript\">window.location='".ROOTHOST."'</script>";
}
if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']==1) include_once('languages/en/default.php');
else include_once('languages/vi/default.php');


// include libs
require_once('libs/cls.mysql.php');
require_once('libs/cls.template.php');
require_once('libs/cls.menuitem.php');
require_once('libs/cls.contents.php');
require_once('libs/cls.category.php');
require_once('libs/cls.cate_intro.php');
require_once('libs/cls.introduct.php');
require_once('libs/cls.cate_service.php');
require_once('libs/cls.service.php');
require_once('libs/cls.cate_partner.php');
require_once('libs/cls.partner.php');
require_once('libs/cls.document_type.php');
require_once('libs/cls.document.php');
require_once('libs/cls.question_group.php');
require_once('libs/cls.question.php');
require_once('libs/cls.cate_guide.php');
require_once('libs/cls.guide.php');
require_once('libs/cls.cate_recruitment.php');
require_once('libs/cls.recruitment.php');
require_once('libs/cls.module.php');
require_once('libs/cls.configsite.php');

$tmp = new CLS_TEMPLATE();
$conf = new CLS_CONFIG();
$conf->load_config();
?>
<!DOCTYPE html>
<html language='vi'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow" />
	<meta property="og:url" content="<?php echo $thisurl;?>" />
	<meta property="og:type" content="website" />
	<meta property="og:author" content='IGF JSC' />
	<meta property="og:locale" content='vi_VN'/>
	<meta property="og:title" content="<?php echo $conf->Title;?>"/>
	<meta property="og:keywords" content='<?php echo $conf->Meta_key;?>' />
	<meta property='og:description' content='<?php echo $conf->Meta_desc;?>' />
	<meta property="og:image" content="<?php echo $conf->Img;?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/igf_logo.ico">
	<link rel="apple-touch-icon" href="images/igf_logo.ico">
	<link rel="apple-touch-icon" sizes="72x72" href="images/igf_logo.ico">
	<link rel="apple-touch-icon" sizes="114x114" href="images/igf_logo.ico">
	<title>VNPAY</title>
	<link rel="shortcut icon" href="<?php echo ROOTHOST;?>global/img/igf_logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/bootstrap.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/font-awesome.min.css" type="text/css" media="all" >
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>css/swiper.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>css/style.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>css/style.responsive.min.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
</head>
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.9";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<body>		
	<div id="wapper">
		<div id="site_header">
			<div class="top-header">
				<div class='container'>
					<a href="<?php echo ROOTHOST;?>" class="pull-left">
						<?php $tmp->loadModule('user1') ?>
					</a>
					<div class="pull-right">
						<ul class="list-inline">
							<li class="hotline"><span>Hotline </span><b>1900 5555 77</b></li>
							<li class="multi_language">
								<form method="POST" id="frm_lang">
									<select id="txtlang" name="txtlang">
										<option value="0" <?php if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']==0) echo 'selected';?>><?php echo VIETNAMESE ?></option>
										<option value="1" <?php if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']==1) echo 'selected';?>><?php echo ENGLISH ?></option>
									</select>
								</form>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="header">
				<nav class="navbar" data-spy="affix" data-offset-top="197">
					<div class="main-menu">
						<div class="container nav-top">
							<div class="navbar-header">
								<a href="<?php echo ROOTHOST;?>"><img class="logo_mobile" src="<?php echo ROOTHOST;?>images/root/logo.png"></a>
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse-mainmenu">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<div class="collapse navbar-collapse" id="collapse-mainmenu">
								<?php $tmp->loadModule('navitor'); ?>
								<div class="box-search">
									<img src="<?php echo ROOTHOST;?>images/root/icon_search.png" class="icon_search_tablet">
									<form id="frm_search_home" class="form-search" name="frm-search" method="get" action="<?php echo ROOTHOST.LINK_SEARCH;?>">
										<input type="hidden" name="q" value="">
										<input type="text" id="txt_keywork" name="" placeholder="<?php echo QUICK_SEARCH ?>">
									</form>
								</div>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<div id="site_body">
			<div class="body_body">
				<?php if($tmp->isFrontpage()) { ?>
				<?php $tmp->loadModule('banner'); ?>
				<div class="container">
					<?php $tmp->loadModule('top'); ?>
					<div class="clearfix"></div>
					<?php $tmp->loadModule('box3'); ?>
				</div>
				<div class="box-news">
					<div class="container">
						<div class="content">
							<div class="row">
								<?php $tmp->loadModule('box1'); ?>
								<?php $tmp->loadModule('box2'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="box-member">
					<?php $tmp->loadModule('box4'); ?>
				</div>
				<?php }else{ ?>
				<div class="clearfix"></div>
				<div class="component">
					<?php $tmp->loadComponent();?>
				</div>
				<?php } ?>
			</div>
		</div>
		<footer id="site_footer">
			<div class="container">
				<div class="list_item_footer">
					<?php $tmp->loadModule('footer') ?>
				</div>
				<div class="clearfix"></div>
				<div class="box-fanpage-fb" style="text-align: right;">
					<div class="fb-page" data-href="https://www.facebook.com/CongthanhtoanVNPAY/" data-tabs="timeline" data-height="230px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/CongthanhtoanVNPAY/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/CongthanhtoanVNPAY/">Cổng thanh toán VNPAY</a></blockquote></div>
				</div>
			</div>
		</footer>
		<div class="footer-bottom">
			<div class="container">
				<div style="font-size: 16px; color: #667782;"><?php echo COPYRIGHT ?></div>
			</div>
		</div>
	</div>
</body>
</html>
<script src="<?php echo ROOTHOST;?>global/js/jquery-1.11.2.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/js/bootstrap.min.js"></script>
<script src="<?php echo ROOTHOST_ADMIN;?>js/script.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/js/swiper.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#txtlang').change(function(){
			$('#frm_lang').submit();
		})

		$('.main-menu .bulet-dropdown').click(function(){
			$(this).parent().find('.dropdown-menu').toggle();
			$(this).parent().toggleClass('nav-pos');
		})

		$('#form_search_help').submit(function(){
			var val = $(this).find($('#ip_search_help')).val();
			$(this).find($('input[name="q"]')).val(val);
		})

		$('#frm_search_home').submit(function(){
			var val = $(this).find($('#txt_keywork')).val();
			$(this).find($('input[name="q"]')).val(val);
		})

		$('.icon_search_tablet').click(function(){
			$('#frm_search_home').slideToggle();
		})
	})


	var elem_main = document.getElementById('slider-main');
	var swiper = new Swiper(elem_main, {
		pagination: '#slider-main .swiper-pagination',
		nextButton: '#slider-main .swiper-button-next',
		prevButton: '#slider-main .swiper-button-prev',
		paginationClickable: true,
		spaceBetween: 0,
		centeredSlides: true,
		speed: 600,
		autoplay: 4000,
		loop: true,
		autoplayDisableOnInteraction: false
	});
</script>
<script>
	var swiper = new Swiper('#slide-member', {
		pagination: '#slide-member .swiper-pagination',
		nextButton: '#slide-member .swiper-button-next',
		prevButton: '#slide-member .swiper-button-prev',
		paginationClickable: true,
		slidesPerView: 5,
		spaceBetween: 10,
		breakpoints: {
			1024: {
				slidesPerView: 4,
				spaceBetween: 40
			},
			768: {
				slidesPerView: 3,
				spaceBetween: 30
			},
			640: {
				slidesPerView: 2,
				spaceBetween: 20
			},
			320: {
				slidesPerView: 1,
				spaceBetween: 10
			}
		}
	});
</script>