<?php
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
require_once("../../global/libs/gfinit.php");
require_once("../../global/libs/gfconfig.php");
require_once("../../global/libs/gffunc.php");
require_once("../libs/cls.mysql.php");
require_once("../libs/cls.user.php");
require_once("../libs/cls.schedule.php");
$objmysql = new CLS_MYSQL();
$UserLogin = new CLS_USER();
$objSchedule = new CLS_SCHEDULE();

$format='Y-m-d';
$month=isset($_POST['month'])? (int)$_POST['month']:date('m');
$year=isset($_POST['year'])? (int)$_POST['year']:date('Y');
function number_day_of_month($month,$year){
	$arr31=array(1,3,5,7,8,10,12);
	if($month==2){
		if(date('L', strtotime($year.'-01-01'))) return 29;
		else return 28;
	}elseif(in_array($month,$arr31)) return 31;
	else return 30;
}

$first_this_day = date('w',strtotime("$year-$month-01"));
$number_day_this_month=number_day_of_month($month,$year);
$pre_month=$month-1; $pre_year=$year;
if($pre_month==0){
	$pre_month=12; $pre_year=$year-1;
}
$number_day_pri_month=number_day_of_month($pre_month,$pre_year);

// get member_course ID by user_id
$user_id = $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'];
$sql="SELECT id FROM tbl_member_course WHERE user_id = $user_id";
$objmysql->Query($sql);
$list_memcourse_id='';
while ($row_memcourse=$objmysql->Fetch_Assoc()) {
	$list_memcourse_id.=$row_memcourse['id'].',';
}
$list_memcourse_id = substr($list_memcourse_id,0,strlen($list_memcourse_id)-1);


// Get day tbl_schedule_task
$day_arr=array();
$sql="SELECT isday FROM tbl_schedule_task WHERE member_course_id IN($list_memcourse_id)";
$objmysql->Query($sql);
while ($row_schedule=$objmysql->Fetch_Assoc()) {
	$day_arr[]=$row_schedule['isday'];
}


$stt=0;$thisday=0;$nex_day=0;
for($i=0;$i<6;$i++){
	echo "<tr>";
	for($j=0;$j<7;$j++){
		$stt++;
		if($stt<=$first_this_day){
			$pre_day=$number_day_pri_month-$first_this_day+$stt;
			echo "<td class='disable'>$pre_day</td>";
		}
		if($stt>$first_this_day){
			$thisday++;
			if($thisday<=$number_day_this_month){
				$format="$year-$month-$thisday";
				$strtotime_format = strtotime($format);
				
				$class='cell';
				if(in_array($strtotime_format,$day_arr)){
					$class='action';
				}
				if($thisday==date('d') && $month==date('m') && $year==date('Y')){
					echo "<td class='curent $class' dataid='$format'>$thisday</td>";
				}else{
					echo "<td class='$class' dataid='$format'>$thisday</td>";
				}
			}else{
				$nex_day++;
				echo "<td class='disable'>$nex_day</td>";
			}
		}
	}
	echo "</tr>";
}
?>
<script>
	$(document).ready(function(){
		var weekday=new Array(7);
			weekday[0]="T2";
			weekday[1]="T3";
			weekday[2]="T4";
			weekday[3]="T5";
			weekday[4]="T6";
			weekday[5]="T7";
			weekday[6]="CN";
		$('td.action').click(function(){
			var url="ajaxs/viewSchedule.php";
			var date = $(this).attr('dataid');
			var strdate = new Date(date);
			strdate = weekday[strdate.getDay()-1] + ' ' + strdate.getDate() + "-" + (strdate.getMonth()+1) + "-" + strdate.getFullYear();
			$.post(url,{'date':date},function(req){
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-title').html('Lịch giảng dạy ('+strdate+')');
				$('#myModalPopup .modal-body').html(req);
				$('#myModalPopup').modal('show');
			})
		})
		$('td.cell').click(function(){
			var url="ajaxs/frm_addSchedule.php";
			var date = $(this).attr('dataid');
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
	})
</script>