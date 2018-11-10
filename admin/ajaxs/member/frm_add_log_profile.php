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

$mc_id=isset($_POST['mc_id'])?(int)$_POST['mc_id']:0;

$sql="SELECT * FROM tbl_log_profile WHERE member_course_id=".$mc_id;
$objmysql->Query($sql);
$total_rows = $objmysql->Num_rows();
?>
<form id="frm-register0" class="form-horizontal" name="frm-register0">
	<input type="hidden" name="mc_id" value="<?php echo $mc_id;?>">
	<div class="form-group">
		<div class="col-md-5">
			<input type="text" id="txt_name" name="txt_name" class="form-control" value="" placeholder="Tên hồ sơ (*)">
			<small id="er1" class="cred"></small>
		</div>
		<div class="col-md-5">
			<input type="text" id="txt_note" name="txt_note" class="form-control" value="" placeholder="Chú thích">
		</div>
		<button type="button" class="btn btn-primary" id="cmd_save0"><i class="fa fa-floppy-o" aria-hidden="true"></i> Thêm</button>
	</div><br/>
</form>
<div id="list_profile"></div>
<script type="text/javascript">
	$(document).ready(function(){
		getListProfile();
		$('#cmd_save0').click(function(){
			if(check_validate0()==true){
				var data = $('#frm-register0').serializeArray();
				var url='<?php echo ROOTHOST_ADMIN;?>api/process_update_log.php';
				$.post(url,data,function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
					else {
						getListProfile();
					}
				});
			}
		});
	})
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
						getListProfile();
                        }
                    })
			}
			return false;
		}
	}

	function check_validate0(){
		if ($('#frm-register0 input[name="txt_name"]').val() =='') {
			$('#er1').text('Không được bỏ trống');
			return false;
		}else{
			$('#er1').text('');
		}
		return true;
	}
</script>