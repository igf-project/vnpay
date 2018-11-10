<?php 
$objmysql = new CLS_MYSQL();
$strwhere=''; 
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$author_id = $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'];
$author = $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['lastname'].' '.$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['firstname'];
?>
<style type="text/css">
    .sl2{width: 80%;}
</style>
<div class="body">
    <div class='col-md-12 body_col_right'>
        <div class='row'>
            <div class="com_header color">
                <i class="fa fa-list" aria-hidden="true"></i> Thêm mới khóa học & học viên
            </div>
        </div><br>
        <ul class="nav nav-tabs step-form" role="tablist">
            <li class="active">
                <a href="#home" role="tab" data-toggle="tab">
                    <div class="item">
                        <span class="ic-step">01</span>
                        <p>Học viên</p>
                        <label>Thông tin học viên</label>
                    </div>
                </a>
            </li>
            <li class="disabled">
                <a href="#about" role="tab" data-toggle="tab">
                    <div class="item">
                        <span class="ic-step">02</span>
                        <p>Hồ sơ</p>
                        <label>Thông tin hồ sơ</label>
                    </div>
                </a>
            </li>
            <li class="disabled">
                <a href="#fee" class="" role="tab" data-toggle="tab">
                    <div class="item">
                        <span class="ic-step">03</span>
                        <p>Học phí</p>
                        <label>Đóng học phí</label>
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <input type="hidden" id="member_course_id" name="member_course_id" value="0">
            <div class="tab-pane fade active in" id="home">
                <div class="col-md-12">
                    <div id="er1"></div>
                    <form id="frm_member_course" name="frm_member_course" action="" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Giáo viên:</label>
                                    <input type="hidden" name="teacher_id" value="<?php echo $author_id;?>">
                                    <input type="text" name="txt_teacher" value="<?php echo $author;?>" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>Học viên:</label>
                                    <div>
                                        <select id="cbo_mem" class="sl2" name="cbo_mem" readonly>
                                            <option value="0">--Chọn học viên--</option>
                                            <?php
                                            $sql="SELECT `fullname`,`id` FROM tbl_member WHERE isactive=1";
                                            $objmysql->Query($sql);
                                            while ($row = $objmysql->Fetch_Assoc()) {
                                                echo '<option value="'.$row['id'].'">'.$row['fullname'].'</option>';
                                            }
                                            ?>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $("#cbo_mem").select2();
                                                });
                                            </script>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Khóa học:</label>
                                    <div>
                                        <select id="cbo_course" name="cbo_course" class="sl2">
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
                                    </div>
                                </div>
                            </div>
                        </div><br/>
                        <div class="text-center"><button type="button" id="cmd_save1" class="btn btn-primary">Lưu thông tin</button></div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="about">
                <form id="frm-add2" class="form-horizontal" name="frm-add2" method="" action="">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tên hồ sơ<small class="cred"> (*)</small></label>
                            <input type="int" id="txt_profile" name="txt_profile" class="form-control" min="0" value="" placeholder="Hồ sơ">
                            <small id="er1" class="cred"></small>
                        </div>
                    </div><br/>
                    <label>Ghi chú</label>
                    <div>
                        <textarea class="form-control" rows="5" id="txt_note" name="txt_note" placeholder="Ghi chú"></textarea>
                        <div class="clearfix"></div><br>
                        <button type="button" class="btn btn-primary" id="cmd_save2"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
                    </div>
                </form>
                <div id="list_profile">
                    <div class="row list"></div>
                </div>
            </div>
            <div class="tab-pane fade" id="fee">
                <p>Nhập thông tin Album trước khi Upload thư viện ảnh</p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#cmd_save1').click(function(){
            var member_course_id = $('#member_course_id').val();
            var data = $('#frm_member_course').serializeArray();
            data = data.push(member_course_id);
            var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member_course/process_update.php'; 
            $.post(url,data,function(req){
                var obj = jQuery.parseJSON(req);
                if(obj[0]['rep']=='yes') {  
                    $('#er1').text('');
                    $('#member_course_id').val(obj[0]['id']);
                    $('.step-form li:nth-child(2)').removeClass('disabled');
                    $('.step-form li:nth-child(3)').removeClass('disabled');
                    $('#frm_member_course input').attr('readonly', true);
                    $("#frm_member_course select").prop("disabled", true);
                    $('.step-form li').removeClass('active');
                    $('.step-form li:nth-child(2)').addClass('active');
                    return true;
                } else {
                    $('#er1').text('Có lỗi trong quá trình thực hiện. Hãy thử lại.');
                    return false;
                }
            })
        })
        $('#cmd_save2').click(function(){
            var member_course_id = $('#member_course_id').val();
            var data = $('#frm_member_course').serializeArray();
            data = data.push(member_course_id);
            var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member_course/process_update2.php'; 
            $.post(url,data,function(req){
                var obj = jQuery.parseJSON(req);
                if(obj[0]['rep']=='yes') {  
                    $('#er1').text('');
                    $('#member_course_id').val(obj[0]['id']);
                    $('.step-form li:nth-child(2)').removeClass('disabled');
                    $('.step-form li').removeClass('active');
                    $('#frm_member_course input').attr('readonly', true);
                    $("#frm_member_course select").prop("disabled", true);
                    $('.step-form li:nth-child(2)').addClass('active');
                    $('.step-form li:nth-child(3)').addClass('active');
                    return true;
                } else {
                    $('#er1').text('Có lỗi trong quá trình thực hiện. Hãy thử lại.');
                    return false;
                }
            })
        })
    })
    $('body').on('click', '.disabled', function(e) {
        e.preventDefault();
        return false;
    });
    function getListProfile(member_course){
        var url = "<?php echo ROOTHOST_ADMIN;?>ajaxs/member_course/getlistprofile.php";
        $.post(url,{'member_course':member_course},function(req){
            console.log(req);
            $('#list_profile .list').html(req);
        });
    }
</script>