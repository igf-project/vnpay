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
                $(this).html('Vui lòng nhập tên đối tác').fadeTo(900,1);
            });
            $("#txt_name").focus();
            return false;
        }
        return true;
    }
</script>

<div class='row'>
    <div class="com_header color">
        <i class="fa fa-list" aria-hidden="true"></i> Thêm mới đối tác
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
        <div class="tab-content">
            <div class="tab-pane fade active in" id="info">
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label">Nhóm đối tác <span class="cred">*</span></label>
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
                    <label class="col-sm-3 col-md-2 control-label">Tên đối tác <span class="cred">*</span></label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" required>
                        <div id="txt_name_err" class="mes-error"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label">Link <span class="cred">*</span></label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" name="txt_link" class="form-control" id="txt_link" placeholder="" required>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class='form-group'>
                    <label class="col-sm-3 col-md-2 control-label">Ảnh</label>
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
                    <label class="col-sm-2 control-label">Hiển thị <span class="cred">*</span></label>
                    <div class="col-sm-4">
                        <label class="radio-inline"><input type="radio" value="1" name="opt_isactive" checked>Có</label>
                        <label class="radio-inline"><input type="radio" value="0" name="opt_isactive">Không</label>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var body_h=$('.body_body').outerHeight();
        $('.body_body .body_col_left').css({'height':body_h+'px'});
        $(".sl_user").select2();
        $(".sl_user1").select2();
    })
</script>
