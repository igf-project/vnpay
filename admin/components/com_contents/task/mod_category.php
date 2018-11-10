<?php
$cate_id= isset($_GET['cate'])?(int)$_GET['cate']:0;
?>
<div class="com_header color">
	<i class="fa fa-sitemap" aria-hidden="true"></i> <a href="<?php echo ROOTHOST_ADMIN.COMS?>" title="Tin tức">Tin tức</a>
</div>
<input type='hidden' id='guser_selected' value=''/>
<div class='user_group_list'>
	<?php $obj_cate->getListCategory(); ?>
</div>
<div class='user_group_func'>
	<ul class='nav'>
		<li class='cmd_group_add'><a href='<?php echo ROOTHOST_ADMIN;?>category/add' class='cgreen'><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới</a></li>
		<?php
		if($cate_id>0){
			echo '<li class="cmd_group_edit"><a href="'.ROOTHOST_ADMIN.'category/edit/'.$cate_id.'" ><i class="fa fa-edit" aria-hidden="true"></i> Sửa nhóm</a></li>';
			echo '<li class="cmd_group_del"><a href="'.ROOTHOST_ADMIN.'category/delete/'.$cate_id.'" class="cred" onclick="return confirm(\'Bạn có chắc muốn xóa?\')"><i class="fa fa-user-times" aria-hidden="true"></i> Xóa nhóm</a></li>';
		}else{
			echo '<li class="cmd_group_edit disabled"><a href="javascript:void(0)" ><i class="fa fa-edit" aria-hidden="true"></i> Sửa nhóm</a></li>';
			echo '<li class="cmd_group_del disabled"><a href="javascript:void(0)" class="cred"><i class="fa fa-user-times" aria-hidden="true"></i> Xóa nhóm</a></li>';
		}
		?>
	</ul>
</div>
<script type="text/javascript">
	// function getListCategory(){
 //        var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/content/getListCategory.php';
 //        $.get(url,function(req){
 //            $('.user_group_list').html(req);
 //        })
 //    }
	// $(document).ready(function(){
	// 	var body_h=$('.body_body').outerHeight();
	// 	$('.body_body .body_col_left').css({'height':body_h+'px'});
	// 	$(".sl_user").select2();
	// 	$(".sl_user1").select2();

	// 	getListCategory();
		// $('.cmd_group_add a').click(function(){
		// 	$('#myModalPopup .modal-dialog').removeClass('modal-sm');
		// 	$('#myModalPopup .modal-dialog').addClass('modal-lg');
		// 	$('#myModalPopup .modal-header .modal-title').html('Thêm bài viết');
		// 	$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
		// 	var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/content/frm_add_category.php'; 
		// 	$.get(url,function(req){
		// 		if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
		// 		if(req=='E02'){showMess('Không có quyền thêm bài viết vào nhóm này!','error');}
		// 		else{
		// 			$('#myModalPopup .modal-body').html(req);
		// 			$('#myModalPopup').modal('show');
		// 		}
		// 	})
		// })

		// $('.cmd_group_edit a').click(function(){
		// 	var cate_id=$('#guser_selected').val();
		// 	if(cate_id=='' || cate_id==0) showMess('Bạn chưa chọn nhóm để sửa','error');
		// 	else{
		// 		$('#myModalPopup .modal-dialog').removeClass('modal-sm');
		// 		$('#myModalPopup .modal-dialog').addClass('modal-lg');
		// 		$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin nhóm bài viết');
		// 		$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
		// 		var url='ajaxs/content/frm_add_category.php'; 
		// 		$.get(url,function(req){
		// 			if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
		// 			if(req=='E02'){showMess('Không có quyền sửa nhóm này!','error');}
		// 			else{
		// 				$('#myModalPopup .modal-body').html(req);
		// 				$('#myModalPopup').modal('show');
		// 			}
		// 		})
		// 	}
		// 	return false;
		// });

		// $('.cmd_group_del a').click(function(){
		// 	if(confirm("Bạn có chắc muốn xóa?")){
		// 		var _gid=$('#guser_selected').val();
		// 		var url='ajaxs/user/del_group.php'; 
		// 		$.get(url,{'id':_gid},function(req){
		// 			if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
		// 			if(req=='E02'){showMess('Không có quyền xóa nhóm này!','error');}
		// 			$('.user_group_list').html(req);
		// 		});
		// 		return false;
		// 	}
		// });
	// });
</script>