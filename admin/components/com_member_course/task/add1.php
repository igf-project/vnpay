<?php 
require_once(LIB_PATH."cls.member_course.php");
$obj_mcourse = new CLS_MEMBER_COURSE();
$objmysql = new CLS_MYSQL();
$strwhere=''; 
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$member_course_id = (int)$_GET['id'];
$info_mcourse = $obj_mcourse->getInfo(" AND id=$member_course_id ");
$member = $obj_mcourse->getNameMemByID($info_mcourse['mem_id']);

if(isset($_POST['member_course_id'])){
    $cdate = time();
    $money = (int)$_POST['txt_money'];
    $note = addslashes($_POST['txt_note']);
    $sql="INSERT INTO tbl_log_fee (`member_course_id`,`money`,`cdate`,`note`) VALUES ('$member_course_id','$money','$cdate','$note')";
    $objmysql->Query($sql);
}
?>
<style type="text/css">
    .sl2{width: 90%;}
    .dis-flex{display: flex;justify-content: row;}
</style>
<div class="body">
    <div class='col-md-12 body_col_right'>
        <div class='row'>
            <div class="com_header color">
                <i class="fa fa-list" aria-hidden="true"></i> Đóng học phí
            </div>
        </div><br>
        <div class="row dis-flex">
            <fieldset class="form-group col-md-4">
                <legend>Hồ sơ</legend>
                <form id="frm_member_course" name="frm_member_course" action="" method="post">
                    <input type="hidden" id="member_course_id" name="member_course_id" value="<?php echo $member_course_id;?>">
                    <div class="form-group">
                        <label>Học viên:</label>
                        <input type="text" name="txt_member" value="<?php echo $member;?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Học phí:</label>
                        <input type="text" name="txt_money" value="" class="form-control" required>
                    </div>
                    <label>Chú thích:</label>
                    <textarea class="form-control" rows="3" id="txt_note" name="txt_note" placeholder="Địa chỉ của bạn"></textarea><br/><br/>
                    <div class="text-center"><button type="submit" id="cmd_save1" name="cmd_save1" class="btn btn-primary">Lưu thông tin</button></div>
                </form>
            </fieldset>
            <fieldset class="form-group col-md-8">
                <legend>Danh sách đóng học phí</legend>
                <div id="list-profile"></div>
            </fieldset>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        getUserByGroup();
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
    })
    function getUserByGroup($strwhere){
        var mcourse_id = $('#member_course_id').val();
        var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member_course/getlistfee.php';
        $.post(url,{'mcourse_id':mcourse_id,'strwhere':$strwhere},function(req){
            $('#list-profile').html(req);
        });
    }
    function edit_user($this_user){
        var _userid = $($this_user).attr('dataid');
        if(_userid=='' || _userid==0) showMess('Chọn một hồ sơ để sửa','');
        else{
            $('#myModalPopup .modal-dialog').removeClass('modal-sm');
            $('#myModalPopup .modal-dialog').addClass('modal-lg');
            $('#myModalPopup .modal-header .modal-title').html('Sửa hồ sơ');
            $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
            var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member_course/frm_log_edit.php'; 
            $.post(url,{'userid':_userid},function(req){
                if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                if(req=='E03'){showMess('Không có hồ sơ này!','error');}
                else{
                    $('#myModalPopup .modal-body').html(req);
                    $('#myModalPopup').modal('show');
                }
            })
        }
        return false;
    }
    function del_user($this_user){
        if(confirm("Bạn có chắc muốn xóa?")){
            var _userid = $($this_user).attr('dataid');
            if(_userid=='' || _userid==0) showMess('Chọn một hồ sơ để xóa','');
            else{
                var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/member_course/process_log_del.php'; 
                $.post(url,{'userid':_userid,'log_fee':1},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E03'){showMess('Không tồn tại hồ sơ này!','error');}
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
</script>