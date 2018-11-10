<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$flag=false;
if(!isset($UserLogin)) $UserLogin=new CLS_USERS;
?>
<div class="body">
    <script language="javascript">
        function checkinput(){
            if($("#txtthumb").val()==""){
                $("#txt_thumb_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng chọn hình ảnh').fadeTo(900,1);
                });
                $("#txtthumb").focus();
                return false;
            }
            return true;
        }
    </script>
    <div class='row'>
        <div class="com_header color">
            <i class="fa fa-list" aria-hidden="true"></i> Thêm mới slide
            <div class="pull-right">
                <?php require_once("../global/libs/toolbar.php"); ?>
            </div>
        </div>
    </div><br>
    <div class="box-tabs">
        <form id="frm_action" name="frm_action" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <div class="col-md-6">
                        <div class='form-group'>
                            <label class="col-sm-2 control-label"><strong>Hình ảnh*</strong></label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="" placeholder='' />
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                                    </div>
                                    <div id="txt_thumb_err" class="mes-error"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 form-control-label">link</label>
                            <div class="col-sm-10">
                                <input type="text" name="txt_link" class="form-control" id="txt_link" placeholder="" value="">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Slogan</label>
                            <div class="col-sm-10">
                                <input type="text" name="txt_slogan" class="form-control" id="txt_slogan" value="">
                                <div id="txt_slogan_err" class="mes-error"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <label class="control-label">Mô tả</label>
                        <textarea name="txt_intro" id="txt_intro" class="form-control"></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
                </div>
            </div>
        </form>
    </div>
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
            $('#txt_intro').summernote({height: 150});
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
