<?php
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
$month=date('m');
$year=date('Y');
define("isHOME",true);
require_once("../../global/libs/gfinit.php");
require_once("../../global/libs/gfconfig.php");
require_once("../../global/libs/gffunc.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.user.php");
require_once("../libs/cls.schedule.php");
$objuser = new CLS_USER();
$objSchedule = new CLS_SCHEDULE();

if(!$objuser->isLogin()) die("E01");
$date = test_input($_POST['date']);
$day = date('d-m-Y',strtotime($date));
$userid = $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'];
?>

<form id="frm-addschedule">
	<input type="hidden" name="cbo_teacher" value="<?php echo $userid;?>">
	<input type="hidden" name="txt_day" value="<?php echo $day;?>">
	<div class="form-group">
		<input type="text" class="form-control" id="txt_note" name="txt_note" placeholder='Ví dụ: thực hành tiết 1'>
		<small id="er1" class="cred"></small>
	</div>
	<div class="form-group">
		<label for="pwd">Thời gian:</label>
		Ngày: <?php echo $day;?> : <input type='text' id="txt_from_hour" name="txt_from_hour"> to <input type='text' id='txt_to_hour' name="txt_to_hour"> 
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label for="pwd">Học viên:</label>
				<input type="hidden" id="list_member_id" name="list_member_id">
				<select id='cbo_member' multiple name="cbo_member[]">
					<?php
					$sql="SELECT m.id,fullname from tbl_member as m inner join tbl_member_course as mc on mc.mem_id=m.id where mc.user_id=$userid";
					$objmysql = new CLS_MYSQL();
					$objmysql->Query($sql);
					while ($row_mem = $objmysql->Fetch_Assoc()) {
						echo '<option value="'.$row_mem['id'].'">'.$row_mem['fullname'].'</option>';
					}
					?>
				</select>
				<script language="javascript">
					$(document).ready(function() {
						$('#cbo_member').multiselect({
							nonSelectedText:'Học viên'
						});
					});
				</script>
			</div>
		</div>
	</div>
	<hr/>
	<div class='text-right'>
		<button type='button' id="cmd_save" class='btn btn-primary'>Save</button>
		<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
	</div>
</form>
<script type="text/javascript">
	$(function () {
		$('#txt_from_hour').datetimepicker({
			format: 'LT'
		});
		$('#txt_to_hour').datetimepicker({
			format: 'LT'
		});
		$('#myModalPopup').on('hidden', function () {
			window.location.reload(true);
		})
	});
	$(document).ready(function(){
		$('#cmd_save').click(function(){
			var ar_member=[];
			$('#cbo_member :selected').each(function(i,selected){
				ar_member[i]=$(selected).val();
			})
			$('#list_member_id').val(ar_member.toString());
			if(check_validate()==true){
				var data = $('#frm-addschedule').serializeArray();
				var url = 'api/process_update_schedule.php';
				$.post(url,data,function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
					else {
						getCalendar(<?php echo $month;?>,<?php echo $year;?>);
						showMess('Success!','success');
					}
				})
			}
		})
		$('#cmd_cancel').click(function(){
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin bằng lái');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			$('#myModalPopup').modal('hide');
		});
	})
	function check_validate(){
		if ($('#frm-addschedule #txt_note').val() =='') {
			$('#er1').text('Không được bỏ trống');
			return false;
		}else{
			$('#er1').text('');
		}
		return true;
	}
</script>