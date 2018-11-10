<script src="js/script.min.js"></script>
<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.schedule.php");
$objSchedule=new CLS_SCHEDULE;
$objmysql = new CLS_MYSQL();

$id=isset($_POST['id'])?(int)$_POST['id']:0;
$fullname=$identify=$phone=$organ=$gender=$avatar=$task=$time_number=$number_user='';
if($id>0){
	$sql="SELECT CONCAT(u.firstname,u.lastname) AS fullname, u.id,u.address, u.avatar, u.organ, s.id_boss, u.identify, s.task, u.phone, gender, s.time_number, s.number_user,s.schedule_time, s.status, s.id as id_schedule  FROM tbl_schedule as s, tbl_user as u  WHERE u.id = s.id_user AND s.id=$id";
	$objmysql->Query($sql);
	if($objmysql->Num_rows()>0){
		$r=$objmysql->Fetch_Assoc();
		$ids=$r["id"];
		$user_id = $r[`u`.'id'];
		$id_boss=$r["id_boss"];
		$identify = $r['identify'];
		$fullname=$r["fullname"];
		$phone = $r['phone'];
		$organ = stripslashes($r['organ']);
		$task = stripslashes($r[`s`.'task']);
		$time_number = (int)$r[`s`.'time_number'];
		$number_user = (int)$r[`s`.'number_user'];
		if((int)$r['gender']==0) $gender="Nam";
		else $gender="Nữ";
		if($r['avatar']==''){
			$avatar='<img src="'.IMG_DEFAULT.'" class="img-responsive" alt="'.$fullname.'">';
		}else{
			$avatar = getThumb($r['avatar'],'',$fullname);
		}
	}
}
?>
<form id="frm-edit-schedule" class="smart-form">
	<input type="hidden" class="form-control" id="txt_id" name="txt_id" value="<?php echo $id;?>">
	<input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" value="<?php echo $user_id;?>">
	<div class="row">
		<div class="col-md-6">
			<label class="title">Thông tin người đặt lịch</label><hr/>
			<div class="row">
				<div class="col-md-4"><?php echo $avatar;?></div>
				<div class="col-md-8">
					<table class="table">
						<tr>
							<td>CMTND: </td>
							<td><?php echo $identify;?></td>
						</tr>
						<tr>
							<td>Họ tên: </td>
							<td><?php echo $fullname;?></td>
						</tr>
						<tr>
							<td>Điện thoại: </td>
							<td><?php echo $phone;?></td>
						</tr>
						<tr>
							<td>Giới tính: </td>
							<td><?php echo $gender;?></td>
						</tr>
						<tr>
							<td>Cơ quan: </td>
							<td><?php echo $organ;?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<label class="title">Nội dung đặt lịch hẹn</label><hr/>
			<article>
				<div class="form-group">
					<label class="label">Cần gặp ai<span class="cred"> (*)</span></label>
					<label class="select">
						<select id="cbo_boss" class="form-control" name="cbo_boss">
							<option value="">Chọn người cần gặp</option>
							<?php
							$sql="SELECT id AS user_id,CONCAT(`lastname`,`firstname`) AS 'fullname'  FROM tbl_user WHERE `tbl_user`.`isactive`=1 AND gid IN (SELECT id AS gboss_id FROM tbl_user_group WHERE isactive=1 AND isboss=1)";
							$objmysql->Query($sql);
							if($objmysql->Num_rows()>0){
								while ($grow=$objmysql->Fetch_Assoc()) {
									$id = $grow['user_id'];
									$fullname = stripslashes($grow['fullname']);
									echo '<option value="'.$id.'">'.$fullname.'</option>';
								}
							}
							?>
							<script type="text/javascript">
								cbo_Selected('cbo_boss','<?php echo $id_boss;?>');
							</script>
						</select>
					</label>
				</div>
				<div class="form-group">
					<label class="label">Nội dung cuộc hẹn<span class="cred"> (*)</span></label>
					<textarea class="form-control radi0" name="txt_content" rows="3"><?php echo $task;?></textarea>
				</div>
				<div class="form-group">
					<label class="label">Thời gian gặp<span class="cred"> (*)</span></label>
					<select name="time_number" id="time_number" class="form-control">
						<option value="">Chọn thời gian gặp</option>
						<option value="5">5 phút</option>
						<option value="15">15 phút</option>
						<option value="30">30 phút</option>
						<option value="45">45 phút</option>
						<option value="60">1 giờ</option>
						<option value="120">2 giờ</option>
						<option value="180">3 giờ</option>
						<script type="text/javascript">
							cbo_Selected('time_number','<?php echo $time_number;?>');
						</script>
					</select>
				</div>
				<div class="form-group">
					<label class="label">Số lượng người trong đoàn<span class="cred"> (*)</span></label>
					<input type="number" id="txt_number" name="txt_number" class="form-control" value="<?php echo $number_user;?>" min="1">
					<span style="color:red" id="errNumber" ></span>
				</div>
				<div class="form-group" style="display: none;">
					<label class="label">Đi với ai</label>
					<textarea name="attach_user" id="attach_user" rows="3"></textarea>
				</div>
			</article>
		</div>
	</div>
	<div class="clearfix"></div><br><br>
	<button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
	<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cmd_save').click(function(){
			var data = $('#frm-edit-schedule').serializeArray();
			var url='ajaxs/schedule/process_add.php'; 
			$.post(url,data,function(req){
				if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
				if(req=='E03'){showMess('Không có quyền thêm danh mục con cho nhóm này!','error');}
				else {
					getList();
					showMess('Success!','success');
				}
			});
		});
		$('#cmd_cancel').click(function(){
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin người dùng');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			$('#myModalPopup').modal('hide');
		});
	})
</script>