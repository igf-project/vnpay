<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"])) $id=(int)$_GET["id"];
$obj->getList(' AND `id`='.$id);
$row=$obj->Fetch_Assoc();
$id=$row['id'];
$type_id=$row['type_id'];
$name=$row['name'];
$code=$row['code'];
$url=$row['url'];
$fullurl=$row['fullurl'];
$author=$row['author'];
$filetype=$row['filetype'];
$filesize=$row['filesize'];
$cdate=date("d-m-Y ",$row['cdate']);
$link=ROOTHOST.'tai-lieu/'.$code.'/'.$id.'.html';
?>

<script language="javascript">
	function checkinput(){
		if($("#txttitle").val()==""){
			$("#txttitle_err").fadeTo(200,0.1,function()
			{ 
				$(this).html('Vui lòng nhập tên tài liệu').fadeTo(900,1);
			});
			$("#txttitle").focus();
			return false;
		}
		return true;
	}
	$(document).ready(function() {
		$("#txttitle").blur(function(){
			if ($("#txttitle").val()=="") {
				$("#txttitle_err").fadeTo(200,0.1,function()
				{ 
					$(this).html('Vui lòng nhập tên tài liệu').fadeTo(900,1);
				});
			}
		});
	});
</script>
<div class='row'>
	<div class="com_header color">
		<i class="fa fa-list" aria-hidden="true"></i> Sửa nhóm tài liệu
		<div class="pull-right">
			<?php require_once("../global/libs/toolbar.php"); ?>
		</div>
	</div>
</div><br>
<div class="box-tabs">
	<ul class="nav nav-tabs" role="tablist">
		<li class="active">
			<a href="#info" role="tab" data-toggle="tab">
				Thông tin
			</a>
		</li>
	</ul><br>
	<form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
		<input name="txtid" type="hidden" value="<?php echo $id; ?>"/>
		<input name="filetype" type="hidden" id="filetype" value=""/>
		<input name="filesize" type="hidden" id="filesize" value=""/>
		<input name="txttask" type="hidden" id="txttask" value="1" />
		<div class="tab-content">
			<div class="tab-pane fade active in" id="info">
				<p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label">Nhóm tài liệu <span class="cred">*</span></label>
					<div class="col-sm-9 col-md-10">
						<select name="cbo_group" id="cbo_group" class="form-control">
							<option value="0" selected="selected">Root</option>
							<?php
							if(!isset($objdoctype))
								$objdoctype=new CLS_DOCUMENT_TYPE();
							$objdoctype->ListDocumentType(0,0,0,1);
							?>
							<script language="javascript">
								cbo_Selected('cbo_group',<?php echo $type_id;?>);
							</script>
						</select>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label">Tác giả</label>
					<div class="col-sm-9 col-md-10">
						<input name="txtauthor" type="text" class="form-control" id="txtauthor" value="<?php echo $author;?>" readonly/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label">Tên tài liệu</label>
					<div class="col-sm-9 col-md-10">
						<input name="txttitle" type="text" class="form-control" value="<?php echo $row['name'] ?>" id="txttitle" required/>
						<font id="txttitle_err" color="red"></font>
					</div>
				</div>
				<div class='form-group'>
					<label class="col-sm-3 col-md-2 control-label">File upload</label>
					<div class="col-sm-9 col-md-10">
						<div class="row">
							<div class="col-sm-9">
								<input name="txturl" type="text" id="txturl" class='form-control' value="<?php echo $fullurl;?>"/>
							</div>
							<div class="col-sm-3">
								<a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_document.php');"><b style="margin-top: 15px">Chọn</b></a>
							</div>
							<div id="txt_thumb_err" class="mes-error"></div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 col-md-2 control-label">Hiển thị</label>
					<div class="col-sm-9 col-md-10">
						<label class="radio-inline"><input type="radio" value="1" name="optactive" <?php if($row['isactive']==1) echo 'checked';?>>Có</label>
						<label class="radio-inline"><input type="radio" value="0" name="optactive" <?php if($row['isactive']==0) echo 'checked';?>>Không</label>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
		</div>
		<input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
		<input type='hidden' name='txt_action' id='txt_action'/>
	</form>
</div>
