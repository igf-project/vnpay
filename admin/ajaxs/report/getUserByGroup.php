<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.members.php");
require_once("../../libs/cls.member_course.php");

$objuser=new CLS_USER;
$objmem = new CLS_MEMBERS;
$objmemcourse=new CLS_MEMBER_COURSE;
$strwhere=isset($_POST['strwhere'])?stripslashes($_POST['strwhere']):'';


$objmemcourse->getList($strwhere,'');
$total_rows=$objmemcourse->Num_rows();

if(!$objuser->isLogin()){
	die("E01");
}

if($total_rows>0){
	echo '
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="30">#</th>
				<th>Tên học viên</th>
				<th>Khóa học</th>
				<th>Giáo viên</th>
				<th>Số điện thoại</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>';
			$i=0;
			while ($row=$objmemcourse->Fetch_Assoc()) {
				$i++;
				$ids=$row["id"];
				$info_M = $objmem->getInfo(" AND id=".$row['mem_id']." AND isactive=1");
				$user = $objmemcourse->getNameUserByID($row['user_id']);
				$course = $objmemcourse->getNameCourseByID($row['course_id']);
				if($row['isactive']==1)	$i_active='fa fa-check cgreen';
				else $i_active='fa fa-times cred';
				echo '<tr class="trow">';
				echo '<td width="center">'.$i.'</td>';
				echo '<td>'.$info_M['fullname'].'</td>';
				echo '<td>'.$course.'</td>';
				echo '<td>'.$user.'</td>';
				echo '<td>'.$info_M['phone'].'</td>';
				echo '<td>'.$info_M['email'].'</td>';
				echo '</tr>';
			}
			echo '
		</tbody>
	</table>';
}else{ echo 'Chưa có bản ghi nào.';}?>
<div class="clearfix"></div>
