<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.member_course.php");
$objmysql=new CLS_MYSQL;
$objuser = new CLS_USER;
$objmembercourse=new CLS_MEMBER_COURSE;
$mc_id=isset($_POST['mc_id'])?(int)$_POST['mc_id']:0;
if(!$objuser->isLogin()) die("E01");

$sql="SELECT mc.*, m.fullname, CONCAT(u.lastname,' ', u.firstname) AS 'name_teacher' FROM tbl_member_course AS mc, tbl_member AS m, tbl_user AS u WHERE mc.user_id= u.id AND mc.mem_id = m.id AND mc.id=$mc_id ";
$objmysql->Query($sql);
if($objmysql->Num_rows()<1) die("E03");
else {
	$rows = $objmysql->Fetch_Assoc();
}
?>
<style type="text/css">
	hr{margin-top: 0;margin-bottom: 15px;}
	label.title{font-size: 16px;font-weight: 500;}
</style>
<div class="row dis-flex">
	<fieldset class="form-group col-md-6">
		<legend class="title">Thông tin hồ sơ</legend>
		<div id="list_profile"></div>
	</fieldset>
	<fieldset class="form-group col-md-6">
		<legend class="title">Thông tin học phí</legend>
		<div id="list_fee"></div>
	</fieldset>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
	$(document).ready(function(){
		getListFee();
		getListProfile();
		$('#cmd_cancel').click(function(){
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			$('#myModalPopup').modal('hide');
		});
	})
	function getListFee(){
		var mc_id = '<?php echo $mc_id;?>';
		var url="<?php echo ROOTHOST_ADMIN;?>ajaxs/member/show_fee.php";
		$.post(url,{mc_id},function(req){
			$('#list_fee').html(req);
		})
	}
	function getListProfile(){
		var mc_id = '<?php echo $mc_id;?>';
		var url="<?php echo ROOTHOST_ADMIN;?>ajaxs/member/show_profile.php";
		$.post(url,{mc_id},function(req){
			$('#list_profile').html(req);
		})
	}
	function del_profile($this_user){
		if(confirm("Bạn có chắc muốn xóa?")){
			var _id = $($this_user).attr('dataid');
			if(_id=='' || _id==0) showMess('Chọn một hồ sơ để xóa','');
			else{
				var url='<?php echo ROOTHOST_ADMIN;?>api/process_del_log_profile.php'; 
				$.post(url,{'id':_id},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
					else{
						console.log(req);
						getListProfile();
					}
				})
			}
			return false;
		}
	}
	function del_fee($this_user){
		if(confirm("Bạn có chắc muốn xóa?")){
			var _id = $($this_user).attr('dataid');
			if(_id=='' || _id==0) showMess('Chọn một học phí để xóa','');
			else{
				var url='<?php echo ROOTHOST_ADMIN;?>api/process_del_log_fee.php'; 
				$.post(url,{'id':_id,'fee':1},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
					else{
						getListFee();
					}
				})
			}
			return false;
		}
	}
</script>