<?php
session_start();
define("isHOME",true);
date_default_timezone_set("Asia/Ho_Chi_Minh");
$month=date('m');
$year=date('Y');
require_once("../../global/libs/gfinit.php");
require_once("../../global/libs/gfconfig.php");
require_once("../../global/libs/gffunc.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.user.php");
require_once("../libs/cls.course.php");
require_once("../libs/cls.member_course.php");
$UserLogin = new CLS_USER();
$objmysql = new CLS_MYSQL();
$objmemcourse = new CLS_MEMBER_COURSE();
$user_id =$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'];
$date = test_input($_POST['date']);
$day = strtotime($date);
?>
<form id="frm-addschedule">
	<input type="hidden" name="teacher_id" value="<?php echo $user_id;?>">
	<?php
	$sql="SELECT tbl_schedule_task.id as 'schedule_id', tbl_schedule_task.* FROM tbl_schedule_task 
	LEFT JOIN tbl_member_course ON `tbl_schedule_task`.member_course_id IN (tbl_member_course.id) 
	WHERE tbl_member_course.user_id=$user_id AND isday=$day 
	ORDER BY from_hour ASC";
	$objmysql->Query($sql); $i=0;
	echo '<table class="table table-bordered">
			<thead>
				<tr>
					<th width="30">#</th>
					<th>Nội dung</th>
					<th>Học viên</th>
					<th>Thời gian</th>
					<th></th>
				</tr>
			</thead>
			<tbody>';
	while ($row=$objmysql->Fetch_Assoc()) {
		$i++;
		$day = date('d-m-Y',$row['isday']);
		$from_hour = date('H:i',$row['from_hour']);
		$to_hour = date('H:i',$row['to_hour']);
		$mem_cour_id = substr($row['member_course_id'],0,strlen($row['member_course_id'])-1);
		$member = $objmemcourse->getmemberbymemcourseID($mem_cour_id);
		echo '<tr class="trow">
					<td width="center">'.$i.'</td>
					<td>'.$row['note'].'</td>
					<td>'.$member.'</td>
					<td><input type="text" class="txt_from_hour" value="'.$from_hour.'"> đến <input type="text" class="txt_to_hour" value="'.$to_hour.'"> </td>
					<td><span class="cmd_delSchedule" dataid="'.$row['schedule_id'].'" onclick="cmd_delSchedule(this)"><i class="fa fa-times cred" aria-hidden="true"></i></span></td>
				</tr>';
	}
	echo '</tbody></table>';
	?>
	<div class="text-right">
		<button type='button' id="cmd_addSchedule" class='btn btn-primary'>Thêm lịch</button>
		<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
	</div>
</form>
<script type="text/javascript">
	$(function () {
		$('.txt_from_hour').datetimepicker({
			format: 'LT'
		});
		$('.txt_to_hour').datetimepicker({
			format: 'LT'
		});
		$('#myModalPopup').on('hidden', function () {
			window.location.reload(true);
		})
	});
	var weekday=new Array(7);
	weekday[0]="T2";
	weekday[1]="T3";
	weekday[2]="T4";
	weekday[3]="T5";
	weekday[4]="T6";
	weekday[5]="T7";
	weekday[6]="CN";
	
	function viewSchedule(){
		var url="ajaxs/viewSchedule.php";
		var date = '<?php echo $date;?>';
		var strdate = new Date(date);
		strdate = weekday[strdate.getDay()-1] + ' ' + strdate.getDate() + "-" + (strdate.getMonth()+1) + "-" + strdate.getFullYear();
			
		$.post(url,{'date':date},function(req){
			$('#myModalPopup .modal-dialog').removeClass('modal-sm');
			$('#myModalPopup .modal-title').html('Lịch giảng dạy ('+strdate+')');
			$('#myModalPopup .modal-body').html(req);
			$('#myModalPopup').modal('show');
		})
	}
	function cmd_delSchedule($this){
		if(confirm("Bạn có chắc muốn xóa?")){
			var url="api/process_del_schedule.php";
			var id = $($this).attr('dataid');
			$.post(url,{'id':id},function(req){
				viewSchedule();
			})
		}
	}
	$(document).ready(function(){
		$('#cmd_save').click(function(){
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
		$('#cmd_addSchedule').click(function(){
			var url="ajaxs/frm_addSchedule.php";
			var date = "<?php echo $date; ?>";
			var strdate = new Date(date);
			strdate = strdate.getDate() + "-" + (strdate.getMonth()+1) + "-" + strdate.getFullYear();
			$.post(url,{'date':date},function(req){
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-title').html('Thêm lịch giảng dạy ('+strdate+')');
				$('#myModalPopup .modal-body').html(req);
				$('#myModalPopup').modal('show');
				$('#txt_note').focus();
			})
		})
		$('#cmd_cancel').click(function(){
			$('#myModalPopup .modal-header .modal-title').html('');
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