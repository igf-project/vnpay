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
$id=isset($_POST['id'])?(int)$_POST['id']:0;
if(!$objuser->isLogin()) die("E01");

$sql="SELECT mc.*, m.fullname, CONCAT(u.lastname,' ', u.firstname) AS 'name_teacher' FROM tbl_member_course AS mc, tbl_member AS m, tbl_user AS u WHERE mc.user_id= u.id AND mc.mem_id = m.id AND mc.id=$id ";
$objmysql->Query($sql);
if($objmysql->Num_rows()<1) die("E03");
else {
	$rows = $objmysql->Fetch_Assoc();
}
?>
<style type="text/css">
	hr{
		margin-top: 0;
		margin-bottom: 15px;
	}
	label.title{font-size: 16px;font-weight: 500;}
</style>

<form id="frm-register" class="form-horizontal"  name="frm-register" method="" action="" enctype="multipart/form-data">
	<input type="hidden" name="txt_id" value="<?php echo $rows['id'] ?>" />
	<div class="form-group">
		<div class="col-md-6">
			<label>Giáo viên:<small class="cred"> (*)</small></label>
			<input type="hidden" name="cbo_teacher" value="<?php echo $rows['user_id'];?>">
			<input type="text" name="txt_teacher" value="<?php echo $rows['name_teacher'];?>" class="form-control" readonly>
			<small id="er1" class="cred"></small>
		</div>
		<div class="col-md-6">
			<label>Học viên:</label>
			<input type="hidden" id="cbo_mem" name="cbo_mem" value="<?php echo $rows['mem_id'];?>" class="form-control" readonly>
			<input type="text" name="txt_member" value="<?php echo $rows['fullname'];?>" class="form-control" readonly>
			<small id="er1" class="cred"></small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<label>Khóa học:</label>
			<div>
				<select id="cbo_course" name="cbo_course" style="width: 100%;" class="sl2 form-control">
					<option value="0">-- Chọn 1 khóa học --</option>
					<?php
					$sql="SELECT * FROM tbl_course WHERE isactive=1";
					$objmysql->Query($sql);
					while ($row = $objmysql->Fetch_Assoc()) {
						echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
					}
					?>
					<script type="text/javascript">
						cbo_Selected('cbo_course','<?php echo $rows['course_id'];?>');
						$(document).ready(function() {
							$("#cbo_course").select2();
						});
					</script>
				</select>
			</div>
			<small id="er2" class="cred"></small>
		</div>
	</div>
	<div class="clearfix"></div><br>
	<input type="hidden" name="cmd_update_user"/>
	<button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
	<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cmd_save').click(function(){
			if(check_validate()==true){
				var data = $('#frm-register').serializeArray();
				var url='<?php echo ROOTHOST_ADMIN;?>api/process_update_member_course.php';
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
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			$('#myModalPopup').modal('hide');
		});
	})
	function check_validate(){
		if ($('#cbo_mem').val() =='') {
			$('#er1').text('Không được bỏ trống');
			return false;
		}else{
			$('#er1').text('');
		}
		if ($('#cbo_course').val() =='') {
			$('#er2').text('Không được bỏ trống');
			return false;
		}else{
			$('#er2').text('');
		}
		return true;
	}
</script>