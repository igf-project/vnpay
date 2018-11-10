<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
	$id=(int)$_GET["id"];
$obj->getList(' WHERE id='.$id);
$row=$obj->Fetch_Assoc();
?>
<style type="text/css">
	.form-horizontal .control-label{text-align: left;}
</style>
<div class="body">
	<script language="javascript">
		function checkinput(){	
			if($("#cbo_viewtype").val()=="block"){
				if($("#cbo_cate").val()=="0") {
					$("#category_err").fadeTo(200,0.1,function()
					{ 
						$(this).html('Vui lòng chọn một nhóm tin').fadeTo(900,1);
					});
					$("#cbo_cate").focus();
					return false;
				}
			}
			else if($("#cbo_viewtype").val()=="article"){
				if($("#cbo_article").val()=="0") {
					$("#article_err").fadeTo(200,0.1,function()
					{ 
						$(this).html('Vui lòng chọn một bài viết').fadeTo(900,1);
					});
					$("#cbo_article").focus();
					return false;
				}
			}

			else if($("#cbo_viewtype").val()=="cate_intro"){
				if($("#cbo_cate_intro").val()=="0") {
					$("#cate_intro_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một nhóm giới thiệu').fadeTo(900,1);
					});
					$("#cbo_cate_intro").focus();
					return false;
				}			
			}
			else if($("#cbo_viewtype").val()=="introduct"){
				if($("#cbo_introduct").val()=="0") {
					$("#introduct_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một bài giới thiệu').fadeTo(900,1);
					});
					$("#cbo_introduct").focus();
					return false;
				}			
			}

			else if($("#cbo_viewtype").val()=="cate_service"){
				if($("#cbo_cate_service").val()=="0") {
					$("#cate_service_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một nhóm SP & DV').fadeTo(900,1);
					});
					$("#cbo_cate_service").focus();
					return false;
				}			
			}
			else if($("#cbo_viewtype").val()=="service"){
				if($("#cbo_service").val()=="0") {
					$("#service_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một SP & DV').fadeTo(900,1);
					});
					$("#cbo_service").focus();
					return false;
				}			
			}

			else if($("#cbo_viewtype").val()=="cate_partner"){
				if($("#cbo_cate_partner").val()=="0") {
					$("#cate_partner_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một nhóm đối tác').fadeTo(900,1);
					});
					$("#cbo_cate_partner").focus();
					return false;
				}			
			}
			else if($("#cbo_viewtype").val()=="partner"){
				if($("#cbo_partner").val()=="0") {
					$("#partner_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một đối tác').fadeTo(900,1);
					});
					$("#cbo_partner").focus();
					return false;
				}			
			}

			else if($("#cbo_viewtype").val()=="document_type"){
				if($("#cbo_document_type").val()=="0") {
					$("#document_type_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một nhóm tài liệu').fadeTo(900,1);
					});
					$("#cbo_document_type").focus();
					return false;
				}			
			}
			else if($("#cbo_viewtype").val()=="document"){
				if($("#cbo_document").val()=="0") {
					$("#document_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một tài liệu').fadeTo(900,1);
					});
					$("#cbo_document").focus();
					return false;
				}			
			}

			else if($("#cbo_viewtype").val()=="question_group"){
				if($("#cbo_question_group").val()=="0") {
					$("#question_group_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một nhóm câu hỏi').fadeTo(900,1);
					});
					$("#cbo_question_group").focus();
					return false;
				}			
			}
			else if($("#cbo_viewtype").val()=="question"){
				if($("#cbo_question").val()=="0") {
					$("#question_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một câu hỏi').fadeTo(900,1);
					});
					$("#cbo_question").focus();
					return false;
				}			
			}

			else if($("#cbo_viewtype").val()=="cate_guide"){
				if($("#cbo_cate_guide").val()=="0") {
					$("#cate_guide_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một nhóm trợ giúp').fadeTo(900,1);
					});
					$("#cbo_cate_guide").focus();
					return false;
				}			
			}
			else if($("#cbo_viewtype").val()=="guide"){
				if($("#cbo_guide").val()=="0") {
					$("#guide_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một bài viết trợ giúp').fadeTo(900,1);
					});
					$("#cbo_guide").focus();
					return false;
				}			
			}
			

			else if($("#cbo_viewtype").val()=="cate_recruitment"){
				if($("#cbo_cate_recruitment").val()=="0") {
					$("#cate_recruitment_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng chọn một nhóm tuyển dụng').fadeTo(900,1);
					});
					$("#cbo_cate_recruitment").focus();
					return false;
				}			
			}
			else if($("#cbo_viewtype").val()=="recruitment"){
				if($("#cbo_recruitment").val()=="0") {
					$("#recruitment_err").fadeTo(200,0.1,function()
					{ 
						$(this).html('Vui lòng chọn một bài viết tuyển dụng').fadeTo(900,1);
					});
					$("#cbo_recruitment").focus();
					return false;
				}
			}

			else if($("#cbo_viewtype").val()=="link"){
				if($("#txtlink").val()=="" || $("#txtlink").val()=="http://" ) {
					$("#link_err").fadeTo(200,0.1,function()
					{ 
						$(this).html('Vui lòng nhập đường dẫn đến bài viết').fadeTo(900,1);
					});
					$("#txtlink").focus();
					return false;
				}
			}

			if($("#txtname").val()==""){
				$("#txtname_err").fadeTo(200,0.1,function()
				{ 
					$(this).html('Vui lòng nhập tên').fadeTo(900,1);
				});
				$("#txtname").focus();
				return false;
			}
			return true;
		}

		$(document).ready(function(){
			$("#txtname").blur(function() {
				if( $(this).val()=='') {
					$("#txtname_err").fadeTo(200,0.1,function(){ 
						$(this).html('Vui lòng nhập tên').fadeTo(900,1);
					});
				}
				else {
					$("#txtname_err").fadeTo(200,0.1,function()
					{ 
						$(this).html('').fadeTo(900,1);
					});
				}
			})
		})

		function select_type(){
			var txt_viewtype=document.getElementById("txt_viewtype");
			var cbo_viewtype=document.getElementById("cbo_viewtype");
			for(i=0;i<cbo_viewtype.length;i++){
				if(cbo_viewtype[i].selected==true)
					txt_viewtype.value=cbo_viewtype[i].value;
			}
			document.frm_type.submit();
		}
	</script>
	<?php
	$viewtype="block";
	if(isset($_POST["txt_viewtype"])){
		$viewtype=addslashes($_POST["txt_viewtype"]);
	}
	else{
		$viewtype = $row['viewtype'];
	}
	?>
	<div class='row'>
		<div class="com_header color">
			<i class="fa fa-list" aria-hidden="true"></i> Sửa menuitem
			<div class="pull-right">
				<?php require_once("../global/libs/toolbar.php"); ?>
			</div>
		</div>
	</div><br>
	<form id="frm_type" name="frm_type" method="post" action="" style="display:none;">
		<input type="text" name="txt_viewtype" id="txt_viewtype" />
	</form>
	<form id="frm_action" name="frm_action" method="post" action=""> 
		<p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
		<fieldset>
			<legend><strong>Kiểu hiển thị:</strong></legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Kiểu hiển thị*</label>
						<div class="col-sm-9">
							<select name="cbo_viewtype" id="cbo_viewtype" class="form-control" onchange="select_type();">
								<option value="link" selected="selected">Links</option>
								<option value="block">Nhóm tin tức</option>
								<option value="article">Bài viết tin tức</option>
								<option value="cate_intro">Nhóm giới thiệu</option>
								<option value="introduct">Bài viết giới thiệu</option>
								<option value="cate_service">Nhóm sản phẩm & Dịch vụ</option>
								<option value="service">Sản phẩm & Dịch vụ</option>
								<option value="cate_partner">Nhóm đối tác</option>
								<option value="partner">Đối tác</option>
								<option value="document_type">Nhóm tài liệu</option>
								<option value="document">Tài liệu</option>
								<option value="question_group">Nhóm hỏi đáp</option>
								<option value="question">Hỏi đáp</option>
								<option value="cate_guide">Nhóm trợ giúp</option>
								<option value="guide">Trợ giúp</option>
								<option value="cate_recruitment">Nhóm tuyển dụng</option>
								<option value="recruitment">Tuyển dụng</option>
								<script language="javascript">
									cbo_Selected('cbo_viewtype','<?php echo $viewtype;?>');
								</script>
							</select>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>

				<?php if($viewtype=="block"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Nhóm tin*</label>
						<div class="col-sm-9">
							<select name="cbo_cate" id="cbo_cate" class="form-control">
								<option value="0" title="Top">Chọn một nhóm tin</option>
								<?php $obj_cate->getListCate(0,0); ?>
							</select>
							<script type="text/javascript">
								cbo_Selected('cbo_cate','<?php echo $row['cate_id'];?>');
								$(document).ready(function() {
									$("#cbo_cate").select2();
								});
							</script>
							<font id="category_err" class="check_error" color="red"></font>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="article"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Bài viết*</label>
						<div class="col-sm-9">
							<select name="cbo_article" id="cbo_article" class="form-control">
								<option value="0" title="N/A">Chọn một bài viết</option>
								<?php $obj_con->LoadConten(); ?>
								<script language="javascript">
									cbo_Selected('cbo_article','0');
								</script>
							</select>
							<font id="article_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_article','<?php echo $row['con_id'];?>');
								$(document).ready(function() {
									$("#cbo_article").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<?php }else if($viewtype=="cate_service"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nhóm SP & DV <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_cate_service" id="cbo_cate_service" class="form-control" style="width:100%;">
								<option value="0" title="Top">Chọn một nhóm SP & DV</option>
								<?php 
								include_once('libs/cls.cate_service.php');
								$objCateService = new CLS_CATE_SERVICE();
								$objCateService->getListCate(0,0);
								?>
							</select>
							<script type="text/javascript">
								cbo_Selected('cbo_cate_service','<?php echo $row['cate_service_id'];?>');
								$(document).ready(function() {
									$("#cbo_cate_service").select2();
								});
							</script>
							<font id="cate_service_err" class="check_error" color="red"></font>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="service"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">SP & DV*</label>
						<div class="col-sm-9">
							<select name="cbo_service" id="cbo_service" class="form-control" style="width: 100%;">
								<option value="0" title="N/A">Chọn một SP & DV</option>
								<?php 
								include_once('libs/cls.service.php');
								$objService = new CLS_SERVICE();
								$objService->LoadConten();
								?>
							</select>
							<font id="service_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_service','<?php echo $row['service_id'];?>');
								$(document).ready(function() {
									$("#cbo_service").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<?php } else if($viewtype=="cate_intro"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nhóm giới thiệu*</label>
						<div class="col-sm-9">
							<select name="cbo_cate_intro" id="cbo_cate_intro" style="width: 100%;">
								<option value="0" title="Top">Chọn một nhóm giới thiệu</option>
								<?php 
								include_once('libs/cls.cate_intro.php');
								$objCateIntro = new CLS_CATEGORY_INTRO();
								$objCateIntro->getListCate(0,0);
								?>
							</select> 
							<font id="cate_intro_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_cate_intro','<?php echo $row['cate_intro_id'];?>');
								$(document).ready(function() {
									$("#cbo_cate_intro").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="introduct"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Bài viết giới thiệu*</label>
						<div class="col-sm-9">
							<select name="cbo_introduct" id="cbo_introduct" class="form-control" style="width: 100%;">
								<option value="0" title="N/A">Chọn một bài viết</option>
								<?php 
								include_once('libs/cls.introduct.php');
								$objIntroduct = new CLS_INTRODUCT();
								$objIntroduct->LoadConten();
								?>
							</select>
							<font id="introduct_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_introduct','<?php echo $row['introduct_id'];?>');
								$(document).ready(function() {
									$("#cbo_introduct").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<?php }else if($viewtype=="cate_partner"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nhóm đối tác <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_cate_partner" id="cbo_cate_partner" class="form-control" style="width:100%;">
								<option value="0" title="Top">Chọn một nhóm đối tác</option>
								<?php 
								include_once('libs/cls.cate_partner.php');
								$objCatePartner = new CLS_CATE_PARTNER();
								$objCatePartner->getListCate(0,0);
								?>
							</select>
							<script type="text/javascript">
								cbo_Selected('cbo_cate_partner','<?php echo $row['cate_partner_id'];?>');
								$(document).ready(function() {
									$("#cbo_cate_partner").select2();
								});
							</script>
							<font id="cate_partner_err" class="check_error" color="red"></font>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="partner"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Đối tác <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_partner" id="cbo_partner" class="form-control" style="width: 100%;">
								<option value="0" title="N/A">Chọn một đối tác</option>
								<?php 
								include_once('libs/cls.partner.php');
								$objPartner = new CLS_PARTNER();
								$objPartner->LoadConten();
								?>
							</select>
							<font id="partner_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_partner','<?php echo $row['partner_id'];?>');
								$(document).ready(function() {
									$("#cbo_partner").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<?php }else if($viewtype=="document_type"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nhóm tài liệu <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_document_type" id="cbo_document_type" class="form-control" style="width:100%;">
								<option value="0" title="Top">Chọn một nhóm tài liệu</option>
								<?php 
								include_once('libs/cls.document_type.php');
								$objDocumentType = new CLS_DOCUMENT_TYPE();
								$objDocumentType->getListDocType(0,0);
								?>
							</select>
							<script type="text/javascript">
								cbo_Selected('cbo_document_type','<?php echo $row['gdoc_id'];?>');
								$(document).ready(function() {
									$("#cbo_document_type").select2();
								});
							</script>
							<font id="document_type_err" class="check_error" color="red"></font>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="document"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tài liệu <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_document" id="cbo_document" class="form-control" style="width: 100%;">
								<option value="0" title="N/A">Chọn một tài liệu</option>
								<?php 
								include_once('libs/cls.document.php');
								$objDocument = new CLS_DOCUMENT();
								$objDocument->LoadConten();
								?>
							</select>
							<font id="document_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_document','<?php echo $row['doc_id'];?>');
								$(document).ready(function() {
									$("#cbo_document").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<?php } else if($viewtype=="question_group"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nhóm hỏi đáp*</label>
						<div class="col-sm-9">
							<select name="cbo_question_group" id="cbo_question_group" style="width: 100%;">
								<option value="0" title="Top">Chọn một nhóm hỏi đáp</option>
								<?php 
								include_once('libs/cls.question_group.php');
								$objQuestionGroup = new CLS_QUESTION_GROUP();
								$objQuestionGroup->getListCate(0,0);
								?>
							</select> 
							<font id="question_group_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_question_group','<?php echo $row['question_group_id'];?>');
								$(document).ready(function() {
									$("#cbo_question_group").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="question"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tài liệu <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_question" id="cbo_question" class="form-control" style="width: 100%;">
								<option value="0" title="N/A">Chọn một tài liệu</option>
								<?php 
								include_once('libs/cls.question.php');
								$objQuestion = new CLS_QUESTION();
								$objQuestion->LoadConten();
								?>
							</select>
							<font id="question_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_question','<?php echo $row['question_id'];?>');
								$(document).ready(function() {
									$("#cbo_question").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<?php } else if($viewtype=="cate_guide"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nhóm trợ giúp*</label>
						<div class="col-sm-9">
							<select name="cbo_cate_guide" id="cbo_cate_guide" style="width: 100%;">
								<option value="0" title="Top">Chọn một nhóm trợ giúp</option>
								<?php 
								include_once('libs/cls.cate_guide.php');
								$objCateGuide = new CLS_CATEGORY_GUIDE();
								$objCateGuide->getListCate(0,0);
								?>
							</select> 
							<font id="cate_guide_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_cate_guide','<?php echo $row['cate_guide_id'];?>');
								$(document).ready(function() {
									$("#cbo_cate_guide").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="guide"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Bài viết trợ giúp <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_guide" id="cbo_guide" class="form-control" style="width: 100%;">
								<option value="0" title="N/A">Chọn một bài viết trợ giúp</option>
								<?php 
								include_once('libs/cls.guide.php');
								$objGuide = new CLS_GUIDE();
								$objGuide->LoadConten();
								?>
							</select>
							<font id="guide_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_guide','<?php echo $row['guide_id'];?>');
								$(document).ready(function() {
									$("#cbo_guide").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>


				<?php } else if($viewtype=="cate_recruitment"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nhóm tuyển dụng*</label>
						<div class="col-sm-9">
							<select name="cbo_cate_recruitment" id="cbo_cate_recruitment" style="width: 100%;">
								<option value="0" title="Top">Chọn một nhóm tuyển dụng</option>
								<?php 
								include_once('libs/cls.cate_recruitment.php');
								$objCateRecruitment = new CLS_CATEGORY_RECRUITMENT();
								$objCateRecruitment->getListCate(0,0);
								?>
							</select> 
							<font id="cate_recruitment_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								$(document).ready(function() {
									cbo_Selected('cbo_cate_recruitment','<?php echo $row['cate_recruitment_id'];?>');
									$("#cbo_cate_recruitment").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } else if($viewtype=="recruitment"){?>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">Bài viết tuyển dụng <font color="red">*</font></label>
						<div class="col-sm-9">
							<select name="cbo_recruitment" id="cbo_recruitment" class="form-control" style="width: 100%;">
								<option value="0" title="N/A">Chọn một bài viết tuyển dụng</option>
								<?php 
								include_once('libs/cls.recruitment.php');
								$objRecruitment = new CLS_RECRUITMENT();
								$objRecruitment->LoadConten();
								?>
							</select>
							<font id="recruitment_err" class="check_error" color="red"></font>
							<script type="text/javascript">
								cbo_Selected('cbo_recruitment','<?php echo $row['recruitment_id'];?>');
								$(document).ready(function() {
									$("#cbo_recruitment").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				
				<?php } else { ?>
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Link*</label>
						<div class="col-sm-9">
							<input name="txtlink" type="text" id="txtlink" class="form-control" value="<?php echo $row['link'];?>" placeholder="http://"/>
							<font id="link_err" class="check_error" color="red"></font>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php }?>
			</div>
		</fieldset>
		<fieldset>
			<legend><strong>Chi tiết:</strong></legend>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Tên*</label>
						<div class="col-sm-9">
							<input name="txtname" type="text" id="txtname" value="<?php echo $row['name'];?>" class="form-control">
							<font id="txtname_err" class="check_error" color="red"></font>
							<input type="hidden" name="txtid" id="txtid" value="<?php echo $row['id'];?>">
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Danh mục cha</label>
						<div class="col-sm-9">
							<select name="cbo_parid" id="cbo_parid" class="form-control" style="width: 100%;">
								<option value="0">Top</option>
								<?php echo $obj->getListMenuItem($mnuid,0,0); ?>
							</select>
							<script type="text/javascript">
								cbo_Selected('cbo_parid','<?php echo $row['par_id'];?>');
								$(document).ready(function() {
									$("#cbo_parid").select2();
								});
							</script>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Class</label>
						<div class="col-sm-9">
							<input type="text" name="txtclass" id="txtclass" value="<?php echo $row['class'];?>" class="form-control"/>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="col-sm-3 form-control-label">Hiển thị</label>
						<div class="col-sm-9">
							<label class="radio-inline"><input name="optactive" type="radio" id="radio" value="1" <?php if($obj->isActive==1) echo "checked";?>>Có</label>
							<label class="radio-inline"><input name="optactive" type="radio" id="radio2" value="0" <?php if($obj->isActive==0) echo "checked";?>>Không</label>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend><strong>Mô tả:</strong></legend>
			<textarea name="txtdesc" id="txtdesc" rows="5"><?php echo $obj->Intro;?></textarea>
			<input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
		</fieldset>
	</form>
</div>
<script>
    var ComponentsEditors = function () {
        var handleWysihtml5 = function () {
            if (!jQuery().wysihtml5) {
                return;
            }
            if ($('.wysihtml5').size() > 0) {
                $('.wysihtml5').wysihtml5({
                    "stylesheets": ["global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
                });
            }
        }
        var handleSummernote = function () {
            $('#txtdesc').summernote({height: 150});
        }
        return {
            //main function to initiate the module
            init: function () {
                handleWysihtml5();
                handleSummernote();
            }
        }
    }();
    $(document).ready(function(){
        ComponentsEditors.init();
    })
</script>