<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','MODULE');
$keyword='';$strwhere='';$action='';$position='';

// Khai báo SESSION
if(isset($_POST['txtkeyword'])){
	$keyword=trim($_POST['txtkeyword']);
	$_SESSION['KEY_MODULE']=$keyword;
	$_SESSION['module_position']=$_POST['cbo_position'];
}
if(isset($_SESSION['module_position'])){
	$position=$_SESSION['module_position'];
}
if(isset($_POST['cbo_active']))
	$_SESSION['ACT_MODULE']=addslashes($_POST['cbo_active']);
if(isset($_SESSION['KEY_MODULE']))
	$keyword=$_SESSION['KEY_MODULE'];
else
	$keyword='';
$action=isset($_SESSION['ACT_MODULE']) ? $_SESSION['ACT_MODULE']:'';

// Gán strwhere
if($keyword!='')
	$strwhere.=" AND ( `title` like '%$keyword%' )";
if($action!='' && $action!='all' ){
	$strwhere.=" AND `isactive` = '$action'";
}
if($position!='' && $position!='all' )
	$strwhere.=" AND `position` = '$position' ";

if(!isset($_SESSION['CUR_PAGE_MOD']))
	$_SESSION['CUR_PAGE_MOD']=1;
if(isset($_POST['txtCurnpage']))
	$_SESSION['CUR_PAGE_MOD']=(int)$_POST['txtCurnpage'];

// Pagging
if(!isset($_SESSION['CUR_PAGE_MODULE']))
	$_SESSION['CUR_PAGE_MODULE']=1;
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_MODULE']=(int)$_POST['txtCurnpage'];
}
$obj->getList($strwhere,'');
$total_rows=$obj->Num_rows();
if($_SESSION['CUR_PAGE_MODULE']>ceil($total_rows/MAX_ROWS))
	$_SESSION['CUR_PAGE_MODULE']=ceil($total_rows/MAX_ROWS);
$cur_page=(int)$_SESSION['CUR_PAGE_MODULE']>0 ? $_SESSION['CUR_PAGE_MODULE']:1;
// End pagging
?>
<div class="body">
	<script language="javascript">
		function checkinput(){
			var strids=document.getElementById('txtids');
			if(strids.value==''){
				alert('You are select once record to action');
				return false;
			}
			return true;
		}
	</script>
	<div class='row'>
        <div class="com_header color">
            <i class="fa fa-list" aria-hidden="true"></i> Danh sách module
            <div class="pull-right">
                <?php require_once("../global/libs/toolbar.php"); ?>
            </div>
        </div>
    </div><br>
	<form id="frm_list" name="frm_list" method="post" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Header_list">
			<tr>
				<td>Tìm kiếm:
					<input type="text" name="txtkeyword" id="txtkeyword" value="<?php echo $keyword;?>"  placeholder="Keyword" />
					<input type="submit" name="button" id="button" value="Tìm kiếm" class="button" />
				</td>
				<td align="right">
					<label>
						<select name="cbo_position" id="cbo_position" onchange="document.frm_list.submit();">
							<option value="all">Select position</option>
							<?php $obj->getPosition(); ?>
							<script language="javascript">
								cbo_Selected('cbo_position','<?php echo $position;?>');
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
		<table width="100%" border="0" cellspacing="0" cellpadding="3" class="table table-bordered">
			<tr class="header">
				<th width="30" align="center">STT</th>
				<th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
				<th align="center">Tiêu đề</th>
				<th width="75" align="center">Kiểu</th>
				<th width="75" align="center">Giao diện</th>
				<th width="75" align="center">Vị trí</th>
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
			$start=($cur_page-1)*MAX_ROWS;
			$obj->getList($strwhere," LIMIT $start,".MAX_ROWS);
			$i=0;
			while($rows= $obj->Fetch_Assoc()){ $i++; ?>
			<tr>
				<td align='center'><?php echo $i;?></td>
				<td align='center'><input type="checkbox" name="chk" id="chk" value="<?php echo $rows['id'];?>" onclick="docheckonce('chk');" /></td>
				<td><?php echo stripslashes($rows['title']);?></td>
				<td align='center'><?php echo $rows['type'];?></td>
				<td align='center'><?php echo $rows['theme'];?></td>
				<td align='center'><?php echo $rows['position'];?></td>
				<td align="center" width='50'>
					<input type="text" value="<?php echo $rows['order'];?>" name='txt_order' size='4' class='order'/>
				</td>

				<td width='50' align="center">
					<a href="<?php echo ROOTHOST_ADMIN.COMS;?>/active/<?php echo $rows["id"];?>">
						<?php showIconFun('publish',$rows["isactive"]);?>
					</a>
				</td>
				<td width='50' align="center">
					<a href="<?php echo ROOTHOST_ADMIN.COMS;?>/edit/<?php echo $rows["id"];?>">
						<?php showIconFun('edit','');?>
					</a>
				</td>
				<td width='50' align="center">
					<a href="<?php echo ROOTHOST_ADMIN.COMS;?>/delete/<?php echo $rows["id"];?>" onclick="return confirm('Bạn có chắc muốn xóa ?');">
						<?php showIconFun('delete','');?>
					</a>
				</td>
			</tr>
			<?php } unset($obj); unset($start);?>
		</table>
	</form>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
		<tr>
			<td align="center"><?php paging($total_rows,MAX_ROWS,$cur_page);?></td>
		</tr>
	</table>
</div>
<?php //----------------------------------------------?>