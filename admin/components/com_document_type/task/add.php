<?php
defined("ISHOME") or die("Can't acess this page, please come back!")
?>
<div class='body_col_right'>
	<div class='row'>
		<div class="com_header color">
			<i class="fa fa-list" aria-hidden="true"></i> Thêm mới nhóm tài liệu
			<div class="pull-right">
				<?php require_once("../global/libs/toolbar.php"); ?>
			</div>
		</div>
	</div><br>
	<div id="action">
		<script language="javascript">
			function checkinput(){
				if($("#txttitle").val()==""){
					$("#txttitle_err").fadeTo(200,0.1,function()
					{ 
						$(this).html('Vui lòng nhập tên nhóm tài liệu').fadeTo(900,1);
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
							$(this).html('Vui lòng nhập tên nhóm tài liệu').fadeTo(900,1);
						});
					}
				});
			});
		</script>
		<div class="box-tabs">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active">
					<a href="#info" role="tab" data-toggle="tab">
						Thông tin
					</a>
				</li>
			</ul><br>
			<form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
				<div class="tab-content">
					<div class="tab-pane fade active in" id="info">
						<p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
						<div class="form-group">
							<label class="col-sm-3 col-md-2 control-label">Tên nhóm tài liệu <span class="cred">*</span></label>
							<div class="col-sm-9 col-md-10">
								<input type="text" name="txttitle" class="form-control" id="txttitle" placeholder="" required>
								<div id="txttitle_err" class="mes-error"></div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-2 control-label">Root <span class="cred">*</span></label>
							<div class="col-sm-9 col-md-10">
								<select name="cbo_doctype" id="cbo_doctype" class="form-control">
									<option value="0" selected="selected">Root</option>
									<?php
									if(!isset($objdoctype))
										$objdoctype=new CLS_DOCUMENT_TYPE();
									$objdoctype->ListDocumentType(0,0,0,1);
									?>
									<script language="javascript">
										cbo_Selected('cbo_doctype','');
									</script>
								</select>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-2 control-label">Hiển thị</label>
							<div class="col-sm-9 col-md-10">
								<label class="radio-inline"><input type="radio" value="1" name="optactive" checked>Có</label>
								<label class="radio-inline"><input type="radio" value="0" name="optactive">Không</label>
							</div>
							<div class="clearfix"></div>
						</div>
					</div> 
				</div> 
				<input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
			</form>
		</div>
	</div>
</div>