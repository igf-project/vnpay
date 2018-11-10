<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
$objuser=new CLS_USER;
$objmysql = new CLS_MYSQL;
if(!$objuser->isLogin()) die("E01");
$mc_id= (int)$_POST['mc_id'];
$sql="SELECT * FROM tbl_log_fee WHERE member_course_id=".$mc_id;
$objmysql->Query($sql);
$total_rows = $objmysql->Num_rows();
?>
<form id="frm-register1" class="form-horizontal" name="frm-register1" method="" action="">
	<input type="hidden" name="frm_fee">
	<input type="hidden" name="mc_id" value="<?php echo $mc_id;?>">
	<div class="form-group">
		<div class="col-md-5">
			<input type="number" id="txt_name" name="txt_name" min="0" class="form-control" value="" placeholder="Học phí (*)">
			<small id="er1" class="cred"></small>
		</div>
		<div class="col-md-5">
			<input type="text" id="txt_note1" name="txt_note" class="form-control" placeholder="Chú thích"></textarea>
		</div>
		<button type="button" class="btn btn-primary" id="cmd_save1"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
	</div><br/>
</form>
<div id="list_fee"></div>
<script type="text/javascript">
	$(document).ready(function(){
		getListFee();
		$('#cmd_save1').click(function(){
			if(check_validate1()==true){
				var data = $('#frm-register1').serializeArray();
				var url='<?php echo ROOTHOST_ADMIN;?>api/process_update_log.php';
				$.post(url,data,function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
					else {
						getListFee();
					}
				});
			}
		});
	})
	function getListFee(){
		var mc_id = '<?php echo $mc_id;?>';
		var url="<?php echo ROOTHOST_ADMIN;?>ajaxs/member/show_fee.php";
		$.post(url,{mc_id},function(req){
			$('#list_fee').html(req);
		})
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
	function check_validate1(){
		if ($('#frm-register1 input[name="txt_name"]').val() =='') {
			$('#er1').text('Không được bỏ trống');
			return false;
		}else{
			$('#er1').text('');
		}
		return true;
	}
</script>