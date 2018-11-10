<div class="body">
	<div class='col-md-3'>
		<div class='row body_col_left bleft bright'>
			<div class="com_header color">
				<i class="fa fa-sitemap" aria-hidden="true"></i> Nhóm quyền
			</div>
			<input type='hidden' id='guser_selected' value=''/>
			<div class='user_group_list'>
				<ul class='menu'>
					<?php $obj->getGroupPermission();?>
				</ul>
			</div>
			<div class='user_group_func'>
				<ul class='menu'>
					<li class='cmd_group_add'><a href='javascript:void(0);' class='cgreen'><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới</a></li>
					<li class="cmd_group_edit"><a href='' ><i class="fa fa-edit" aria-hidden="true"></i> Sửa nhóm</a></li>
					<li class='cmd_group_del'><a href='' class="cred"><i class="fa fa-user-times" aria-hidden="true"></i> Xóa nhóm</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class='col-md-9 body_col_right'>
		<div class='row'>
			<div class="com_header color">
				<i class="fa fa-list" aria-hidden="true"></i> Danh sách thành viên
				<div class='pull-right'>
					<button class='btn btn-default'>Thêm đơn hàng</button>
					<button class='btn btn-default'>Export excel</button>
				</div>
			</div>
		</div>
		<div class='list_search'>
			<form method='post'>
				<div class='row'>
					<div class='col-md-6'>
						<div class="input-group">
							<input type='text' class='form-control' placeholder='Typing order id or custommer name'>
							<div class="input-group-btn">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
								</button>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="#">Action</a></li>
									<li><a class="dropdown-item" href="#">Another action</a></li>
									<li><a class="dropdown-item" href="#">Something else here</a></li>
									<div role="separator" class="dropdown-divider"></div>
									<li><a class="dropdown-item" href="#">Separated link</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class='col-md-6'>
						<input type='date' class='form-control' placeholder='dd/mm/yyyy'>
					</div>
				</div>
			</form>
		</div>
		<div class='user_list'></div>
	</div>
	<script>
		function user_group_select(_item){
			var _gid=$(_item).attr('dataid');
			$('.user_group_list .menu li').removeClass('checked');
			$(_item).parent().addClass('checked');
			$('#guser_selected').val(_gid);
			getUserByGroup(_gid);
		}
		function getUserByGroup($gid){

		}
		function permiss_user($this_user){

		}
		function changepass_user($this_user){

		}
		function edit_user($this_user){

		}
		function del_user($this_user){

		}
		function active_user($this_user){

		}
		$(document).ready(function(){
			var body_h=$('.body_body').outerHeight();
			$('.body_body .body_col_left').css({'height':body_h+'px'});
			$('.cmd_group_add a').click(function(){
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').removeClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Thêm mới nhóm quyền');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='ajaxs/permission/frm_add.php'; 
				$.get(url,function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
				return false;
			});
			$('.cmd_group_edit a').click(function(){
				var _gid=$('#guser_selected').val();
				if(_gid=='' || _gid==0) showMess('Bạn chưa chọn nhóm để sửa','error');
				else{
					$('#myModalPopup .modal-dialog').removeClass('modal-sm');
					$('#myModalPopup .modal-dialog').removeClass('modal-lg');
					$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin nhóm quyền');
					$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
					var url='ajaxs/permission/frm_add.php'; 
					$.get(url,{'id':_gid},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E02'){showMess('Không có quyền sửa nhóm này!','error');}
						else{
							$('#myModalPopup .modal-body').html(req);
							$('#myModalPopup').modal('show');
						}
					})
				}
				return false;
			});
			$('.cmd_group_del a').click(function(){
				var _gid=$('#guser_selected').val();
				var url='ajaxs/permission/del.php'; 
				$.get(url,{'id':_gid},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E02'){showMess('Không có quyền xóa nhóm này!','error');}
					$('.user_group_list').html(req);
				});
				return false;
			});
		})
	</script>
</div>