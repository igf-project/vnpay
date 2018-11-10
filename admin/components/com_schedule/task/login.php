<?php
$err='';
if(isset($_POST['submit'])){
	$user=addslashes($_POST['txtuser']);
	$pass=addslashes($_POST['txtpass']);
	// $serc=addslashes($_POST['txt_sercurity']);
	// if($_SESSION['SERCURITY_CODE']!=$serc)
	// 	$err='<font color="red">Mã bảo mật không chính xác</font>';
	// else{
		global $UserLogin;
		if($UserLogin->LOGIN($user,$pass)==true)
			echo '<script language="javascript">window.location.href="index.php"</script>';
		else
			$err='<font color="red">Đăng nhập không thành công.</font>';
	// }
}
?>
<div class="well well-sm">
	<img class="login" style="width: 140px;" src="http://hoangtucoc.com/smartoffice/images/logo.png" alt="Logo">
</div>
<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form id="frm_login" class="login_form well radi0" name="frm_login" method="post" action="" AUTOCOMPLETE="off" >
				<div class="header-login">
					<h3>Đăng nhập hệ thống</h3><hr/>
				</div>
				<div class="body-login">
					<p style="color: red"><?php echo $err;?></p>
					<div class="form-group">
						<label for="txtuser">Tên đăng nhập</label>
						<input type="text" class="form-control" name="txtuser" id="txtuser"  placeholder="Tên đăng nhập">
					</div>
					<div class="form-group">
						<label for="txtpass">Password</label>
						<input type="password" class="form-control" name="txtpass" id="txtpass" placeholder="Nhập mật khẩu">
						<div class="note" style="margin-top: 5px;">
							<a href="forgotpassword.html">Quên mật khẩu?</a>
						</div>
					</div>
					<div class="form-group">
						<label class="checkbox-inline">
							<input type="checkbox" name="remember" checked>
							<i></i>Giữ đăng nhập
						</label>
					</div>
					<!-- <div class="form-group">
						<label for="">Mã bảo mật</label>
						<div class="row">
							<div class="col-md-4">
								<input  type="text" size="7" name="txt_sercurity" id="txt_sercurity" class="form-control"/>
							</div>
							<div class="col-md-6">
								<img src="../extensions/captcha/CaptchaSecurityImages.php?width=90&height=32" align="left" alt="" />
							</div>
						</div>
					</div> -->
				</div>
				<div class="footer-login">
					<input type="submit" name="submit" id="submit" value="Đăng nhập" class="btn btn-primary btn-block">
				</div>
			</form>
		</div>
	</div>
</div>