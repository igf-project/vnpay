<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','guide');
define('OBJ','Trợ giúp');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
// Begin Toolbar
require_once('libs/cls.cate_guide.php');
require_once('libs/cls.guide.php');

$obj=new CLS_GUIDE();
$obj_cate=new CLS_CATEGORY_GUIDE();

if(isset($_POST["cmdsave"])){	
	$obj->Cate_ID=(int)$_POST['cbo_cata'];
	$obj->Title= stripslashes($_POST['txt_name']);
	$obj->Code= un_unicode(addslashes($_POST['txt_name']));
	$obj->Link=addslashes($_POST['txt_link']);
	$obj->isActive=(int)$_POST['opt_isactive'];
	$date=date('Y-m-d H:i:s');
	if(isset($_POST["txtthumb"]))
		$obj->Thumb=addslashes($_POST["txtthumb"]);

	if(isset($_POST['txtid'])){
		$obj->ID=$_POST['txtid'];
		$obj->Update();
	}else{
		$obj->Cdate=$date;
		$obj->addNew();
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=$_POST["txtids"];
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 		$obj->setActive($ids,1); 		break;
		case "unpublic": 	$obj->setActive($ids,0); 		break;
		case "delete": 		$obj->Delete($ids); 		break;
		case "edit": 	
		$id=explode("','",$ids);
		echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."/edit/id=".$id[0]."'</script>";
		break;
		case 'order':
		$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
		$obj->Order($ids,$sls); 	break;
	}
	echo "<script language=\"javascript\">window.location.href='".ROOTHOST_ADMIN.COMS."'</script>";
}

$task=$group_name='';
if(isset($_GET['task'])) $task=$_GET['task'];

$id=isset($_GET['id'])?(int)$_GET['id']:0;
$id=isset($_GET['cate'])?(int)$_GET['cate']:0;
if($id==0 && isset($_SESSION['GUIDE_ID_SELECTED'])){
	$id=(int)$_SESSION['GUIDE_ID_SELECTED'];
	$group_name=addslashes($_SESSION['GUIDENAME_SELECTED']);
}
?>
<div class="body">
	<div class='col-md-3'>
		<div class='row body_col_left bleft bright'>
			<div class="com_header color">
				<i class="fa fa-sitemap" aria-hidden="true"></i> Trợ giúp
			</div>
			<div class='user_group_list'><?php $obj_cate->getListCategory();?></div>
			<input type='hidden' id='group_selected' value='<?php echo $id;?>'/>
			<input type='hidden' id='group_selected_name' value=''/>
			<div class='user_group_func'>
				<ul class='menu'>
					<li class='cmd_group_add'><a href='javascript:void(0);' class='cgreen'><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm thư viện</a></li>
					<li class='cmd_group_edit'><a href='javascript:void(0);' ><i class="fa fa-edit" aria-hidden="true"></i> Sửa thư viện</a></li>
					<li class='cmd_group_del'><a href='javascript:void(0);' class='cred'><i class="fa fa-user-times" aria-hidden="true"></i> Xóa thư viện</a></li>
				</ul>
			</div>
			<div class='group_func'>
				<ul>
					<li class='func_edit'><a href='javascript:void(0);'>Sửa</a></li>
					<li class='func_del'><a href='javascript:void(0);'>Xóa</a></li>
					<li class='func_active'><a href='javascript:void(0);'>Hiện</a></li>
					<li class='func_deactive'><a href='javascript:void(0);'>Ẩn</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class='col-md-9 body_col_right'>
		<div id="list_content">
			<?php 
			if($task!='' && is_file(THIS_COM_PATH.'task/'.$task.'.php'))
				include_once(THIS_COM_PATH.'task/'.$task.'.php');
			else if($id==0) include_once(THIS_COM_PATH.'task/list.php');
			?>
		</div>
	</div>
</div>
<script>
	function Checked(id) {
		var arr=$('.user_group_list a');
		for(var i=0;i<arr.length;i++) {
			if($(arr[i]).attr('dataid')==id)
				$(arr[i]).addClass('checked');
			else $(arr[i]).removeClass('checked');
		}
	}
	function group_right_select(_item){
		var _gid=$(_item).attr('dataid'); 
		Checked(_gid);
		$('#group_selected').val(_gid);
		$('#group_selected_name').val($(_item).html());
	}
	function group_select(_item){
		var _gid=$(_item).attr('dataid'); 
		Checked(_gid);
		$('#group_selected').val(_gid);
		$('#group_selected_name').val($(_item).html());
		getUserByGroup(_gid,$(_item).html());
	}
	function getUserByGroup(gid,name){
		/*$.post("<?php echo ROOTHOST_ADMIN;?>ajaxs/<?php echo COMS;?>/getlist.php",{'id':gid,'group_name':name},function(data){
			$('#list_content').html(data);
		})*/
		window.location="<?php echo ROOTHOST_ADMIN;?>guide/cate_intro/"+gid;
	}
	function group_edit(){
		var _gid=$('#group_selected').val();
		if(_gid=='' || _gid==0) showMess('Bạn chưa chọn nhóm để sửa','error');
		else{
			$('#myModalPopup .modal-dialog').removeClass('modal-sm');
			$('#myModalPopup .modal-dialog').removeClass('modal-lg');
			$('#myModalPopup .modal-header .modal-title').html('Sửa nhóm');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/<?php echo COMS;?>/frm_add_group.php'; 
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
	}
	function group_del() {
		var _gid=$('#group_selected').val();
		if(_gid=='' || _gid==0) showMess('Bạn chưa chọn nhóm cần xóa','error');
		else{
			var _name=$('#group_selected_name').val();
			if(confirm("Bạn chắc chắn muốn xóa thư viện '"+_name+"' này?")){
				var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/<?php echo COMS;?>/del_group.php'; 
				$.get(url,{'id':_gid},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E02'){showMess('Không có quyền xóa nhóm này!','error');}
					$('.group_list').html(req);
				});
			}
		}
		return false;
	}
	function group_active(status){ 
		var _gid=$('#group_selected').val();
		if(_gid=='' || _gid==0) showMess('Vui lòng chọn nhóm','error');
		else{
			var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/<?php echo COMS;?>/active_group.php'; 
			$.get(url,{'id':_gid,'status':status},function(req){
				if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
				if(req=='E02'){showMess('Không có quyền thao tác!','error');}
				$('.group_list').html(req);
			});
		}
		return false;
	}

	$(document).ready(function(){
		<?php if($id>0) {?>
			Checked(<?php echo $id;?>);
			<?php if($task=='') { ?>
				getUserByGroup(<?php echo $id;?>,'<?php echo $group_name;?>');
				<?php } 
			}?>
			var body_h=$('.body_body').outerHeight();
			$('.body_body .body_col_left').css({'height':body_h+'px'});
			$('.cmd_group_add a').click(function(){
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').removeClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Thêm nhóm');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/<?php echo COMS;?>/frm_add_group.php'; 
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
				group_edit();
			});
			$('.cmd_group_del a').click(function(){
				group_del();
			});
			$('.group_list').on('contextmenu', function (e) {
				$('.group_func').css({"display":"block","top":(e.pageY-45)+"px","left":(e.pageX-65)+"px"});
			});
			$('.func_edit').click(function(){
				group_edit();
				$('.group_func').css({"display":"none"});
			})
			$('.func_del').click(function(){
				group_del();
				$('.group_func').css({"display":"none"});
			})
			$('.func_active').click(function(){
				group_active(1);
				$('.group_func').css({"display":"none"});
			})
			$('.func_deactive').click(function(){
				group_active(0);
				$('.group_func').css({"display":"none"});
			})
		})
	$(document).on({
		"click": function(e) {
			$('.group_func').css({"display":"none"});
		}
	})
</script>