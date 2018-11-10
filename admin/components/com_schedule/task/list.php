<?php
$strwhere='';$uid = '';
$PERMISSION = $UserLogin->getInfo('isroot');
if($PERMISSION!=1) {
	$uid = $UserLogin->getInfo('id');
	$fullname = $UserLogin->getInfo('lastname').' '.$UserLogin->getInfo('firstname');
}
//if($PERMISSION==1){
	?>
	<div class="body">
		<div class='col-md-3'>
			<div class='row body_col_left bleft bright'>
				<div class="com_header color">
					<i class="fa fa-sitemap" aria-hidden="true"></i> Khóa học
				</div>
				<div class='user_group_func'>
					<?php $objcou->getcourse();?>
				</div>
				<div class="com_header color">
					<i class="fa fa-sitemap" aria-hidden="true"></i> Giáo viên
				</div>
				<input type='hidden' id='guser_selected' value='<?php echo $uid;?>'/>
				<input type='hidden' id='gcourse_selected' value=''/>
				<div class='user_group_list'>
					<?php if($PERMISSION==1) $UserLogin->getUserInGroup(2);
					else {?>
					<ul class='menu'>
						<li class="checked"><a href='javascript:void(0);' onclick='user_group_select(this);' dataid='<?php echo $uid;?>'><?php echo $fullname;?></a></li>
					</ul>
					<script>getList();</script>
					<?php }?>
				</div>
			</div>
		</div>
		<div class='col-md-9 body_col_right'>
			<div class='row'>
				<div class="com_header color">
					<i class="fa fa-list" aria-hidden="true"></i>  Lịch giảng dạy
					<div class="pull-right"></div>
				</div>
			</div>
			<div class='list_search'>
				<form method='post'>
					<div class='row'>
						<div class="col-md-3">
							Tên học viên <input type='text' id="txtname" name="txtname" class='form-control' placeholder='Nhập tên học viên'>
						</div>
						<div class="col-md-3">
							Từ ngày <input type='date' id="from_date" name="from_date" class='form-control' placeholder='dd/mm/yyyy'>
						</div>
						<div class="col-md-3">
							Đến ngày <input type='date' id="to_date" name="to_date" class='form-control' placeholder='dd/mm/yyyy'>
						</div>
					</div>
					<div class="form-group">
						<br><button type="button" class="btn btn-secondary" id="btn_search">Tìm kiếm</button>
					</div>
				</form>
			</div>
			<div class='user_list'>
				<div class="list">
				</div>
			</div>
		</div>
		<script>
			function user_group_select(_item){
				var _gid=$(_item).attr('dataid');
				$('.user_group_list .menu li').removeClass('checked');
				$(_item).parent().addClass('checked');
				$('#guser_selected').val(_gid);
				getList();
			}
			function getList(){
				var gid=$('#guser_selected').val();
				var course=$('#gcourse_selected').val();
				var name=$('#txtname').val();
				var from=$('#from_date').val();
				var to=$('#to_date').val();
				var url='ajaxs/schedule/getlist.php';
				$.post(url,{'gid':gid,'course_id':course,'name':name,'from':from,'to':to},function(req){ 
					$('.user_list .list').html(req);
				});
			}
			function course_select(_item){
				var _gid=$(_item).attr('dataid');
				$('.user_group_func .menu li').removeClass('checked');
				$(_item).parent().addClass('checked');
				$('#gcourse_selected').val(_gid);
				getList();
			}
			function edit_user($this_user){
				var _gid=$('#guser_selected').val();
				var _userid = $($this_user).attr('dataid');
				if(_userid=='' || _userid==0) showMess('Chọn một cá nhân để sửa','');
				else{
					$('#myModalPopup .modal-dialog').removeClass('modal-sm');
					$('#myModalPopup .modal-dialog').addClass('modal-lg');
					$('#myModalPopup .modal-header .modal-title').html('Sửa người dùng');
					$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
					var url='ajaxs/schedule/frm_edit_user.php'; 
					$.post(url,{'userid':_userid,'gid':_gid},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E02'){showMess('Không có quyền sửa người dùng ở nhóm này!','error');}
						if(req=='E03'){showMess('Không tồn tại người dùng này!','error');}
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
					var _gid=$('#guser_selected').val();
					var _userid = $($this_user).attr('dataid');
					if(_userid=='' || _userid==0) showMess('Chọn một cá nhân để xóa','');
					else{
						var url='ajaxs/schedule/process_del_user.php'; 
						$.post(url,{'userid':_userid,'gid':_gid},function(req){
							if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
							if(req=='E02'){showMess('Không có quyền xóa người dùng ở nhóm này!','error');}
							if(req=='E03'){showMess('Không tồn tại người dùng này!','error');}
							if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
							else{
								getList();
								showMess('Success!','success');
							}
						})
					}
					return false;
				}
			}
			function active_user($this_user){
				var _gid=$('#guser_selected').val();
				var _userid = $($this_user).attr('dataid');
				if(_userid=='' || _userid==0) showMess('Chọn một cá nhân để active','');
				else{
					var url='ajaxs/schedule/process_active_user.php'; 
					$.post(url,{'userid':_userid,'gid':_gid},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E02'){showMess('Không có quyền sửa người dùng ở nhóm này!','error');}
						if(req=='E03'){showMess('Không tồn tại người dùng này!','error');}
						if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
						else{
							getList();
							showMess('Success!','success');
						}
					})
				}
				return false;
			}
			$(document).ready(function(){
				getList();
				var body_h=$('.body_body').outerHeight();
				$('.body_body .body_col_left').css({'height':body_h+'px'});
			})
			$('#btn_search').click(function(){
				getList();
			});
		</script>
	</div>
	<?php 
//}else{die("Bạn không có quyền truy cập!");}?>