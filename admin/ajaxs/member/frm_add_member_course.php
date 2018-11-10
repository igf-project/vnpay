<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
$objmysql=new CLS_MYSQL;
$objuser=new CLS_USER;
$author_id = $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'];
$author = $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['lastname'].' '.$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['firstname'];
if(!$objuser->isLogin()){
	die("E01");
}
$mem_id = isset($_POST['mem_id']) ? (int)$_POST['mem_id']:0;
?>
<style type="text/css">
	hr{margin-top: 0;margin-bottom: 15px;}
	label.title{font-size: 16px;font-weight: 500;}
	.sl2{width: 80%;}
</style>
<form id="frm-register" class="form-horizontal"  name="frm-register" method="" action="" enctype="multipart/form-data">
	<label class="title">Thông tin học viên & khóa học</label><hr/>
	<div class="form-group">
		<div class="col-md-6">
			<label>Giáo viên:<small class="cred"> (*)</small></label>
			<input type="hidden" name="cbo_teacher" value="<?php echo $author_id;?>">
			<input type="text" name="txt_teacher" value="<?php echo $author;?>" class="form-control" readonly>
		</div>
		<div class="col-md-6">
			<?php
			$sql="SELECT `fullname`,`id` FROM tbl_member WHERE id=$mem_id";
			$objmysql->Query($sql);
			$row_m = $objmysql->Fetch_Assoc();
			?>
			<label>Học viên:</label>
			<input type="hidden" id="cbo_mem" name="cbo_mem" value="<?php echo $row_m['id'];?>">
			<input type="text" name="txt_member" value="<?php echo $row_m['fullname'];?>" class="form-control" readonly>
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
						$(document).ready(function() {
							$("#cbo_course").select2();
						});
					</script>
				</select>
			</div>
			<small id="er2" class="cred"></small>
		</div>
	</div>
</div>
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
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin bằng lái');
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