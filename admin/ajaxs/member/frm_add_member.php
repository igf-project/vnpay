<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.members.php");
$objuser=new CLS_USER;
$objmem=new CLS_MEMBERS;
$gid=isset($_GET['id'])?(int)$_GET['id']:0;
if(!$objuser->isLogin()){
	die("E01");
}
?>
<script type="text/javascript" src="<?php echo ROOTHOST_ADMIN;?>js/webcam.js"></script>
<style type="text/css">
	hr{margin-top: 0;margin-bottom: 15px;}
	label.title{font-size: 16px;font-weight: 500;}
	#results,#my_camera {margin: auto;margin-bottom: 10px;}
	#results img {width: 350px;height: 263px;}
</style>
<form id="frm-register" class="form-horizontal"  name="frm-register" method="" action="" enctype="multipart/form-data">
	<input type="hidden" class="form-control" id="txt_gid" value="<?php echo $gid;?>">
	<label class="title">Thông tin cá nhân</label><hr/>
	<div class="col-md-6">
		<div class="form-group">
			<label>Họ tên<small class="cred"> (*)</small></label>
			<input type="text" id="txt_fullname" name="txt_fullname" class="form-control" value="" placeholder="Họ đệm">
			<small id="er1" class="cred"></small>
		</div>
		<div class="form-group">
			<label>CMTND<small class="cred"> (*)</small></label>
			<input type="text" id="txt_cmtnd" name="txt_cmtnd" class="form-control" value="" placeholder="Chứng minh thư nhân dân">
			<small id="er7" class="cred"></small>
		</div>
		<div class="form-group">
			<label>Chọn từ máy tính hoặc chụp ảnh webcam</label>
			<input type="file" id="file-thumb" name="file-thumb" class="fotrm-control" value="">
			<input type="hidden" id='upload_avatar' name="upload_avatar">
			<div id='show-img'></div>
		</div>
	</div>
	<div class="col-md-6">
		<!-- Widget ID (each widget will need unique ID)-->
		<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
			<!-- widget div-->
			<div role="content">
				<!-- widget content -->
				<div class="widget-body no-padding">
					<div id="my_camera" style="float: left;border: 1px solid #CCC;"></div>
					<div id="results" style="clear: both;"></div>
					<!-- A button for taking snaps -->
					<div style="padding: 20px; text-align: center;">
						<button onClick="take_snapshot()" id="take_photo" class="btn btn-primary" type="button">
							<i class="fa fa-camera"></i>
							Chụp ảnh
						</button> 
						<button onClick="showWebcam()" id="show_webcam" class="btn btn-primary" type="button" style="display: none;">
							<i class="fa fa-bullseye"></i>
							Bật webcam
						</button> 
					</div>
					<script language="JavaScript">
						Webcam.set({
							width: 320,
							height: 240,
							image_format: 'jpeg',
							jpeg_quality: 90
						});
						Webcam.attach( '#my_camera' );
					</script>
					<script language="JavaScript">
						function take_snapshot() {
							/*take snapshot and get image data*/
							Webcam.snap( function(data_uri) {
								/*display results in page*/
								document.getElementById('results').innerHTML = 
								'<img src="'+data_uri+'"/>';
								$("#txt_avatar").val(data_uri);
								$("#my_camera").hide();
								$("#take_photo").hide();
								$("#show_webcam").show();
								$("#results").show();
							} );
						}
						function showWebcam() {
							$("#results").hide();
							$("#my_camera").show();
							$("#take_photo").show();
							$("#show_webcam").hide();
						}
					</script>
				</div>
				<!-- end widget content -->
			</div>
			<!-- end widget div -->
		</div>
		<!-- end widget -->								
	</div>
	<div class="clearfix"></div><br>
	<label class="title">Thông tin liên hệ</label><hr/>
	<div class="form-group">
		<div class="col-md-6">
			<label>Phone<small class="cred"> (*)</small></label>
			<input type="number" id="txt_phone" name="txt_phone" class="form-control" value="" placeholder="Số điện thoại">
			<small id="er5" class="cred"></small>
		</div>
		<div class="col-md-6">
			<label>Email<small class="cred"> (*)</small></label>
			<input type="email" id="txt_email" name="txt_email" class="form-control" value="" placeholder="Email">
			<small id="er6" class="cred"></small>
		</div>
	</div>
	<label>Địa chỉ</label>
	<textarea class="form-control" rows="3" id="txt_address" name="txt_address" placeholder="Địa chỉ của bạn"></textarea>
	<br>
	<div class="clearfix"></div><br>
	<input type="hidden" name="img_base64" id="txt_avatar"/>
	<button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
	<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cmd_save').click(function(){
			if(check_validate()==true){
				checkUserRegisExist();
				var data_upcomputer = $('#show-img img').attr('src');
				$('#upload_avatar').val(data_upcomputer);
				var data = $('#frm-register').serializeArray();
				var url='ajaxs/member/process_update_user.php';
				$.post(url,data,function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
					else {
						// console.log(req);
						getUserByGroup();
						showMess('Success!','success');
					}
				});
			}
		});
		/* load thumb when select File*/
		$("input#file-thumb").change(function(e) {
			for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
				var file = e.originalEvent.srcElement.files[i];
				var img = document.createElement("img");
				var reader = new FileReader();
				reader.onloadend = function() {
					img.src = reader.result;
				}
				reader.readAsDataURL(file);
				$('#show-img').addClass('show-img');
				$('#show-img').html(img);
			}
		});
		$('#cmd_cancel').click(function(){
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin người dùng');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			$('#myModalPopup').modal('hide');
		});
	})
	function check_validate(){
		if ($('#txt_fullname').val() =='') {
			$('#er1').text('Không được bỏ trống');
			return false;
		}else{
			$('#er1').text('');
		}
		if ($('#txt_phone').val() =='') {
			$('#er5').text('Không được bỏ trống');
			return false;
		}else{
			$('#er5').text('');
		}
		if ($('#txt_email').val() =='') {
			$('#er6').text('Không được bỏ trống');
			return false;
		}else{
			$('#er6').text('');
		}
		var cmtnd = $('#txt_cmtnd').val().length;
		if (cmtnd<9 || cmtnd>12) {
			$('#er7').text('CMND chỉ cho phép nhập số và có độ dài từ 9 đến 12 số.');
			return false;
		}else{
			$('#er7').text('');
		}
		return true;
	}
	$('#txt_cmtnd').focusout(function(){
		checkUserRegisExist();
	})

	function checkUserRegisExist() {
		var identify = $('#txt_cmtnd').val();
		if(identify) {
			url='ajaxs/member/getUser.php';
			$.post(url,{identify:identify},function($rep){
				var obj = jQuery.parseJSON($rep);		
				if(obj[0]['rep']=='yes') {	
					$('#er7').html('Số chứng minh nhân dân đã tồn tại.');
					return false;
				} else {
					$('#er7').html("");					
					return true;
				}
			})	
		} else {
			$('#er7').html('CMND chỉ cho phép nhập số và có độ dài từ 9 đến 12 số.');
			$('#txt_cmtnd').val("");
			return false;
		}
	}
</script>