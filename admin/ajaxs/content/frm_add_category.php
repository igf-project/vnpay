<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.category.php");
$objuser=new CLS_USER;
$objCate=new CLS_CATEGORY;
if(!$objuser->isLogin()){
	die("E01");
}
$gid = isset($_POST['cate_id'])?(int)$_POST['cate_id']:0;
?>
<form id="frm-register" name="frm-register" method="" action="" enctype="multipart/form-data">
	<input type="hidden" class="form-control" id="txt_id" value="<?php echo $gid;?>">
	<div class="row">
		<div class="col-md-6">
			<label>Tên nhóm*</label>
			<div class="form-group">
				<input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
				<div id="txt_name_err" class="mes-error"></div>
			</div>
		</div>
		<div class="col-md-6">
			<label>Nhóm cha</label>
			<div class="form-group">
				<select name="cbo_cate" class="form-control" id="cbo_cate" style="width: 100%;">
					<option value="0" title="Top">Root</option>
					<?php $objCate->getListCate(0,0); ?>
				</select>
				<script type="text/javascript">
					$(document).ready(function() {
						$("#cbo_cate").select2();
					});
				</script>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-6">
			<label>Ảnh đại diện*</label>
			<div class='form-group'>
				<div class="row">
					<div class="col-sm-9">
						<input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="" placeholder='' />
					</div>
					<div class="col-sm-3">
						<a class="btn btn-success" href="#" onclick="OpenPopup('extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="form-group col-sm-12">
			<label class="form-control-label"> Mô tả ngắn</label>
			<textarea name="txtintro" id="txtintro" cols="45" rows="5"></textarea>
			<script language="javascript">
				var oEdit1=new InnovaEditor("oEdit1");
				oEdit1.width="";
				oEdit1.height="300";
				oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST_ADMIN;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
				oEdit1.REPLACE("txtintro");
			</script>
		</div>
	</div>
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