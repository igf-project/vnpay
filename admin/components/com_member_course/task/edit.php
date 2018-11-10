<?php 
require_once(LIB_PATH."cls.member_course.php");
$obj_mcourse = new CLS_MEMBER_COURSE();
$objmysql = new CLS_MYSQL();
$strwhere=''; 
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$member_course_id = (int)$_GET['id'];
$info_mcourse = $obj_mcourse->getInfo(" AND id=$member_course_id ");

if(isset($_POST['member_course_id'])){
    $cdate = time();
    $profile = addslashes($_POST['txt_prifle']);
    $note = addslashes($_POST['txt_note']);
    $sql="INSERT INTO tbl_log_profile (`member_course_id`,`profile`,`cdate`,`note`) VALUES ('$member_course_id','$profile','$cdate','$note')";
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
                <i class="fa fa-list" aria-hidden="true"></i> Thêm mới hồ sơ
            </div>
        </div><br>
        <div class="row dis-flex">
            <fieldset class="form-group col-md-4">
                <legend>Hồ sơ</legend>
                <form id="frm_member_course" name="frm_member_course" action="" method="post">
                    <input type="hidden" name="member_course_id" value="<?php echo $member_course_id;?>">
                    <div class="form-group">
                        <label>Tên hồ sơ:</label>
                        <input type="text" name="txt_prifle" value="" class="form-control" required>
                    </div>
                    <label>Chú thích:</label>
                    <textarea class="form-control" rows="3" id="txt_note" name="txt_note" placeholder="Địa chỉ của bạn"></textarea><br/><br/>
                    <div class="text-center"><button type="submit" id="cmd_save1" name="cmd_save1" class="btn btn-primary">Lưu thông tin</button></div>
                </form>
            </fieldset>
            <fieldset class="form-group col-md-8">
                <legend>Danh sách hồ sơ</legend>
                <?php
                $sql="SELECT * FROM tbl_log_profile WHERE `member_course_id`=$member_course_id ";
                $objmysql->Query($sql);
                echo '
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Học viên</th>
                            <th>Tên hồ sơ</th>
                            <th>Chú thích</th>
                            <th>Ngày nộp</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>';
                        while ($row=$objmysql->Fetch_Assoc()) {
                            $member = $obj_mcourse->getNameMemByID($info_mcourse['mem_id']);
                            echo '<td>'.$member.'</td>';
                            echo '<td>'.$row['profile'].'</td>';
                            echo '<td>'.$row['note'].'</td>';
                            echo '<td>'.date('d-m-Y',$row['cdate']).'</td>';
                            echo '
                            <td width="10"><i class="fa fa-edit" aria-hidden="true" dataid="'.$row['id'].'" onclick="edit_user(this);"></i></td>
                            <td width="10"><i class="fa fa-times cred" aria-hidden="true" dataid="'.$row['id'].'" onclick="edit_user(this);"></i></td>';
                            echo '</tr>';
                        }
                        echo '
                    </tbody>
                </table>';
                ?>
            </fieldset>
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
    })
</script>