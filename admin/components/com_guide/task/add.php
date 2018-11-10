<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<style type="text/css">
    .form-horizontal .control-label{text-align: left;}
</style>

<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tên bài trợ giúp').fadeTo(900,1);
            });
            $("#txt_name").focus();
            return false;
        }
        return true;
    }
</script>

<div class='row'>
    <div class="com_header color">
        <i class="fa fa-list" aria-hidden="true"></i> Thêm mới bài trợ giúp
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
        <li>
            <a href="#seo" role="tab" data-toggle="tab">
                Seo
            </a>
        </li>
    </ul><br>
    <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
        <div class="tab-content">
            <div class="tab-pane fade active in" id="info">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label">Nhóm trợ giúp <span class="cred">*</span></label>
                    <div class="col-sm-9 col-md-10">
                        <select class="form-control" id="cbo_cata" name="cbo_cata" style="width: 100%" required>
                            <option value="">Root</option>
                            <?php $obj_cate->getListCate(0,0); ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#cbo_cata").select2();
                            });
                        </script>
                        <div id="txt_cata_err" class="mes-error"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label">Tiêu đề <span class="cred">*</span></label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" required>
                        <div id="txt_name_err" class="mes-error"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class='form-group'>
                    <label class="col-sm-3 col-md-2 control-label">Ảnh đại diện</label>
                    <div class="col-sm-9 col-md-10">
                        <div class="row">
                            <div class="col-sm-9">
                                <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="" placeholder='' />
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                            </div>
                            <div id="txt_thumb_err" class="mes-error"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label">Tác giả <span class="cred">*</span></label>
                    <div class="col-sm-4">
                        <input type="text" name="txt_author" value="<?php echo $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['username']; ?>" class="form-control" id="txt_author" readonly placeholder="">
                    </div>

                    <label class="col-sm-2 control-label">Hiển thị <span class="cred">*</span></label>
                    <div class="col-sm-4">
                        <label class="radio-inline"><input type="radio" value="1" name="opt_isactive" checked>Có</label>
                        <label class="radio-inline"><input type="radio" value="0" name="opt_isactive">Không</label>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-2"> Tóm tắt</label>
                    <div class="col-md-12">
                        <textarea name="txt_intro" id="txt_intro" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 col-md-2"> Nội dung</label>
                    <div class="col-md-12">
                        <textarea name="txt_fulltext" id="txt_fulltext" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="seo">
                <div class='form-group'>
                    <label class="col-sm-3 control-label"><strong>Mô tả tiêu đề</strong></label>
                    <div class="col-sm-9">
                        <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="" placeholder='' />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class='form-group'>
                    <label class="col-sm-3 control-label"><strong>Từ khóa</strong></label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"></textarea>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class='form-group'>
                    <label class="col-sm-3 control-label"><strong>Description</strong></label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"></textarea>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
        </div>
    </form>
</div>

<script type="text/javascript">
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
            $('#txt_intro').summernote({height: 80});
            $('#txt_fulltext').summernote({height: 150});
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
        var body_h=$('.body_body').outerHeight();
        $('.body_body .body_col_left').css({'height':body_h+'px'});
        $(".sl_user").select2();
        $(".sl_user1").select2();
    })
</script>
