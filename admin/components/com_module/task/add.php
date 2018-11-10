<?php
defined("ISHOME") or die("Can't acess this page, please come back!")
?>
<div class="body">
    <script language="javascript">
        function checkinput(){
            if($('#txttitle').val()=="") {
                $("#txttitle_err").fadeTo(200,0.1,function(){ 
                    $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
                });
                $('#txttitle').focus();
                return false;
            }
            if( $('#cbo_type').val()=="mainmenu") {
                if($('#cbo_menutype').val()=="") {
                    $("#menutype_err").fadeTo(200,0.1,function(){ 
                        $(this).html('Mời chọn kiểu Menu cần hiển thị').fadeTo(900,1);
                    });
                    $('#cbo_menutype').focus();
                    return false;
                }
            }
            return true;
        }
        function select_type(){
            var txt_viewtype=document.getElementById("txt_type");
            var cbo_viewtype=document.getElementById("cbo_type");
            for(i=0;i<cbo_viewtype.length;i++){
                if(cbo_viewtype[i].selected==true)
                    txt_viewtype.value=cbo_viewtype[i].value;
            }
            document.frm_type.submit();
        }

        $(document).ready(function() {
            $('#txttitle').blur(function(){
                if($(this).val()=="") {
                    $("#txttitle_err").fadeTo(200,0.1,function(){ 
                        $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
                    });
                    $('#txttitle').focus();
                }
            })
        });
    </script>
    <?php
    $viewtype="mainmenu";
    if(isset($_POST["txt_type"]))
        $viewtype=$_POST["txt_type"];
    ?>
    <div class='row'>
        <div class="com_header color">
            <i class="fa fa-list" aria-hidden="true"></i> Thêm mới Module
            <div class="pull-right">
                <?php require_once("../global/libs/toolbar.php"); ?>
            </div>
        </div>
    </div><br>
    <form id="frm_type" name="frm_type" method="post" action="" style="display:none;">
        <input type="text" name="txt_type" id="txt_type" />
    </form>
    <form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
        <p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
        <fieldset>
            <legend><strong>Chi tiết:</strong></legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kiểu hiển thị*</label>
                        <div class="col-sm-9">
                            <select name="cbo_type" class="form-control" id="cbo_type" onchange="select_type();" style="width: 100%;">
                                <?php 
                                $obj->LoadModType();?>
                                <script language="javascript">
                                    cbo_Selected('cbo_type','<?php echo $viewtype;?>');
                                    $(document).ready(function() {
                                        $("#cbo_type").select2();
                                    });
                                </script>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tiêu đề*</label>
                        <div class="col-sm-9">
                            <input name="txttitle" type="text" id="txttitle" class="form-control" value="">
                            <span id="txttitle_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hiển thị tiêu đề</label>
                        <div class="col-sm-9">
                            <label class="radio-inline"><input type="radio" name="optviewtitle" value="1">Có</label>
                            <label class="radio-inline"><input type="radio" name="optviewtitle" value="0" checked>Không</label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vị trí</label>
                        <div class="col-sm-9">
                            <select name="cbo_position" class="form-control" id="cbo_position" style="width: 100%;">
                                <?php LoadPosition();?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_position").select2();
                                });
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Class</label>
                        <div class="col-sm-9">
                            <input type="text" name="txtclass" id="txtclass" class="form-control" value="" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hiển thị</label>
                        <div class="col-sm-9">
                            <label class="radio-inline"><input type="radio" name="optactive" value="1" checked>Có</label>
                            <label class="radio-inline"><input type="radio" name="optactive" value="0">Không</label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </fieldset>
        <?php 
        $arr_type=array('mainmenu','html','news','service','guide','document','question','introduce','slide');
        if(in_array($viewtype,$arr_type)){ ?>
        <fieldset>
            <legend><strong>Parameter:</strong></legend>
            <div class="row">
                <?php if($viewtype=="mainmenu"){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Menu</label>
                        <div class="col-sm-9">
                            <select name="cbo_menutype" class="form-control" id="cbo_menutype">
                                <option value="all">Select once menu</option>
                                <?php echo $objmenu->getListmenu("option"); ?>
                            </select>
                            <span id="menutype_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }else if($viewtype=="news"){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nhóm tin</label>
                        <div class="col-sm-9">
                            <select name="cbo_cate" class="form-control" id="cbo_cate" style="width: 100%;">
                                <option value="0">Chọn một nhóm tin</option>
                                <?php
                                if(!isset($objCate)) $objCate=new CLS_CATEGORY();
                                $objCate->getListCate(0,0);
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_cate").select2();
                                });
                            </script>
                            <span id="category_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }else if($viewtype=="service"){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SP & DV</label>
                        <div class="col-sm-9">
                            <select name="cbo_cate_service" class="form-control" id="cbo_cate_service" style="width: 100%;">
                                <option value="0">Chọn một nhóm SP & DV</option>
                                <?php
                                include_once('libs/cls.cate_service.php');
                                $objCateService = new CLS_CATE_SERVICE();
                                $objCateService->getListCate(0,0);
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_cate_service").select2();
                                });
                            </script>
                            <span id="cate_service_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }else if($viewtype=="guide"){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nhóm trợ giúp</label>
                        <div class="col-sm-9">
                            <select name="cbo_cate_guide" class="form-control" id="cbo_cate_guide" style="width: 100%;">
                                <option value="0">Chọn một nhóm trợ giúp</option>
                                <?php
                                include_once('libs/cls.cate_guide.php');
                                $objCateGuide = new CLS_CATEGORY_GUIDE();
                                $objCateGuide->getListCate(0,0);
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_cate_guide").select2();
                                });
                            </script>
                            <span id="cate_guide_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }else if($viewtype=="document"){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nhóm tài liệu</label>
                        <div class="col-sm-9">
                            <select name="cbo_document_type" class="form-control" id="cbo_document_type" style="width: 100%;">
                                <option value="0">Chọn một nhóm tài liệu</option>
                                <?php
                                include_once('libs/cls.document_type.php');
                                $objDocumentType = new CLS_DOCUMENT_TYPE();
                                $objDocumentType->getListDocType(0,0);
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_document_type").select2();
                                });
                            </script>
                            <span id="document_type_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }else if($viewtype=="question"){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nhóm hỏi đáp</label>
                        <div class="col-sm-9">
                            <select name="cbo_question_group" class="form-control" id="cbo_question_group" style="width: 100%;">
                                <option value="0">Chọn một nhóm hỏi đáp</option>
                                <?php
                                include_once('libs/cls.question_group.php');
                                if(!isset($objQuestionGroup)) $objQuestionGroup=new CLS_QUESTION_GROUP();
                                $objQuestionGroup->getListCate(0,0);
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_question_group").select2();
                                });
                            </script>
                            <span id="question_group_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }else if($viewtype=="introduce"){?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nhóm tin</label>
                        <div class="col-sm-9">
                            <select name="cbo_cate_intro" class="form-control" id="cbo_cate_intro" style="width: 100%;">
                                <option value="0">Chọn một nhóm tin</option>
                                <?php
                                include_once('libs/cls.cate_intro.php');
                                if(!isset($objCateIntro)) $objCateIntro=new CLS_CATEGORY_INTRO();
                                $objCateIntro->getListCate(0,0);
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_cate_intro").select2();
                                });
                            </script>
                            <span id="cate_intro_err" class="check_error"></span>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php }else if($viewtype=="html"){?>
                <div class="col-sm-12">
                    <div class="form-group">
                        <textarea name="txtcontent" id="txtcontent" class="form-control"></textarea>
                    </div>
                </div>
                <?php } else {};?>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Giao diện</label>
                        <div class="col-sm-9">
                            <select name="cbo_theme" class="form-control" id="cbo_theme" style="width: 100%;">
                                <option value="">Select once theme</option>
                                <?php LoadModBrow("mod_".$viewtype);?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#cbo_theme").select2();
                                });
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php } ?>
        <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
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
            $('#txtcontent').summernote({height: 150});
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