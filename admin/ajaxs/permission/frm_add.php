<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.permission.php");
$obj_permission=new CLS_PERMISSION;

$id=isset($_GET['id'])?(int)$_GET['id']:0;
$name='';$intro='';
if($id>0){
	$obj_permission->getList(" AND id=$id",'');
	$r=$obj_permission->Fetch_Assoc();
	$name=$r['name'];
	$intro=$r['intro'];
}
?>
<form>
	<?php if($id>0){?>
	<input type="hidden" class="form-control" require id="txt_id" value="<?php echo $id;?>">
	<?php }?>
	<div class="form-group">
		<label>Tên :</label>
		<input type="text" id="txt_name" name="txt_name" class="form-control" value="<?php echo $name;?>" placeholder="Tên nhóm" required>
	</div>
	<label for="pwd">Giới thiệu:</label>
	<textarea class="form-control" id="txt_intro" rows=5><?php echo $intro;?></textarea>
	<div class="clearfix"></div><br><br>
	<button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
	<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
$(document).ready(function(){
	$('#cmd_save').click(function(){
		var id=$('#txt_id').val()!='undefined'?$('#txt_id').val():0;
		var name=$('#txt_name').val();
		var intro=$('#txt_intro').val();
		var url='ajaxs/permission/process_add.php'; 
		$.post(url,{'txt_id':id,'txt_name':name,'txt_intro':intro},function(req){
			if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
			if(req=='E03'){showMess('Không có quyền thêm danh mục con cho nhóm này!','error');}
			else {
				$('.user_group_list').html(req);
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