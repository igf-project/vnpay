<?php
// Pagging
if(!isset($_SESSION['CUR_PAGE_MB']))
	$_SESSION['CUR_PAGE_MB']=1;
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_MB']=(int)$_POST['txtCurnpage'];
}
$UID = $UserLogin->getInfo('id');
?>
<div class="body">
	<div class='col-md-12 body_col_right'>
		<div class='row'>
			<div class="com_header color">
				<i class="fa fa-list" aria-hidden="true"></i> Danh sách học viên
				<div class="pull-right">
					<button id="cmd_user_add" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Đăng ký học viên</button>
				</div>
			</div>
		</div>
		<div class='list_search'>
			<form id="frm-search" method='post' action="">
				<div class='row'>
					<div class='col-md-4'>
						<div class="input-group">
							<input type='text' id="keyword" name="txt_keyword" class='form-control' placeholder='Keyword'>
							<div class="input-group-btn">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" onclick="SearchUser()" aria-expanded="false">
									Search
								</button>
							</div>
						</div>
						<p id="errorIdentify"></p>
					</div>
				</div>
			</form>
		</div>
		<div id="member_list">
			<div class="list">
			</div>
		</div>
	</div>
	<script>
		function getUserByGroup($strwhere){
			var url='ajaxs/member/getUserByGroup.php';
			$.post(url,{'strwhere':$strwhere,'uid':<?php echo $UID;?>},function(req){
				$('#member_list .list').html(req);
			});
		}
		function view_calendar($this_user){
			var _id = $($this_user).attr('dataid');
			$('#myModalPopup .modal-dialog').removeClass('modal-sm');
			$('#myModalPopup .modal-dialog').addClass('modal-lg');
			$('#myModalPopup .modal-header .modal-title').html('Xem lịch học');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/view_calendar.php'; 
			$.post(url,{'mem_id':_id},function(req){
				if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
				else{
					$('#myModalPopup .modal-body').html(req);
					$('#myModalPopup').modal('show');
				}
			})
		}
		function add_MC($this_user){
			var _id = $($this_user).attr('dataid');
			$('#myModalPopup .modal-dialog').removeClass('modal-sm');
			$('#myModalPopup .modal-dialog').addClass('modal-lg');
			$('#myModalPopup .modal-header .modal-title').html('Đăng ký khóa học');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/frm_add_member_course.php'; 
			$.post(url,{'mem_id':_id},function(req){
				if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
				else{
					$('#myModalPopup .modal-body').html(req);
					$('#myModalPopup').modal('show');
				}
			})
		}
		function edit_MC($this_user){
			var _id = $($this_user).attr('dataid');
			if(_id=='' || _id==0) showMess('Chọn một khóa học để sửa','');
			else{
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin khóa học');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/frm_edit_member_course.php'; 
				$.post(url,{'id':_id},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E03'){showMess('Không tồn tại khóa học này!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
			}
			return false;
		}
		function del_MC($this_user){
			if(confirm("Bạn có chắc muốn xóa?")){
				var _id = $($this_user).attr('dataid');
				if(_id=='' || _id==0) showMess('Chọn một cá nhân để xóa','');
				else{
					var url='<?php echo ROOTHOST_ADMIN;?>api/process_del_member_course.php'; 
					$.post(url,{'id':_id},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
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
		function edit_Member($this_user){
			var _id = $($this_user).attr('dataid');
			if(_id=='' || _id==0) showMess('Chọn một học viên để sửa','');
			else{
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin học viên');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/frm_edit_member.php'; 
				$.post(url,{'id':_id},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E03'){showMess('Không tồn tại học viên này!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
			}
			return false;
		}
		function del_Member($this_user){
			if(confirm("Bạn có chắc muốn xóa?")){
				var _id = $($this_user).attr('dataid');
				if(_id=='' || _id==0) showMess('Chọn một học viên để xóa','');
				else{
					var url='<?php echo ROOTHOST_ADMIN;?>api/process_del_member.php'; 
					$.post(url,{'id':_id},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
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
		function show_profile($this_user){
			var _id = $($this_user).attr('dataid');
			if(_id=='' || _id==0) showMess('Chọn một khóa học để sửa','');
			else{
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Hồ sơ học viên');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/frm_add_log_profile.php'; 
				$.post(url,{'mc_id':_id},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E03'){showMess('Không tồn tại hồ sơ này!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
			}
			return false;
		}
		function show_fee($this_user){
			var _id = $($this_user).attr('dataid');
			if(_id=='' || _id==0) showMess('Chọn một khóa học để sửa','');
			else{
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Thông tin học phí');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/frm_add_log_fee.php'; 
				$.post(url,{'mc_id':_id},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E03'){showMess('Không tồn tại hồ sơ này!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
			}
			return false;
		}
		function SearchUser(){
			var lg = $('#keyword').val().length;
			if(lg>=3){
				var keyword = $('#keyword').val();
				getUserByGroup(keyword);
			}else{
				alert('Từ khóa tìm kiếm lớn hơn hoặc bằng 3 ký tự');
			}
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
					var url='ajaxs/member/frm_add_member.php'; 
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
		})
	</script>
</div>