<?php
$cate_id= isset($_GET['cate'])?(int)$_GET['cate']:0;
?>
<div class="com_header color">
	<i class="fa fa-sitemap" aria-hidden="true"></i> <a href="<?php echo ROOTHOST_ADMIN;?>document_type" title="Tài liệu">Nhóm Tài liệu</a>
</div>
<input type='hidden' id='guser_selected' value=''/>
<div class='user_group_list'>
	<?php $obj_doctype->getListCategory(); ?>
</div>
<div class='user_group_func'>
	<ul class='nav'>
		<li class='cmd_group_add'><a href='<?php echo ROOTHOST_ADMIN;?>document_type/add' class='cgreen'><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới</a></li>
		<?php
		if($cate_id>0){
			echo '<li class="cmd_group_edit"><a href="'.ROOTHOST_ADMIN.'document_type/edit/'.$cate_id.'" ><i class="fa fa-edit" aria-hidden="true"></i> Sửa nhóm</a></li>';
			echo '<li class="cmd_group_del"><a href="'.ROOTHOST_ADMIN.'document_type/delete/'.$cate_id.'" class="cred" onclick="return confirm(\'Bạn có chắc muốn xóa?\')"><i class="fa fa-user-times" aria-hidden="true"></i> Xóa nhóm</a></li>';
		}else{
			echo '<li class="cmd_group_edit disabled"><a href="javascript:void(0)" ><i class="fa fa-edit" aria-hidden="true"></i> Sửa nhóm</a></li>';
			echo '<li class="cmd_group_del disabled"><a href="javascript:void(0)" class="cred"><i class="fa fa-user-times" aria-hidden="true"></i> Xóa nhóm</a></li>';
		}
		?>
	</ul>
</div>