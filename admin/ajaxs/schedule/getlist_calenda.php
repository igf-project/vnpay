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

// Pagging
if(!isset($_SESSION['CUR_PAGE_SCHEDULE']))
	$_SESSION['CUR_PAGE_SCHEDULE']=1;
if(isset($_POST['txtCurnpage']))
	$_SESSION['CUR_PAGE_SCHEDULE']=(int)$_POST['txtCurnpage'];

$sql="select mc.id,m.fullname
		from tbl_member_course as mc
		inner join tbl_member as m  on m.id=mc.mem_id
		inner join tbl_user as u on u.id=mc.user_id
		where 1=1 ";
if($gid>0) $sql.=" and mc.user_id=$gid";

$sql.=" order by mc.id ASC";
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
				<th>Nội dung</th>
				<th>Học viên</th>
				<th>Thời gian</th>
				<th></th>
			</tr>
		</thead>
		<tbody>';
			$i=0;
			while ($row=$objmysql->Fetch_Assoc()) {
				$i++;
				$mem_cou_id=$row["id"];
				$member = stripslashes($row['fullname']);
				
				$datetime=$note='';
				$objsche->getDateTime($mem_cou_id);
				$arr=$objsche->Fetch_Assoc();
				if($objsche->Num_rows()>0)
					$datetime=date('d/m/Y',$arr['isday']).' '.date('H:s',$arr['from_hour']).' => '.date('H:s',$arr['to_hour']);
				echo '<tr class="trow">';
				echo '<td width="center">'.$i.'</td>';
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
