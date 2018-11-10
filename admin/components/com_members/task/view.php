<?php 
if(isset($_GET['id'])){
    require_once(LIB_PATH."cls.members.php");
    require_once(LIB_PATH."cls.member_course.php");
    $objmem = new CLS_MEMBERS();
    $objmemcourse = new CLS_MEMBER_COURSE();
    $objmysql = new CLS_MYSQL();
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $MC_ID = test_input($_GET['id']); /*Member_course id*/
    $sql="SELECT mc.*, m.fullname, m.id as mem_id FROM tbl_member_course AS mc, tbl_member AS m WHERE mc.mem_id = m.id AND mc.id=$MC_ID ";
    $objmysql->Query($sql);
    $row = $objmysql->Fetch_Assoc();
    $M_ID = (int)$row['mem_id'];
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
            <div class="box-member">
                <div class="row">
                    <fieldset class="col-md-5">
                        <?php
                        $sql="SELECT * FROM tbl_member WHERE isactive=1 AND id=".$row['mem_id'];
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
                        <legend class="title">Học viên</legend>
                        <div class="col-sm-4">
                            <article class="box-avatar"><?php echo $avatar;?></article>
                        </div>
                        <div class="col-sm-8">
                            <ul class="list_info nav">
                                <li><label>Họ và tên: </label><span><?php echo $row_m['fullname'];?></span></li>
                                <li><label>Số điện thoại: </label><span><?php echo $row_m['phone'];?></span></li>
                                <li><label>Email: </label><span><?php echo $row_m['email'];?></span></li>
                                <li><label>CMTND: </label><span><?php echo $row_m['identify'];?></span></li>
                                <li><label>Địa chỉ: </label><span><?php echo $row_m['address'];?></span></li>
                            </ul>
                        </div>
                    </fieldset>
                    <fieldset class="form-group col-md-7">
                        <legend class="title">Khóa học</legend>
                        <form id="frm-register" class="form-horizontal">
                            <input type="hidden" name="cbo_mem" value="<?php echo $row['mem_id'];?>">
                            <div class="form-group">
                                <?php
                                if($UserLogin->permission()==true){
                                    ?>
                                    <div class="col-md-5">
                                        <select id="cbo_teacher" class="sl2 form-control" style="width: 100%;" name="cbo_teacher">
                                            <option value="0">--Chọn giáo viên--</option>
                                            <?php
                                            $sql="SELECT CONCAT(`lastname`,' ',`firstname`) AS `fullname`,`id` FROM tbl_user WHERE isactive=1 AND gid=2 ";
                                            $objmysql->Query($sql);
                                            while ($row = $objmysql->Fetch_Assoc()) {
                                                echo '<option value="'.$row['id'].'">'.$row['fullname'].'</option>';
                                            }
                                            ?>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $("#cbo_teacher").select2();
                                                });
                                            </script>
                                        </select>
                                        <small id="er1" class="cred"></small>
                                    </div>
                                    <?php
                                }else{
                                    echo '<input type="hidden" id="cbo_teacher" name="cbo_teacher" value="'.$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'].'"><small id="er1" class="cred"></small>';
                                }
                                ?>
                                <div class="col-md-5">
                                    <select id="cbo_course" name="cbo_course" style="width: 100%;" class="sl2 form-control">
                                        <option value="0">-- Chọn 1 khóa học --</option>
                                        <?php
                                        $sql="SELECT * FROM tbl_course WHERE isactive=1";
                                        $objmysql->Query($sql);
                                        while ($row = $objmysql->Fetch_Assoc()) {
                                            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                        }
                                        ?>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $("#cbo_course").select2();
                                            });
                                        </script>
                                    </select>
                                    <small id="er2" class="cred"></small>
                                </div>
                                <button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
                            </div>
                        </form><br>
                        <div id="list_mem_course"></div>
                    </fieldset>
                </div>
            </div><br/>
            <div class="row dis-flex">
                <fieldset class="form-group col-md-6">
                    <legend class="title">Hồ sơ gồm có <span class="pull-right"></legend>
                    <div class="profile-header">
                        <form id="frm-register0" class="form-horizontal" name="frm-register0">
                            <input type="hidden" name="mc_id" value="<?php echo $MC_ID;?>">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <input type="text" id="txt_name" name="txt_name" class="form-control" value="" placeholder="Tên hồ sơ (*)">
                                    <small id="er1" class="cred"></small>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="txt_note" name="txt_note" class="form-control" value="" placeholder="Chú thích">
                                </div>
                                <button type="button" class="btn btn-primary" id="cmd_save0"><i class="fa fa-floppy-o" aria-hidden="true"></i> Thêm</button>
                            </div><br/>
                        </form>
                    </div>
                    <div id="list_profile"></div>
                </fieldset>
                <fieldset class="form-group col-md-6">
                    <legend class="title">Học phí</legend>
                    <form id="frm-register1" class="form-horizontal" name="frm-register1" method="" action="">
                        <input type="hidden" name="frm_fee">
                        <input type="hidden" name="mc_id" value="<?php echo $MC_ID;?>">
                        <div class="form-group">
                            <div class="col-md-5">
                                <input type="number" id="txt_name" name="txt_name" min="0" class="form-control" value="" placeholder="Học phí (*)">
                                <small id="er1" class="cred"></small>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="txt_note1" name="txt_note" class="form-control" placeholder="Chú thích"></textarea>
                            </div>
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
            getListMemCourse();
            $('#cmd_save').click(function(){
                if(check_validate()==true){
                    var data = $('#frm-register').serializeArray();
                    var url='<?php echo ROOTHOST_ADMIN;?>api/process_update_member_course.php';
                    $.post(url,data,function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
                        else {
                            getListMemCourse();
                            showMess('Success!','success');
                        }
                    });
                }
            });
        })
        function getListMemCourse(){
            var mem_id = '<?php echo $M_ID;?>';
            var url="<?php echo ROOTHOST_ADMIN;?>ajaxs/member/getlistMemCourse.php";
            $.get(url,{mem_id},function(req){
                $('#list_mem_course').html(req);
            })
        }
        function add_MC($this_user){
            var _id = $($this_user).attr('dataid');
            $('#myModalPopup .modal-dialog').removeClass('modal-sm');
            $('#myModalPopup .modal-dialog').addClass('modal-lg');
            $('#myModalPopup .modal-header .modal-title').html('Đăng ký khóa học');
            $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
            var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/frm_add_member_course.php'; 
            $.post(url,{'mem_id':_id},function(req){
                if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                else{
                    $('#myModalPopup .modal-body').html(req);
                    $('#myModalPopup').modal('show');
                }
            })
        }
        function edit_MC($this_user){
            var _id = $($this_user).attr('dataid');
            if(_id=='' || _id==0) showMess('Chọn một khóa học để sửa','');
            else{
                $('#myModalPopup .modal-dialog').removeClass('modal-sm');
                $('#myModalPopup .modal-dialog').addClass('modal-lg');
                $('#myModalPopup .modal-header .modal-title').html('Sửa thông tin khóa học');
                $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
                var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/frm_edit_member_course.php'; 
                $.post(url,{'id':_id},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E03'){showMess('Không tồn tại khóa học này!','error');}
                    else{
                        $('#myModalPopup .modal-body').html(req);
                        $('#myModalPopup').modal('show');
                    }
                })
            }
            return false;
        }
        function del_MC($this_user){
            if(confirm("Bạn có chắc muốn xóa?")){
                var _id = $($this_user).attr('dataid');
                if(_id=='' || _id==0) showMess('Chọn một cá nhân để xóa','');
                else{
                    var url='<?php echo ROOTHOST_ADMIN;?>api/process_del_member_course.php'; 
                    $.post(url,{'id':_id},function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                        else{
                            getUserByGroup();
                            showMess('Success!','success');
                        }
                    })
                }
                return false;
            }
        }
        function show_profile($this_user){
            var _id = $($this_user).attr('dataid');
            if(_id=='' || _id==0) showMess('Chọn một khóa học để sửa','');
            else{
                $('#myModalPopup .modal-dialog').removeClass('modal-sm');
                $('#myModalPopup .modal-dialog').addClass('modal-lg');
                $('#myModalPopup .modal-header .modal-title').html('Hồ sơ học viên');
                $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
                var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/show_profile.php'; 
                $.post(url,{'mc_id':_id},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E03'){showMess('Không tồn tại hồ sơ này!','error');}
                    else{
                        $('#myModalPopup .modal-body').html(req);
                        $('#myModalPopup').modal('show');
                    }
                })
            }
            return false;
        }
        function show_fee($this_user){
            var _id = $($this_user).attr('dataid');
            if(_id=='' || _id==0) showMess('Chọn một khóa học để sửa','');
            else{
                $('#myModalPopup .modal-dialog').removeClass('modal-sm');
                $('#myModalPopup .modal-dialog').addClass('modal-lg');
                $('#myModalPopup .modal-header .modal-title').html('Thông tin học phí');
                $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
                var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member/show_fee.php'; 
                $.post(url,{'mc_id':_id},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E03'){showMess('Không tồn tại hồ sơ này!','error');}
                    else{
                        $('#myModalPopup .modal-body').html(req);
                        $('#myModalPopup').modal('show');
                    }
                })
            }
            return false;
        }
        function del_profile($this_user){
            if(confirm("Bạn có chắc muốn xóa?")){
                var _id = $($this_user).attr('dataid');
                if(_id=='' || _id==0) showMess('Chọn một hồ sơ để xóa','');
                else{
                    var url='<?php echo ROOTHOST_ADMIN;?>api/process_del_log_profile.php'; 
                    $.post(url,{'id':_id},function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                        else{
                            console.log(req);
                            // showMess('Success!','success');
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
                    var url='<?php echo ROOTHOST_ADMIN;?>api/process_del_log_fee.php'; 
                    $.post(url,{'id':_id,'fee':1},function(req){
                        if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                        if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                        else{
                            showMess('Success!','success');
                        }
                    })
                }
                return false;
            }
        }
        function check_validate(){
            if ($('#cbo_teacher').val() =='' || $('#cbo_teacher').val()==0) {
                $('#er1').text('Không được bỏ trống');
                return false;
            }else{
                $('#er1').text('');
            }
            if ($('#cbo_course').val() =='' || $('#cbo_course').val() ==0) {
                $('#er2').text('Không được bỏ trống');
                return false;
            }else{
                $('#er2').text('');
            }
            return true;
        }
    </script>
    <?php 
}?>