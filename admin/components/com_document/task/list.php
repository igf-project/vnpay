<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$keyword='';$strwhere='';$action='';$key_category='';$catid='';

if(isset($_GET['cate'])){
    $cate_id = (int)$_GET['cate'];
    $name_category = $obj_doctype->getNameById($cate_id);
    $strwhere.=" AND type_id = $cate_id ";
}

if(!isset($_SESSION['EDU_CONTENT_CATID'])) $_SESSION['EDU_CONTENT_CATID']='';
if(!isset($_SESSION['EDU_CONTENT_ACT'])) $_SESSION['EDU_CONTENT_ACT']='';

if(isset($_POST['txtkeyword'])){
    $keyword=$_POST['txtkeyword'];
    $_SESSION['EDU_CONTENT_ACT']=$_POST['cbo_active'];
    $_SESSION['EDU_CONTENT_CATID']=$_POST['cbo_cont'];
}
$catid = $_SESSION['EDU_CONTENT_CATID'];
$action = $_SESSION['EDU_CONTENT_ACT'];

if($keyword!='' && $keyword!='Keyword')
    $strwhere.="AND ( `name` like '%$keyword%')";
if($catid!='' && $catid!='all')
    $strwhere.="AND `type_id` = '$catid' ";
if($action!='' && $action!='all' )
    $strwhere.="AND `isactive` = '$action'";
// echo $strwhere;
if(!isset($_SESSION['CUR_PAGE_CON']))
    $_SESSION['CUR_PAGE_CON']=1;
if(isset($_POST['txtCurnpage'])){
    $_SESSION['CUR_PAGE_CON']=$_POST['txtCurnpage'];
}
$obj->getList($strwhere,'');
$total_rows=$obj->Num_rows();
if($_SESSION['CUR_PAGE_CON']>ceil($total_rows/MAX_ROWS_ADMIN))
    $_SESSION['CUR_PAGE_CON']=ceil($total_rows/MAX_ROWS_ADMIN);
$cur_page=($_SESSION['CUR_PAGE_CON']<1)?1:$_SESSION['CUR_PAGE_CON'];
?>

<script language="javascript">
    function checkinput()
    {
        var strids=document.getElementById("txtids");
        if(strids.value=="")
        {
            alert('You are select once record to action');
            return false;
        }
        return true;
    }
</script>

<div class='row'>
    <div class="com_header color">
        <i class="fa fa-list" aria-hidden="true"></i> Danh sách tài liệu
        <div class="pull-right">
            <?php require_once("../global/libs/toolbar.php"); ?>
        </div>
    </div>
</div><br>
<form id="frm_list" name="frm_list" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="Header_list">
        <tr>
            <td><strong>Tìm kiếm:</strong>
                <input type="text" name="txtkeyword" id="txtkeyword" placeholder="Keyword" value=""/>
                <input type="submit" name="button" id="button" value="Tìm kiếm" class="button" size='30'/>
            </td>
            <td align="right">
                <label>
                    <select name="cbo_cont" id="cbo_cont" onchange="document.frm_list.submit();">
                        <option value="all">Nhóm tài liệu</option>
                        <?php 
                        $objbox=new CLS_DOCUMENT_TYPE();
                        echo $objbox->getListDocType(0,"");
                        ?>
                        <script language="javascript">
                            cbo_Selected('cbo_cont','<?php echo $catid;?>');
                        </script>
                    </select>
                </label>
                <select name="cbo_active" id="cbo_active" onchange="document.frm_list.submit();">
                    <option value="all">Tất cả</option>
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                    <script language="javascript">
                        cbo_Selected('cbo_active','<?php echo $action;?>');
                    </script>
                </select>
            </td>
        </tr>
    </table>
    <div style="clear:both;height:10px;"></div>
    <table class="table table-bordered">
        <tr class="header">
            <th width="30" align="center">#</th>
            <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
            <th align="center">Tên tài liệu</th>
            <th align="center">Nhóm tài liệu</th>
            <th align="center">Tác giả</th>
            <th width="70" style="text-align: center;">Sắp xếp
                <a href="javascript:saveOrder()">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                </a>
            </th>
            <th width="50" align="center">Hiển thị</th>
            <th width="50" align="center">Sửa</th>
            <th width="50" align="center">Xóa</th>
        </tr>
        <?php 
        $obj->listTable($strwhere,$cur_page);
        ?>
    </table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
    <tr>
        <td align="center">
            <?php 
            paging($total_rows,MAX_ROWS_ADMIN,$cur_page);
            ?>
        </td>
    </tr>
</table>


<?php //----------------------------------------------?>