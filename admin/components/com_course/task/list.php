<div class="body">
	<div class='col-md-12 body_col_right'>
		<div class='row'>
			<div class="com_header color">
				<i class="fa fa-list" aria-hidden="true"></i> Danh sách bằng lái
				<div class="pull-right">
					<button id="cmd_driver_add" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới</button>
				</div>
			</div>
		</div><br>
		<div id="driver_list">
			<div class="list"></div>
		</div>
	</div>
	<script>
		function getUserByGroup($strwhere){
			var url='ajaxs/course/getUserByGroup.php';
			$.post(url,{'strwhere':$strwhere},function(req){
				$('#driver_list .list').html(req);
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
				var url='ajaxs/course/frm_edit.php'; 
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
					var url='ajaxs/course/process_del.php'; 
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
				var url='ajaxs/course/process_active.php'; 
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
		$(document).ready(function(){
			getUserByGroup();
			$('#cmd_driver_add').click(function(){
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Thêm bằng lái');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='ajaxs/course/frm_add.php'; 
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
</div>