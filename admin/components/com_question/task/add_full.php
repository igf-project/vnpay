<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<style type="text/css">
    .form-horizontal .control-label{text-align: left;}
</style>
<div class="body">
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên bài viết').fadeTo(900,1);
                });
                $("#txt_name").focus();
                return false;
            }
            return true;
        }
    </script>
    <div class='col-md-3'>
        <div class='row body_col_left bleft bright'>
            <div class="com_header color">
                <i class="fa fa-sitemap" aria-hidden="true"></i> <a href="<?php echo ROOTHOST_ADMIN.COMS?>" title="Tin tức">Tin tức</a>
            </div>
            <input type='hidden' id='guser_selected' value=''/>
            <div class='user_group_list'>
                <?php $obj_cate->getListCategory();?>
            </div>
            <div class='user_group_func'>
                <ul class='menu'>
                    <li class='cmd_group_add'><a href='javascript:void(0);' class='cgreen'><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới</a></li>
                    <li class="cmd_group_edit"><a href='' ><i class="fa fa-edit" aria-hidden="true"></i> Sửa nhóm</a></li>
                    <li class='cmd_group_del'><a href='' class="cred"><i class="fa fa-user-times" aria-hidden="true"></i> Xóa nhóm</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class='col-md-9 body_col_right'>
        <div class='row'>
            <div class="com_header color">
                <i class="fa fa-list" aria-hidden="true"></i> Danh sách bài tin
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
                <li>
                    <a href="#tags" role="tab" data-toggle="tab">
                        Tags
                    </a>
                </li>
                <li>
                    <a href="#related_content" role="tab" data-toggle="tab">
                        Bài viết liên quan
                    </a>
                </li>
            </ul><br>
            <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="info">
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Danh mục tin <span class="cred">*</span></label>
                            <div class="col-sm-9 col-md-10">
                                <select class="form-control" id="cbo_cata" name="cbo_cata" style="width: 100%">
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
                                <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
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
                                        <a class="btn btn-success" href="#" onclick="OpenPopup('extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
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

                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">Ngày đăng bài</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="txt_cdate">
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-2"> Tóm tắt</label>
                            <div class="col-sm-9 col-md-10">
                                <textarea name="txt_intro" id="txt_intro" class="form-control"></textarea>
                                <script language="javascript">
                                    var oEdit1=new InnovaEditor("oEdit1");
                                    oEdit1.width="100%";
                                    oEdit1.height="200";
                                    oEdit1.REPLACE("txt_intro");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3 col-md-2"> Nội dung</label>
                            <div class="col-sm-9 col-md-10">
                            <textarea name="txt_fulltext" id="txt_fulltext" class="form-control"></textarea>
                                <script language="javascript">
                                    var oEdit2=new InnovaEditor("oEdit2");
                                    oEdit2.width="100%";
                                    oEdit2.height="400";
                                    oEdit2.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>extensions/editor/innovar/assetmanager/assetmanager.php',640,865)";
                                    oEdit2.REPLACE("txt_fulltext");
                                </script>
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
                                <textarea class="form-control" name="txt_metakey" id="txt_metakey" size="45"></textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class='form-group'>
                            <label class="col-sm-3 control-label"><strong>Description</strong></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" size="45"></textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tags">
                        <div class="form-group">
                            <label class="label-control col-md-3">Danh sách tags</label>
                            <div class="col-md-9">
                                <select  name="txt_tagid[]" id="txt_tagid" class="js-example-basic-multiple js-states form-control sl_user" multiple="multiple" style="width: 100%">
                                    <?php echo $obj->getListCbTags(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="related_content">
                        <div class="form-group">
                            <label class="label-control col-md-2">Danh sách bài viết:</label>
                            <div class="col-md-10">
                                <select  name="txt_relateContent[]" id="txt_relateContent" class="js-example-basic-multiple js-states form-control sl_user1" multiple="multiple" style="width: 100%">
                                    <?php echo $obj->getListCbRelateContent(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var body_h=$('.body_body').outerHeight();
        $('.body_body .body_col_left').css({'height':body_h+'px'});
        $(".sl_user").select2();
        $(".sl_user1").select2();
    });
</script>
