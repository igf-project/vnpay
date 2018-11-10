<?php
class CLS_USER_GROUP{
	private $pro=array(
		'ID'=>'-1',
		'Name'=>'',
		'Intro'=>'',
		'isActive'=>1
		);
	private $objmysql=NULL;
	public function CLS_USER_GROUP(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USER_GROUP Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USER_GROUP Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql='SELECT * FROM `tbl_user_group` '.$where.' ORDER BY `name` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	function getListGmem(){
        $sql="SELECT * FROM tbl_user_group WHERE `isactive`='1' ";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $title=$rows['name'];
            echo "<option value='$id'>$title</option>";
        }
    }
	function listTableGmem($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_user_group` WHERE 1=1 ".$strwhere ." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$name=$rows['name'];
			$intro= stripslashes(uncodeHTML($rows['intro']));
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" onclick=\"docheckonce('chk');\" value=\"$id\" />";
			echo "</label></td>";
			echo "<td nowrap=\"nowrap\"><a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$id\">$name</a></td>";
			echo "<td nowrap=\"nowrap\">$intro &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$id\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";

			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";			
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$id\">";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$id')\">";
			showIconFun('delete','');
			echo "</a>";			
			echo "</td>";
			echo "</tr>";
		}
	}
	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `name` FROM `tbl_user_group`  WHERE isactive=1 AND `id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_user_group` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_user_group` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_user_group`(`name`,`isactive`) VALUES ";
		$sql.=" (\"".$this->pro["Name"]."\",\"".$this->pro["isActive"]."\") ";
		echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	function Update(){
		$sql="UPDATE `tbl_user_group` SET `name`=\"".$this->pro["Name"]."\",`isactive`=\"".$this->pro["isActive"]."\" ";
		$sql.=" WHERE `id`=\"".$this->pro["ID"]."\"";
		echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	function Delete($id){
		$sql="DELETE FROM `tbl_user_group` WHERE `id` in ('$id')";
		return $this->objmysql->Query($sql);
	}
}
?>