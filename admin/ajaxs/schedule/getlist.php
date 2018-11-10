<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.schedule.php");
$objuser = new CLS_USER();
$objmysql = new CLS_MYSQL();
$objsche = new CLS_SCHEDULE();
/* if(!$objuser->isLogin()){
	die("E01");
} */

$gid=isset($_POST['gid'])?(int)$_POST['gid']:0;
$course_id=isset($_POST['course_id'])?(int)$_POST['course_id']:0;
$name=isset($_POST['name'])?addslashes($_POST['name']):'';
$from=isset($_POST['from'])?addslashes($_POST['from']):'';
$to=isset($_POST['to'])?addslashes($_POST['to']):'';

// Pagging
if(!isset($_SESSION['CUR_PAGE_SCHEDULE']))
	$_SESSION['CUR_PAGE_SCHEDULE']=1;
if(isset($_POST['txtCurnpage']))
	$_SESSION['CUR_PAGE_SCHEDULE']=(int)$_POST['txtCurnpage'];

$sql="select mc.id,c.name as course,m.fullname as member,u.lastname,u.firstname 
		from tbl_member_course as mc
		inner join tbl_member as m  on m.id=mc.mem_id
		inner join tbl_user as u on u.id=mc.user_id
		inner join tbl_course as c on c.id=mc.course_id
		where 1=1 ";
if($gid>0) $sql.=" and mc.user_id=$gid";
if($course_id>0) $sql.=" and mc.course_id=$course_id";
if($name!='') $sql.=" and m.fullname LIKE '%$name%'";
if($from!='') {
	$from =strtotime($from);
	$sql.=" and mc.member_course_id in (select member_course_id from tbl_schedule_task where isday>=$from";
	if($to!='') $sql.=" and isday<=$to";
	$sql.=")";
}
elseif($to!='') {
	$to =strtotime($to);
	$sql.=" and mc.member_course_id in (select member_course_id from tbl_schedule_task where isday<=$to)";
}
$sql.=" order by c.id ASC";
//echo $sql;
$objmysql->Query($sql);
$total_rows=$objmysql->Num_rows();
// End pagging


if($total_rows>0){
	echo '
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="30">#</th>
				<th>Giáo viên</th>
				<th>Khóa học</th>
				<th>Học viên</th>
				<th>Lịch học mới nhất</th>
				<th>Ghi chú</th>
			</tr>
		</thead>
		<tbody>';
			$i=0;
			while ($row=$objmysql->Fetch_Assoc()) {
				$i++;
				$mem_cou_id=$row["id"];
				$course = stripslashes($row['course']);
				$member = stripslashes($row['member']);
				$fullname=$row["lastname"].' '.$row["firstname"];
				
				$datetime=$note='';
				$objsche->getDateTime($mem_cou_id);
				$arr=$objsche->Fetch_Assoc();
				if($objsche->Num_rows()>0)
					$datetime=date('d/m/Y',$arr['isday']).' '.date('H:s',$arr['from_hour']).' => '.date('H:s',$arr['to_hour']);
				else {
					/*$datetime="<input type='date' name='txt_isday' class='form-control'/>";
					$datetime.="<input type='time' name='txt_from' class='form-control'/>";
					$datetime.="<input type='time' name='txt_to' class='form-control'/>";
					$datetime.='<i class="fa fa-times cred" aria-hidden="true" dataid="'.$mem_cou_id.'" onclick="del_user(this);"></i> Hủy';*/
				}
				echo '<tr class="trow">';
				echo '<td width="center">'.$i.'</td>';
				echo '<td>'.$fullname.'</td>';
				echo '<td>'.$course.'</td>';
				echo '<td>'.$member.'</td>';
				echo '<td>'.$datetime.'</td>';
				echo '<td width="center">'.$note.'</td>';
				echo '</tr>';
			}
			echo '
		</tbody>
	</table>';
}else{ echo 'Chưa có lịch học.';}?>
<div class="clearfix"></div>
