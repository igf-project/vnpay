<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','CONTENTS');
$keyword='';$strwhere='';$action='';$key_category='';$cate_id=0;

if(isset($_GET['cate'])){
    $cate_id = (int)$_GET['cate'];
    $name_category = $obj_gquestion->getNameById($cate_id);
    $strwhere.=" AND cate_id = $cate_id ";
}

// Khai báo SESSION
if(isset($_POST['txtkeyword'])){
    $keyword=trim($_POST['txtkeyword']);
    $_SESSION['KEY_CONTENTS']=$keyword;
}
if(isset($_POST['cbo_active']))
    $_SESSION['ACT_CONTENTS']=addslashes($_POST['cbo_active']);
if(isset($_SESSION['KEY_CONTENTS']))
    $keyword=$_SESSION['KEY_CONTENTS'];
else
    $keyword='';
$action=isset($_SESSION['ACT_CONTENTS']) ? $_SESSION['ACT_CONTENTS']:'';

// Gán strwhere
if($keyword!='')
    $strwhere.=" AND ( `name` like '%$keyword%' )";
if($action!='' && $action!='all' ){
    $strwhere.=" AND `isactive` = '$action'";
}
if(isset($_POST['txtkeyword'])){
    $keyword=trim($_POST['txtkeyword']);
    $_SESSION['KEY_CONTENTS']=$keyword;
}

// Pagging
if(!isset($_SESSION['CUR_PAGE_CONTENTS']))
    $_SESSION['CUR_PAGE_CONTENTS']=1;
if(isset($_POST['txtCurnpage']))
    $_SESSION['CUR_PAGE_CONTENTS']=(int)$_POST['txtCurnpage'];

$obj->getList($strwhere,'');
$total_rows=$obj->Num_rows();
if($_SESSION['CUR_PAGE_CONTENTS']>ceil($total_rows/MAX_ROWS_ADMIN))
    $_SESSION['CUR_PAGE_CONTENTS']=ceil($total_rows/MAX_ROWS_ADMIN);
$cur_page=(int)$_SESSION['CUR_PAGE_CONTENTS']>0 ? $_SESSION['CUR_PAGE_CONTENTS']:1;
?>

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

<div class='row'>
    <div class="com_header color">
        <i class="fa fa-list" aria-hidden="true"></i> Danh sách hỏi đáp
        <div class="pull-right">
            <div id="menus" class="toolbars">
                <form id="frm_menu" name="frm_menu" method="post" action="">
                    <input type="hidden" name="txtorders" id="txtorders" />
                    <input type="hidden" name="txtids" id="txtids" />
                    <input type="hidden" name="txtaction" id="txtaction" />
                    <ul class="list-inline">
                        <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','public');"><i class="fa fa-check-circle-o cgreen" aria-hidden="true"></i> Hiển thị</button></li>
                        <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','unpublic');"><i class="fa fa-times-circle-o cred" aria-hidden="true"></i> Ẩn</button></li>
                        <li><a class="addnew btn btn-default" href="<?php echo ROOTHOST_ADMIN.COMS;?>/add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm bài tin</a></li>
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
            <th width="30" align="center">STT</th>
            <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
            <th>Nhóm tin</th>
            <th>Bài tin</th>
            <th align="center" width="100">Ngày đăng</th>
            <th align="center" width="70">Lượt xem</th>
            <th width="70" align="center" style="text-align: center;">Sắp xếp
                <a href="javascript:saveOrder()"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
            </th>
            <th colspan="3"></th>
        </tr>
        <tbody class="list"><?php $obj->listTable($strwhere,$cur_page);?></tbody>
    </table>
</div>

<?php //----------------------------------------------?>
<script type="text/javascript">
    $(document).ready(function(){
        var body_h=$('.body_body').outerHeight();
        $('.body_body .body_col_left').css({'height':body_h+'px'});
        activeCategory();
    })
    function activeCategory(){
        $('.user_group_list li').each(function(index){
            var data_id = $(this).attr('data-id');
            var $_GET = '<?php echo $cate_id;?>';
            if(data_id == $_GET) $(this).addClass('checked');
        })
    }
</script>