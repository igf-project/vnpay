<?php
class CLS_MENU{
	private $pro=array(
		'ID'=>'-1',
		'Code'=>'',
		'Name'=>'',
		'Desc'=>'',
		'LangID'=>'0',
		'isActive'=>1
		);
	private $objmysql=NULL;
	public function CLS_MENU(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MENU class ' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MENU Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	function getList($where='',$limit=''){
		$sql='SELECT * FROM `view_menu` '.$where.' ORDER BY `name` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getListmenu($type){
		$this->getList(' WHERE isactive=1','');
		$str='';
		while($rows=$this->Fetch_Assoc()){
			if($type=='list')
				$str.="<li><a href=\"index.php?com=mnuitem&mnuid=".$rows["id"]."\">".$rows["name"]."</a></li>";
			else if($type=="option")
				$str.="<option value=\"".$rows["id"]."\">".$rows["name"]."</option>";
			else 
				$str.=$rows['name'];
		}
		return $str;
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_menus`(`code`,`desc`,`isactive`) VALUES ";
		$sql.=" ('".$this->Code."','".$this->Desc."','".$this->isActive."') ";
		$this->objmysql->Exec("BEGIN");
		$result=$this->objmysql->Exec($sql);

		$id=$this->objmysql->LastInsertID();
		$sql="INSERT INTO `tbl_menus_text`(`mnu_id`,`name`,`lag_id`) VALUES";
		$sql.="('$id','".$this->Name."','".$this->LangID."')";
		$result1=$this->objmysql->Exec($sql);

		if($result && $result1 ){
			$this->objmysql->Exec('COMMIT');
			return true;
		}else {
			$this->objmysql->Exec('ROLLBACK');
			return false;
		}
	}
	function Update(){
		$sql="UPDATE `tbl_menus` SET `code`='".$this->Code."',
		`desc`='".$this->Desc."',
		`isactive`='".$this->isActive."' ";
		$sql.=" WHERE `id`='".$this->ID."'";
		$this->objmysql->Exec("BEGIN");
		$result=$this->objmysql->Exec($sql);

		$sql="UPDATE `tbl_menus_text` SET `name`='".$this->Name."'";
		$sql.=" WHERE `mnu_id`='".$this->ID."'";
		$result1=$this->objmysql->Exec($sql);

		if($result && $result1 ){
			$this->objmysql->Exec('COMMIT');
			return true;
		}else {
			$this->objmysql->Exec('ROLLBACK');
			return false;
		}
	}
	function Delete($ids){
		$sql="DELETE FROM `tbl_menus` WHERE `id` in ('$ids')";
		$result=$this->objmysql->Exec($sql);
		$this->objmysql->Exec("BEGIN");

		$sql="DELETE FROM `tbl_menus_text` WHERE `mnu_id` in ('$ids')";
		$result1=$this->objmysql->Exec($sql);

		if($result && $result1 ){
			$this->objmysql->Exec('COMMIT');
			return true;
		}else {
			$this->objmysql->Exec('ROLLBACK');
			return false;
		}
	}
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_menus` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_menus` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
}
?>