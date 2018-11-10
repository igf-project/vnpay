<?php
class CLS_GUSER{
	private $pro=array(
					  'ID'=>'-1',
					  'ParID'=>'0',
					  'Name'=>'',
					  'Intro'=>'',
					  'Permission'=>0,
					  'isAdmin'=>'1',
					  'isActive'=>1
					  );
	private $objmysql=NULL;
	public function CLS_GUSER(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_GUSER Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_GUSER Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql='SELECT * FROM `tbl_user_group` WHERE 1=1 '.$where.$limit;
		return $this->objmysql->Query($sql);
	}
	public function getListTree($par_id=0,$gid=0){
		$sql='SELECT * FROM `tbl_user_group` WHERE par_id='.$par_id.' AND `isactive`=1 ORDER BY `gmem_id` ASC';
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			$str='';
			while($rows=$objdata->Fetch_Assoc()){
				$str.="<item text='".$rows['name']."' id='".$rows['gmem_id']."' open='1'>";
				$str.=$this->getListTree($rows['gmem_id']);
				$str.="</item>";
			}
			return $str;
		}
		else return '';
	}
	public function getIDbyName($name=''){
		$sql='SELECT gmem_id FROM `tbl_user_group` WHERE name="'.$name.'" AND `isactive`=1';
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			$r=$objdata->Fetch_Assoc();
			return $r['gmem_id'];
		} return '';
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	function getListGmem($parid,$level){
		$sql="SELECT * FROM `tbl_user_group` WHERE `par_id`='$parid' AND `isactive`='1' ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="|";
		if($level>0){
			for($i=0;$i<$level;$i++)
				$char.="--";
		}
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows["id"];
			$name=$rows["name"];
			echo "<option value='$id'>$char$name</option>";
			$this->getListGmem($id,++$level);
		}
	}
	function listTableGmem($strwhere="",$page,$parid,$level){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_user_group` WHERE `par_id`='$parid' ".$strwhere ." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$str_space="";
		if($level!=0){
			for($i=1;$i<$level;$i++)
				$str_space.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$str_space.="|--- ";
		}
		while($rows=$objdata->Fetch_Assoc())
		{
			$id=$rows['gmem_id'];
			$parid=$rows['par_id'];
			$name=$rows['name'];
			$intro= stripslashes(uncodeHTML($rows['intro']));
			echo "<tr name='trow'>";
			echo "<td width='30' align='center'><label>";
			echo "<input type='checkbox' name='chk' id='chk' onclick='docheckonce('chk');' value='$id' />";
			echo "</label></td>";
			echo "<td width='50' align='center'>$parid</td>";
			echo "<td nowrap='nowrap'>
				<a href='index.php?com=".COMS."&amp;task=edit&amp;id=$id'>$str_space$name</a>
			</td>";
			echo "<td nowrap='nowrap'>$intro &nbsp;</td>";
			echo "<td width='50' align='center'>";
			echo "<a href='index.php?com=".COMS."&amp;task=active&amp;id=$id'>";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width='50' align='center'>";			
				echo "<a href='index.php?com=".COMS."&amp;task=edit&amp;id=$id'>";
				showIconFun('edit','');
				echo "</a>";
			echo "</td>";
			echo "<td width='50' align='center'>";
				echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$id')\">";
				showIconFun('delete','');
				echo "</a>";			
			echo "</td>";
		  	echo "</tr>";
			
			$this->listTableGmem($strwhere,$page,$id,$level+1);
		}
	}
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_user_group` SET `isactive`='$status' WHERE `gmem_id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_user_group` SET `isactive`=if(`isactive`=1,0,1) WHERE `gmem_id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_user_group`(`par_id`,`name`,`intro`,`permission`,`isadmin`,`isactive`) VALUES ";
		$sql.=" ('".$this->pro["ParID"]."','".$this->pro["Name"]."','".$this->pro["Intro"]."',".$this->pro["Permission"].",'".$this->pro["isAdmin"]."','".$this->pro["isActive"]."') ";
		return $this->objmysql->Exec($sql);
	}
	function Update(){
		$sql="UPDATE `tbl_user_group` SET `par_id`='".$this->pro["ParID"]."',
				`name`='".$this->pro["Name"]."',
				`intro`='".$this->pro["Intro"]."',
				`permission`=".$this->pro["Permission"].",
				`isadmin`='".$this->pro["isAdmin"]."',
				`isactive`='".$this->pro["isActive"]."' ";
		$sql.=" WHERE `gmem_id`='".$this->pro["ID"]."'";
		return $this->objmysql->Exec($sql);
	}
	function Delete($id){
		$sql="DELETE FROM `tbl_user_group` WHERE `gmem_id` in ('$id')";
		return $this->objmysql->Query($sql);
	}
}
?>