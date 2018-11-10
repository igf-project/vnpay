<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
$objuser=new CLS_USER;

if(!$objuser->isLogin()){
	die("E01");
}
?>
<style type="text/css">
	hr{margin-top: 0;margin-bottom: 15px;}
	label.title{font-size: 16px;font-weight: 500;}
</style>
<form id="frm-register" class="form-horizontal"  name="frm-register" method="" action="" enctype="multipart/form-data">
	<label class="title">Thông tin khóa học</label><hr/>
	<div class="form-group">
		<div class="col-md-6">
			<label>Tên bằng lái<small class="cred"> (*)</small></label>
			<input type="text" id="txt_name" name="txt_name" class="form-control" value="" placeholder="Tên bằng">
			<small id="er1" class="cred"></small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<label>Học phí<small class="cred"> (*)</small></label>
			<input type="int" id="txt_price" name="txt_price" class="form-control" value="" placeholder="Học phí">
			<small id="er1" class="cred"></small>
		</div>
	</div>
	<label>Giới thiệu</label>
	<textarea class="form-control" rows="8" id="txt_intro" name="txt_intro" placeholder="giới thiệu"></textarea>
	<div class="clearfix"></div><br>
	<button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
	<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cmd_save').click(function(){
			if(check_validate()==true){
				var data = $('#frm-register').serializeArray();
				var url='ajaxs/course/process_update.php';
				$.post(url,data,function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
					else {
						getUserByGroup();
						showMess('Success!','success');
					}
				});
			}
		});
		$('#cmd_cancel').click(function(){
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin bằng lái');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			$('#myModalPopup').modal('hide');
		});
	})
	function check_validate(){
		if ($('#txt_name').val() =='') {
			$('#er1').text('Không được bỏ trống');
			return false;
		}else{
			$('#er1').text('');
		}
		return true;
	}
</script>