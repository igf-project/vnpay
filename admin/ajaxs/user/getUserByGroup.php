<?php
session_start();
define('OBJ_PAGE','GETUSERBYGROUP');
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
require_once("../../libs/cls.permission.php");
$objuser=new CLS_USER;
$objmysql = new CLS_MYSQL();
$obj_permission=new CLS_PERMISSION;
$gid=isset($_POST['gid'])?(int)$_POST['gid']:0;
$strwhere=" AND `gid`=$gid ";

// Pagging
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE]))
	$_SESSION['CUR_PAGE_'.OBJ_PAGE]=1;
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE]=(int)$_POST['txtCurnpage'];
}
$objuser->getList($strwhere,'');
$total_rows=$objuser->Num_rows();
// End pagging
/* if(!$objuser->isLogin()){
	die("E01");
} */
if($total_rows>0){
	$objuser->getList($strwhere,'');
	echo '
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="30">#</th>
				<th width="10">&nbsp;</th>
				<th>Username</th>
				<th>Fullname</th>
				<th>Cơ quan</th>
				<th>Phone</th>
				<th>Giới tính</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>';
			$i=0;
			while ($row=$objuser->Fetch_Assoc()) {
				$i++;
				$ids=$row["id"];
				$username = stripslashes($row['username']);
				$fullname=$row["lastname"].' '.$row["firstname"];
				$phone = $row['phone'];
				$organ = stripslashes($row['organ']);
				if((int)$row['gender']==0) $gender="Nam";
				else $gender="Nữ";
				if($row['isactive']==1)	$i_active='fa fa-check cgreen';
				else $i_active='fa fa-times cred';
				echo '<tr class="trow">';
				echo '<td width="center">'.$i.'</td>';
				echo '<td width="center"><i class="fa fa-times cred" aria-hidden="true" dataid="'.$ids.'" onclick="del_user(this);"></i></td>';
				echo '<td>'.$username.'</td>';
				echo '<td>'.$fullname.'</td>';
				echo '<td>'.$organ.'</td>';
				echo '<td>'.$phone.'</td>';
				echo '<td>'.$gender.'</td>';
				echo '
				<td width="10"><i class="fa fa-edit" aria-hidden="true" dataid="'.$ids.'" onclick="edit_user(this);"></i></td>
				<td width="10"><i class="'.$i_active.'" aria-hidden="true" dataid="'.$ids.'" onclick="active_user(this);"></i></td>';
				echo '</tr>';
			}
			echo '
		</tbody>
	</table>';
}else{ echo 'Chưa có người dùng.';}?>
<div class="clearfix"></div>
