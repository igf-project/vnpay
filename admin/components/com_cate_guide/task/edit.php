<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=trim($_GET["id"]);
$obj->getList(" WHERE `cate_id`='".$id."'");
$row=$obj->Fetch_Assoc();
?>
<style type="text/css">
    .form-horizontal .control-label{text-align: left;}
</style>
<div class="body">
    <script language="javascript">
        function checkinput(){
            if($("#txt_name").val()==""){
                $("#txt_name_err").fadeTo(200,0.1,function(){
                    $(this).html('Vui lòng nhập tên nhóm').fadeTo(900,1);
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
                <i class="fa fa-sitemap" aria-hidden="true"></i>Nhóm trợ giúp
            </div>
            <input type='hidden' id='guser_selected' value=''/>
            <div class='user_group_list'>
                <?php $obj->getListCategory(); ?>
            </div>
            <div class='user_group_func'>
                <ul class='nav'>
                    <li class='cmd_group_add'><a href='<?php echo ROOTHOST_ADMIN;?>cate_intro/add' class='cgreen'><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class='col-md-9 body_col_right'>
        <div class='row'>
            <div class="com_header color">
                <i class="fa fa-list" aria-hidden="true"></i> Sửa nhóm trợ giúp
                <div class="pull-right">
                    <div id="menus" class="toolbars">
                        <form id="frm_menu" name="frm_menu" method="post" action="">
                            <input type="hidden" name="txtorders" id="txtorders" />
                            <input type="hidden" name="txtids" id="txtids" />
                            <input type="hidden" name="txtaction" id="txtaction" />

                            <ul class="list-inline">
                                <li><a class="save btn btn-default" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</a></li>

                                <li><a class="btn btn-default"  href="<?php echo ROOTHOST_ADMIN;?>guide" title="Đóng"><i class="fa fa-sign-out" aria-hidden="true"></i> Đóng</a></li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="box-tabs">
            <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
                <input type="hidden" name="txtid" value="<?php echo $row['cate_id'];?>">
                <div class="tab-content">
                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 form-control-label">Tên nhóm <span class="cred">*</span></label>
                        <div class="col-sm-9 col-md-10">
                            <input type="text" name="txt_name" value="<?php echo $row['name'];?>" class="form-control" id="txt_name" placeholder="">
                            <div id="txt_name_err" class="mes-error"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 form-control-label">Nhóm cha</label>
                        <div class="col-sm-9 col-md-10">
                            <select name="cbo_cate" class="form-control" id="cbo_cate" style="width: 100%;">
                                <option value="0" title="Top">Root</option>
                                <?php $obj->getListCate(0,0); ?>
                            </select>
                            <script type="text/javascript">
                                cbo_Selected('cbo_cate','<?php echo $row['par_id'];?>');
                                $(document).ready(function() {
                                    $("#cbo_cate").select2();
                                });
                            </script>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class='form-group'>
                        <label class="col-sm-3 col-md-2 control-label">Ảnh đại diện</label>
                        <div class="col-sm-9 col-md-10">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="<?php echo $row['thumb'];?>" placeholder='' />
                                </div>
                                <div class="col-sm-3">
                                    <a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                                </div>
                                <div id="txt_thumb_err" class="mes-error"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="form-control-label"> Mô tả ngắn</label>
                        <textarea name="txtintro" id="txtintro" rows="5"><?php echo $row['intro'];?></textarea>
                        <script language="javascript">
                            var oEdit2=new InnovaEditor("oEdit2");
                            oEdit2.width="100%";
                            oEdit2.height="350";
                            oEdit2.REPLACE("txtintro");
                        </script>
                    </div>
                </div>
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
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
    })
</script>
