<?php 
$objmysql = new CLS_MYSQL();
$strwhere=''; 
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// Pagging
if(!isset($_SESSION['CUR_PAGE_MC']))
	$_SESSION['CUR_PAGE_MC']=1;
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_MC']=(int)$_POST['txtCurnpage'];
}
?>
<style type="text/css">
	.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
		vertical-align: middle;
	}
</style>
<div class="body">
	<div class='col-md-12 body_col_right'>
		<div class='row'>
			<div class="com_header color">
				<i class="fa fa-list" aria-hidden="true"></i> Danh sách khóa học & học viên
				<div class="pull-right">
					<button id="cmd_user_add" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Đăng ký học viên</button>
					<button id="cmd_driver_add" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Đăng ký khóa học</button>
				</div>
			</div>
		</div>
		<div class='list_search'>
			<form id="frm-search" method='post' action="">
				<ul class="list-inline">
					<li><input type="text" class="form-control" name="txt_keyword" placeholder="Tên học viên"></li>
					<li>
						<select class="form-control" name="cbo_course">
							<option value="0"> -- Khóa học --</option>
							<?php
							$sql="SELECT `name`,`id` FROM tbl_course WHERE isactive=1";
							$objmysql=new CLS_MYSQL();
							$objmysql->Query($sql);
							while ($row_c = $objmysql->Fetch_Assoc()) {
								echo'<option value="'.$row_c['id'].'">'.$row_c['name'].'</option>';
							}
							?>
						</select>
					</li>
					<?php
					if($UserLogin->permission()==true){
						?>
						<li>
							<select class="form-control" name="cbo_teacher">
								<option value="0"> -- Giáo viên --</option>
								<?php
								$sql="SELECT CONCAT(`firstname`,' ',`lastname`) AS 'fullname',`id` FROM tbl_user WHERE isactive=1 AND gid=2";
								$objmysql=new CLS_MYSQL();
								$objmysql->Query($sql);
								while ($row_m = $objmysql->Fetch_Assoc()) {
									echo'<option value="'.$row_m['id'].'">'.$row_m['fullname'].'</option>';
								}
								?>
							</select>
						</li>
						<?php
					}else{
						echo '<input type="hidden" name="cbo_teacher" value="'.$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'].'">';
					}
					?>
					<li><input type="button" id="btn_search" onclick="SearchMember()" class="btn btn-primary" name="" value="Tìm kiếm"></li>
				</ul>
			</form>
		</div>
		<div id="mem_course_list">
			<div class="list"></div>
		</div>
	</div>
</div>
<script>
	function getUserByGroup($strwhere){
		var url='ajaxs/member_course/getUserByGroup.php';
		$.post(url,{'strwhere':$strwhere},function(req){
			$('#mem_course_list .list').html(req);
		});
	}
	function edit_user($this_user){
		var _userid = $($this_user).attr('dataid');
		if(_userid=='' || _userid==0) showMess('Chọn một bằng lái để sửa','');
		else{
			$('#myModalPopup .modal-dialog').removeClass('modal-sm');
			$('#myModalPopup .modal-dialog').addClass('modal-lg');
			$('#myModalPopup .modal-header .modal-title').html('Sửa bằng lái');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			var url='ajaxs/member_course/frm_edit.php'; 
			$.post(url,{'userid':_userid},function(req){
				if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
				if(req=='E03'){showMess('Không bằng lái này!','error');}
				else{
					$('#myModalPopup .modal-body').html(req);
					$('#myModalPopup').modal('show');
				}
			})
		}
		return false;
	}
	function del_user($this_user){
		if(confirm("Bạn có chắc muốn xóa?")){
			var _userid = $($this_user).attr('dataid');
			if(_userid=='' || _userid==0) showMess('Chọn một bằng lái để xóa','');
			else{
				var url='ajaxs/member_course/process_del.php'; 
				$.post(url,{'userid':_userid},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E03'){showMess('Không tồn tại bằng lái này!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
					else{
						getUserByGroup();
						showMess('Success!','success');
					}
				})
			}
			return false;
		}
	}
	function active_user($this_user){
		var _userid = $($this_user).attr('dataid');
		if(_userid=='' || _userid==0) showMess('Chọn một bằng lái để active','');
		else{
			var url='ajaxs/member_course/process_active.php'; 
			$.post(url,{'userid':_userid},function(req){
				if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
				if(req=='E03'){showMess('Không tồn tại bằng lái này!','error');}
				if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
				else{
					getUserByGroup();
					showMess('Success!','success');
				}
			})
		}
		return false;
	}
	function SearchMember(){
		var data = $('#frm-search').serializeArray();
		var url = 'ajaxs/member_course/search_member.php';
		$.post(url,data,function(req){
			getUserByGroup(req);
		})
	}
	$(document).ready(function(){
		getUserByGroup();
		$('#cmd_user_add').click(function(){
			var _gid=$('#guser_selected').val();
			if(_gid=='undefined' || _gid==0) showMess('Bạn chưa chọn nhóm để thêm','');
			else{
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Đăng ký học viên');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='ajaxs/member/frm_add_user.php'; 
				$.get(url,{'id':_gid},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
			}
			return false;
		})
		$('#cmd_driver_add').click(function(){
			$('#myModalPopup .modal-dialog').removeClass('modal-sm');
			$('#myModalPopup .modal-dialog').addClass('modal-lg');
			$('#myModalPopup .modal-header .modal-title').html('Thêm học viên & khóa học');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			var url='ajaxs/member_course/frm_add.php'; 
			$.get(url,function(req){
				if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
				else{
					$('#myModalPopup .modal-body').html(req);
					$('#myModalPopup').modal('show');
				}
			})
			return false;
		})
	})
</script>