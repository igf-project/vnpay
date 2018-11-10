<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.course.php");

$objuser=new CLS_USER;
$objcourse=new CLS_COURSE;
$strwhere=isset($_POST['strwhere'])?addslashes($_POST['strwhere']):'';

$objcourse->getList($strwhere,'');
$total_rows=$objcourse->Num_rows();

if(!$objuser->isLogin()){
	die("E01");
}

if($total_rows>0){
	$objcourse->getList($strwhere,'');
	echo '
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="30">#</th>
				<th width="10">&nbsp;</th>
				<th>Tên</th>
				<th>Học phí</th>
				<th>Giới thiệu</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>';
			$i=0;
			while ($row=$objcourse->Fetch_Assoc()) {
				$i++;
				$ids=$row["id"];
				$name=$row["name"];
				$price=number_format($row["price"]);
				$intro = Substring($row['intro'],0,30);
				if($row['isactive']==1)	$i_active='fa fa-check cgreen';
				else $i_active='fa fa-times cred';
				echo '<tr class="trow">';
				echo '<td width="center">'.$i.'</td>';
				echo '<td width="center"><i class="fa fa-times cred" aria-hidden="true" dataid="'.$ids.'" onclick="del_user(this);"></i></td>';
				echo '<td>'.$name.'</td>';
				echo '<td>'.$price.'</td>';
				echo '<td>'.$intro.'</td>';
				echo '
				<td width="10"><i class="fa fa-edit" aria-hidden="true" dataid="'.$ids.'" onclick="edit_user(this);"></i></td>
				<td width="10"><i class="'.$i_active.'" aria-hidden="true" dataid="'.$ids.'" onclick="active_user(this);"></i></td>';
				echo '</tr>';
			}
			echo '
		</tbody>
	</table>';
}else{ echo 'Chưa có bản ghi nào.';}?>
<div class="clearfix"></div>
