<?php 
$objmysql = new CLS_MYSQL();
$strwhere=''; 
?>
<style type="text/css">
	.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
		vertical-align: middle;
	}
</style>
<div class="body">
	<div class='col-md-12 body_col_right'>
		<div class='row'>
			<div class="com_header color">
				<i class="fa fa-list" aria-hidden="true"></i> Báo cáo
				<div class="pull-right">
					<button id="" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Xuất excel</button>
				</div>
			</div>
		</div>
		<div class='list_search'>
			<form id="frm-search" method='post' action="">
				<ul class="list-inline">
					<?php
					if($UserLogin->permission()==true){
						?>
						<li>
							<select class="form-control" name="cbo_teacher">
								<option value="0"> -- Giáo viên --</option>
								<?php
								$sql="SELECT CONCAT(`firstname`,' ',`lastname`) AS 'fullname',`id` FROM tbl_user WHERE isactive=1 AND gid=2";
								$objmysql=new CLS_MYSQL();
								$objmysql->Query($sql);
								while ($row_m = $objmysql->Fetch_Assoc()) {
									echo'<option value="'.$row_m['id'].'">'.$row_m['fullname'].'</option>';
								}
								?>
							</select>
						</li>
						<?php
					}else{
						echo '<input type="hidden" name="cbo_teacher" value="'.$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['id'].'">';
					}
					?>
					<li>
						<select class="form-control" name="cbo_course">
							<option value="0"> -- Khóa học --</option>
							<?php
							$sql="SELECT `name`,`id` FROM tbl_course WHERE isactive=1";
							$objmysql=new CLS_MYSQL();
							$objmysql->Query($sql);
							while ($row_c = $objmysql->Fetch_Assoc()) {
								echo'<option value="'.$row_c['id'].'">'.$row_c['name'].'</option>';
							}
							?>
						</select>
					</li>
					<li><input type="button" id="btn_search" onclick="SearchMember()" class="btn btn-primary" name="" value="Tìm kiếm"></li>
				</ul>
			</form>
		</div>
		<div id="mem_course_list">
			<div class="list"></div>
		</div>
	</div>
</div>
<script>
	function getUserByGroup($strwhere){
		var url='ajaxs/report/getUserByGroup.php';
		$.post(url,{'strwhere':$strwhere},function(req){
			$('#mem_course_list .list').html(req);
		});
	}
	function SearchMember(){
		var data = $('#frm-search').serializeArray();
		var url = 'ajaxs/report/search_member.php';
		$.post(url,data,function(req){
			getUserByGroup(req);
		})
	}
</script>