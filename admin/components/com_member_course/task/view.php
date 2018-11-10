<?php 
if(isset($_GET['id'])){
    require_once(LIB_PATH."cls.member_course.php");
    $obj_mcourse = new CLS_MEMBER_COURSE();
    $objmysql = new CLS_MYSQL();
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $ID = test_input($_GET['id']);
    $info_MC = $obj_mcourse->getInfo(" AND id=$ID ");
    ?>
    <style type="text/css">
        .sl2{width: 90%;}
        .dis-flex{display: flex;justify-content: row;}
        .list_info li{line-height: 25px;}
        .list_info label{width: 100px;}
        .list_info li span{font-size: 14px;}
    </style>
    <div class="body">
        <div class='col-md-12 body_col_right'>
            <div class='row'>
                <div class="com_header color">
                    <i class="fa fa-list" aria-hidden="true"></i> Thông tin học viên
                </div>
            </div><br>
            <div class="box-member dis-flex">
                <div class="row">
                    <?php
                    $sql="SELECT * FROM tbl_member WHERE isactive=1 AND id=".$info_MC['mem_id'];
                    $objmysql->Query($sql);
                    $row_m = $objmysql->Fetch_Assoc();
                    if($row_m['avatar']!=''){
                        if(getimagesize($row_m['avatar'])>0){
                            $avatar="<img src='".$row_m["avatar"]."' alt='".$row_m['fullname']."' class='img-responsive'>";
                        }else{
                            $avatar="<img src='".ROOTHOST_ADMIN."uploads/user.png' alt='' class='img-responsive'>";
                        }
                    }else{$avatar="<img src='".ROOTHOST_ADMIN."uploads/user.png' alt='' class='img-responsive'>";}
                    ?>
                    <div class="col-sm-3">
                        <article class="box-avatar"><?php echo $avatar;?></article>
                    </div>
                    <div class="col-sm-9">
                        <ul class="list_info nav">
                            <li><label>Họ và tên: </label><span><?php echo $row_m['fullname'];?></span></li>
                            <li><label>Số điện thoại: </label><span><?php echo $row_m['phone'];?></span></li>
                            <li><label>Email: </label><span><?php echo $row_m['email'];?></span></li>
                            <li><label>CMTND: </label><span><?php echo $row_m['identify'];?></span></li>
                            <li><label>Địa chỉ: </label><span><?php echo $row_m['address'];?></span></li>
                        </ul>
                    </div>
                </div>
            </div><br/>
            <div class="row dis-flex">
                <fieldset class="form-group col-md-6">
                    <legend class="title">Hồ sơ gồm có <span class="pull-right"></legend>
                    <div class="profile-header">
                        <form id="frm-register" class="form-horizontal" name="frm-register" method="" action="">
                            <input type="hidden" name="mc_id" value="<?php echo $ID;?>">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label>Tên hồ sơ<small class="cred"> (*)</small></label>
                                    <input type="text" id="txt_name" name="txt_name" class="form-control" value="" placeholder="Tên hồ sơ">
                                    <small id="er1" class="cred"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Chú thích</label>
                                    <textarea class="form-control" rows="3" id="txt_note" name="txt_note" placeholder="Chú thích"></textarea>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
                            </div><br/>
                        </form>
                    </div>
                    <div id="list_profile"></div>
                </fieldset>
                <fieldset class="form-group col-md-6">
                    <legend class="title">Học phí</legend>
                    <form id="frm-register1" class="form-horizontal" name="frm-register1" method="" action="">
                        <input type="hidden" name="frm_fee">
                        <input type="hidden" name="mc_id" value="<?php echo $ID;?>">
                        <div class="form-group">
                            <div class="col-md-6">
                                <label>Học phí<small class="cred"> (*)</small></label>
                                <input type="number" id="txt_name" name="txt_name" min="0" class="form-control" value="" placeholder="Học phí">
                                <small id="er1" class="cred"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Chú thích</label>
                                <textarea class="form-control" rows="3" id="txt_note" name="txt_note" placeholder="Chú thích"></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" id="cmd_save1"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
                        </div><br/>
                    </form>
                    <div id="list_fee"></div>
                </fieldset>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            getListProfile();
            getListFee();
            $('#cmd_save').click(function(){
                if(check_validate()==true){
                    var data = $('#frm-register').serializeArray();
                    var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/log/process_update_log.php';
                    $.post(url,data,function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
                        else {
                            getListProfile();
                            getListFee();
                            showMess('Success!','success');
                        }
                    });
                }
            });
            $('#cmd_save1').click(function(){
                if(check_validate1()==true){
                    var data = $('#frm-register1').serializeArray();
                    var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/log/process_update_log.php';
                    $.post(url,data,function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
                        else {
                            getListProfile();
                            getListFee();
                            showMess('Success!','success');
                        }
                    });
                }
            });
        })
        function getListProfile(){
            var mc_id = '<?php echo $ID;?>';
            var url="<?php echo ROOTHOST_ADMIN;?>ajaxs/log/getLitsProfile.php";
            $.get(url,{mc_id},function(req){
                $('#list_profile').html(req);
            })
        }
        function getListFee(){
            var mc_id = '<?php echo $ID;?>';
            var url="<?php echo ROOTHOST_ADMIN;?>ajaxs/log/getLitsFee.php";
            $.get(url,{mc_id},function(req){
                $('#list_fee').html(req);
            })
        }
        function del_profile($this_user){
            if(confirm("Bạn có chắc muốn xóa?")){
                var _id = $($this_user).attr('dataid');
                if(_id=='' || _id==0) showMess('Chọn một hồ sơ để xóa','');
                else{
                    var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/log/process_del_log.php'; 
                    $.post(url,{'id':_id},function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                        else{
                            getListProfile();
                            showMess('Success!','success');
                        }
                    })
                }
                return false;
            }
        }
        function del_fee($this_user){
            if(confirm("Bạn có chắc muốn xóa?")){
                var _id = $($this_user).attr('dataid');
                if(_id=='' || _id==0) showMess('Chọn một học phí để xóa','');
                else{
                    var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/log/process_del_log.php'; 
                    $.post(url,{'id':_id,'fee':1},function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                        else{
                            getListFee();
                            showMess('Success!','success');
                        }
                    })
                }
                return false;
            }
        }
        function check_validate(){
            if ($('#txt_name').val() =='') {
                $('#er1').text('Không được bỏ trống');
                return false;
            }else{
                $('#er1').text('');
            }
            return true;
        }
        function check_validate1(){
            if ($('#frm-register1 input[name="txt_name"]').val() =='') {
                $('#er1').text('Không được bỏ trống');
                return false;
            }else{
                $('#er1').text('');
            }
            return true;
        }
    </script>
    <?php 
}?>