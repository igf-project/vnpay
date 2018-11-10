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

$month=date('m');
$year=date('Y');
$mc_id=isset($_POST['mem_id'])?(int)$_POST['mem_id']:0;

$sql="SELECT * FROM tbl_log_profile WHERE member_course_id=".$mc_id;
$objmysql->Query($sql);
$total_rows = $objmysql->Num_rows();
?>
<div class='row'>
	<div class="col-md-4"><div class='row'>
	<table width='100%' class='calendar'>
		<thead>
			<tr>
				<th class='pre_month'><<</th>
				<th colspan='5' class='curent_month' align='center' data_month='<?php echo $month;?>' data_year='<?php echo $year;?>'>Tháng <?php echo $month.", $year";?></th>
				<th class='nex_month'>>></th>
			</tr>
			<tr>
				<th>CN</th><th>T2</th><th>T3</th><th>T4</th><th>T5</th><th>T6</th><th>T7</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	</div></div>
	<div class="col-md-6">
		<br><br><br><br>
		<div>GHI CHÚ:</div><br>
		<div><i class="fa fa-square cred"></i> Ngày đã có lịch</div><br>
		<div><i class="fa fa-square cviolet"></i> Ngày hiện tại</div>
	</div>
</div>
<script>
$(document).ready(function(){
	getCalendar(<?php echo $month;?>,<?php echo $year;?>,<?php echo $mc_id;?>);
	$(window).resize(function (){resize()} )
	$('.pre_month').click(function(){
		var _month=$('.curent_month').attr('data_month');
		var _year=$('.curent_month').attr('data_year');
		_month--;
		if(_month==0){ _year--; _month=12;}		
		if(_month==13){ _year++; _month=1;}
		var _html="Tháng "+_month+", "+_year;
		$('.curent_month').html(_html);
		$('.curent_month').attr('data_month',_month);
		$('.curent_month').attr('data_year',_year);
		getCalendar(_month,_year,<?php echo $mc_id;?>)
	});
	$('.nex_month').click(function(){
		var _month=$('.curent_month').attr('data_month');
		var _year=$('.curent_month').attr('data_year');
		_month++;
		if(_month==13){ _year++; _month=1}		
		if(_month==0){ _year--;	_month=12}
		var _html="Tháng "+_month+", "+_year;
		$('.curent_month').html(_html);
		$('.curent_month').attr('data_month',_month);
		$('.curent_month').attr('data_year',_year);
		
		getCalendar(_month,_year,<?php echo $mc_id;?>)
	});
})
function getCalendar(_month,_year,_id){ 
	var url='ajaxs/getCalendar_mem.php';
	$.post(url,{'month':_month,'year':_year,'id':_id},function(req){
		$('table.calendar tbody').html(req);
		resize();
	})
}
function resize(){
	var _w=$('table.calendar .pre_month').width();
	$('table.calendar th').css({height:35+'px','text-align':'center'});
	$('table.calendar td').css({height:_w+'px','text-align':'center'});
}
</script>