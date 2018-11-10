<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','CONTENTS');
$keyword='';$strwhere='';$action='';$key_category='';
// Pagging
if(!isset($_SESSION['CUR_PAGE_CONTENTS']))
    $_SESSION['CUR_PAGE_CONTENTS']=1;
if(isset($_POST['txtCurnpage'])){
    $_SESSION['CUR_PAGE_CONTENTS']=(int)$_POST['txtCurnpage'];
}
?>
<div class="body">
    <script language="javascript">
        function checkinput(){
            var strids=document.getElementById("txtids");
            if(strids.value==""){
                alert('You are select once record to action');
                return false;
            }
            return true;
        }
    </script>
    <div class='col-md-3'>
        <div class='row body_col_left bleft bright'>
            <div class="com_header color">
                <i class="fa fa-sitemap" aria-hidden="true"></i> Tin tức
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
                <i class="fa fa-list" aria-hidden="true"></i> <span id="com_header_title"></span>
                <div class="pull-right">
                    <div id="menus" class="toolbars">
                        <form id="frm_menu" name="frm_menu" method="post" action="">
                            <input type="hidden" name="txtorders" id="txtorders" />
                            <input type="hidden" name="txtids" id="txtids" />
                            <input type="hidden" name="txtaction" id="txtaction" />
                            <ul class="list-inline">
                                <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','public');"><i class="fa fa-check-circle-o cgreen" aria-hidden="true"></i> Hiển thị</button></li>
                                <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','unpublic');"><i class="fa fa-times-circle-o cred" aria-hidden="true"></i> Ẩn</button></li>
                                <li><a class="addnew btn btn-default" href="index.php?com=<?php echo COMS;?>&task=add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm bài tin</a></li>
                                <li><a class="delete btn btn-default" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="Xóa"><i class="fa fa-times-circle cred" aria-hidden="true"></i> Xóa</a></li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div><br>
        <div class='user_list'>
            <table class="table table-bordered">
                <tr class="header">
                    <th width="30" align="center">#</th>
                    <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
                    <th width="180" align="center">Nhóm tin</th>
                    <th align="center">Bài tin</th>
                    <th align="center" width="100">Tác giả</th>
                    <th align="center">Ngày đăng</th>
                    <th align="center">Lượt xem</th>
                    <th width="70" align="center" style="text-align: center;">Sắp xếp
                        <a href="javascript:saveOrder()"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                    </th>
                    <th colspan="3"></th>
                </tr>
                <tbody class="list"></tbody>
            </table>
        </div>
    </div>
</div>
<?php //----------------------------------------------?>
<script>
    function category_select(_item){
        var _gid=$(_item).attr('dataid');
        var title_group= $(_item).text();
        $('#com_header_title').text(title_group);
        $('.user_group_list .menu li').removeClass('checked');
        $(_item).parent().addClass('checked');
        $('#guser_selected').val(_gid);
        getUserByGroup(_gid);
    }
    function getUserByGroup($gid){
        var url='ajaxs/content/getContentByCate.php';
        $.post(url,{'gid':$gid},function(req){
            $('.user_list .list').html(req);
        });
    }
    function edit_content($this_user){
        var _gid=$('#guser_selected').val();
        var _userid = $($this_user).attr('dataid');
        if(_userid=='' || _userid==0) showMess('Chọn một bài viết để sửa','');
        else{
            $('#myModalPopup .modal-dialog').removeClass('modal-sm');
            $('#myModalPopup .modal-dialog').addClass('modal-lg');
            $('#myModalPopup .modal-header .modal-title').html('Sửa bài viết');
            $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
            var url='ajaxs/content/frm_edit_user.php'; 
            $.post(url,{'userid':_userid,'gid':_gid},function(req){
                if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                if(req=='E02'){showMess('Không có quyền sửa bài viết ở nhóm này!','error');}
                if(req=='E03'){showMess('Không tồn tại bài viết này!','error');}
                else{
                    $('#myModalPopup .modal-body').html(req);
                    $('#myModalPopup').modal('show');
                }
            })
        }
        return false;
    }
    function del_content($this_user){
        if(confirm("Bạn có chắc muốn xóa?")){
            var _gid=$('#guser_selected').val();
            var con_id = $($this_user).attr('dataid');
            if(con_id=='' || con_id==0) showMess('Chọn một bài viết để xóa','');
            else{
                var url='api/process_del_content.php'; 
                $.post(url,{'con_id':con_id},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                    else{
                        getUserByGroup(_gid);
                    }
                })
            }
            return false;
        }
    }
    function active_content($this_user){
        var _gid=$('#guser_selected').val();
        var con_id = $($this_user).attr('dataid');
        if(con_id=='' || con_id==0) showMess('Chọn một bài viết để active','');
        else{
            var url='api/process_active_content.php'; 
            $.post(url,{'con_id':con_id},function(req){
                if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                else{
                    getUserByGroup(_gid);
                }
            })
        }
        return false;
    }
    function active_ishot($this_user){
        var _gid=$('#guser_selected').val();
        var con_id = $($this_user).attr('dataid');
        if(con_id=='' || con_id==0) showMess('Chọn một bài viết để active','');
        else{
            var url='api/process_ishot_content.php'; 
            $.post(url,{'con_id':con_id},function(req){
                if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
                else{
                    getUserByGroup(_gid);
                }
            })
        }
        return false;
    }
    $(document).ready(function(){
        var body_h=$('.body_body').outerHeight();
        $('.body_body .body_col_left').css({'height':body_h+'px'});

        var gid= $('.user_group_list li:first-child>a').attr('dataid');
        var title_group= $('.user_group_list li:first-child>a').text();
        $('.user_group_list li:first-child').addClass('checked');
        $('#com_header_title').text(title_group);
        getUserByGroup(gid);

        $('.cmd_group_add a').click(function(){
            $('#myModalPopup .modal-dialog').removeClass('modal-sm');
            $('#myModalPopup .modal-dialog').addClass('modal-lg');
            $('#myModalPopup .modal-header .modal-title').html('Thêm mới nhóm bài viết');
            $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
            var url='ajaxs/content/frm_add_category.php'; 
            $.get(url,function(req){
                if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                else{
                    $('#myModalPopup .modal-body').html(req);
                    $('#myModalPopup').modal('show');
                }
            })
            return false;
        });
        $('.cmd_group_edit a').click(function(){
            var _gid=$('#guser_selected').val();
            if(_gid=='' || _gid==0) showMess('Bạn chưa chọn nhóm để sửa','error');
            else{
                $('#myModalPopup .modal-dialog').removeClass('modal-sm');
                $('#myModalPopup .modal-dialog').addClass('modal-lg');
                $('#myModalPopup .modal-header .modal-title').html('Sửa thông tin nhóm bài viết');
                $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
                var url='ajaxs/content/frm_add_group.php'; 
                $.get(url,{'gid':_gid},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E02'){showMess('Không có quyền sửa nhóm này!','error');}
                    else{
                        $('#myModalPopup .modal-body').html(req);
                        $('#myModalPopup').modal('show');
                    }
                })
            }
            return false;
        });
        $('.cmd_group_del a').click(function(){
            if(confirm("Bạn có chắc muốn xóa?")){
                var _gid=$('#guser_selected').val();
                var url='ajaxs/content/del_group.php'; 
                $.get(url,{'id':_gid},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E02'){showMess('Không có quyền xóa nhóm này!','error');}
                    $('.user_group_list').html(req);
                });
                return false;
            }
        });
        $('#cmd_user_add').click(function(){
            var _gid=$('#guser_selected').val();
            if(_gid=='undefined' || _gid==0) showMess('Bạn chưa chọn nhóm để thêm','');
            else{
                $('#myModalPopup .modal-dialog').removeClass('modal-sm');
                $('#myModalPopup .modal-dialog').addClass('modal-lg');
                $('#myModalPopup .modal-header .modal-title').html('Đăng ký bài viết');
                $('#myModalPopup .modal-body').html('<p>Loadding...</p>');
                var url='ajaxs/content/frm_add_user.php'; 
                $.get(url,{'id':_gid},function(req){
                    if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
                    if(req=='E02'){showMess('Không có quyền thêm bài viết vào nhóm này!','error');}
                    else{
                        $('#myModalPopup .modal-body').html(req);
                        $('#myModalPopup').modal('show');
                    }
                })
            }
            return false;
        })
    })
</script>
