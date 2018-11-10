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
$objmem=new CLS_MEMBERS;
$objmysql = new CLS_MYSQL();
if(isset($_POST['strwhere'])){
	$strwhere=" AND `fullname` like '%".$_POST['strwhere']."%' OR identify='".(int)$_POST['strwhere']."'";
}else{
	$strwhere='';
}
//$PERMISSION = $objuser->getInfo('isroot');
//if($PERMISSION!=1 && isset($_POST['uid'])){
	//$strwhere.=" AND id IN (SELECT mem_id FROM tbl_member_course WHERE user_id=".(int)$_POST['uid'].') ';
//}
$objmem->getList($strwhere,'');
$total_rows=$objmem->Num_rows();
$max_rows =10;
if($_SESSION['CUR_PAGE_MB']>ceil($total_rows/$max_rows))
	$_SESSION['CUR_PAGE_MB']=ceil($total_rows/$max_rows);
$cur_page=(int)$_SESSION['CUR_PAGE_MB']>0 ? $_SESSION['CUR_PAGE_MB']:1;

if(!$objuser->isLogin()){
	die("E01");
}

$star=($cur_page-1)*$max_rows;
$leng=$max_rows;
$objmem->getList($strwhere," order by id desc LIMIT $star,$leng ");
while ($row_m=$objmem->Fetch_Assoc()) {
	if($row_m['imgbase64']==''){
		if($row_m['avatar']=='')
			$row_m['avatar']='../../uploads/user.png';
		$avatar = explode('../../',$row_m['avatar']);
		$avatar= getThumb(ROOTHOST_ADMIN.$avatar[1],'img-responsive tb_avatar',$row_m['fullname']);
	}else{
		$avatar = explode('../../',$row_m['imgbase64']);
		$avatar=getThumb(ROOTHOST_ADMIN.$avatar[1],'img-responsive tb_avatar',$row_m['fullname']);
	}	
	?>
	<div class="row">
		<div class="item" style='border-bottom:#999 1px dotted;padding:15px 0'>
			<div class="col-sm-6">
				<article class="box-avatar pull-left"><?php echo $avatar;?></article>
				<ul class="list_info_member nav">
					<li><label>Họ và tên: </label><span><?php echo $row_m['fullname'];?></span></li>
					<li><label>SĐT: </label><span><?php echo $row_m['phone'];?></span></li>
					<li><label>Email: </label><span><?php echo $row_m['email'];?></span></li>
					<li><label>CMTND: </label><span><?php echo $row_m['identify'];?></span></li>
					<li><label>Địa chỉ: </label><span><?php echo $row_m['address'];?></span></li>
				</ul>
				<div class="clearfix"></div><br/>
				<div class="control_member">
					<button class="btn btn-primary" onclick="edit_Member(this);" dataid="<?php echo $row_m['id'];?>"><i class="fa fa-edit" aria-hidden="true"></i>Sửa</button>
					<button class="btn btn-default" onclick="del_Member(this);" dataid="<?php echo $row_m['id'];?>"><i class="fa fa-times cred" aria-hidden="true"></i>Xóa</button>
				</div>
			</div>
			<div class="col-md-6">
				<?php $mem_id = $row_m['id'];
				$objmysql=new CLS_MYSQL;
				$sql="SELECT mc.*, m.fullname, m.id as mem_id, u.id as user_id, CONCAT(u.lastname,' ', u.firstname) AS 'name_teacher', c.name, c.id as course_id FROM tbl_member_course AS mc, tbl_member AS m, tbl_user AS u, tbl_course AS c WHERE mc.user_id= u.id AND mc.course_id= c.id AND mc.mem_id = m.id AND mem_id=$mem_id ";
				$objmysql->Query($sql);
				echo '
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="30">#</th>
							<th>Khóa học</th>
							<th>Giáo viên</th>
							<th>Hồ sơ</th>
							<th>Học phí</th>
							<th colspan="2" class="text-center"><button class="btn btn-primary" dataid="'.$mem_id.'" onclick="add_MC(this)">Đăng ký</button></th>
						</tr>
					</thead>
					<tbody>';
						$i=0;
						while ($row=$objmysql->Fetch_Assoc()) {
							$i++;
							$ids=$row["id"];
							$user_name = $row['name_teacher'];
							$course_name = $row['name'];
							if($row['isactive']==1)	$i_active='fa fa-check cgreen';
							else $i_active='fa fa-times cred';
							echo '<tr class="trow">';
							echo '<td width="center">'.$i.'</td>';
							echo '<td>'.$course_name.'</td>';
							echo '<td>'.$user_name.'</td>';
							echo '<td alight="center" style="width:50px;text-align:center;"><i class="fa fa-history" dataid="'.$ids.'" onclick="show_profile(this);" aria-hidden="true"></i></td>';
							echo '<td style="width:50px;text-align:center;"><i class="fa fa-history" dataid="'.$ids.'" onclick="show_fee(this);" aria-hidden="true"></i></td>';
							echo '
							<td width="10"><i class="fa fa-calendar" aria-hidden="true" dataid="'.$ids.'" onclick="view_calendar(this);"></i></td>
							<td width="10"><i class="fa fa-times cred" aria-hidden="true" dataid="'.$ids.'" onclick="del_MC(this);"></i></td>';
							echo '</tr>';
						}
						echo '
					</tbody>
				</table>';?>
			</div>
			<div class='clearfix'></div>
		</div>
	</div>
	<?php 
} // endwhile ?>
<div class="text-center">
	<?php 
	paging($total_rows,$max_rows,$cur_page);
	?>
</div>
<div class="clearfix"></div>
