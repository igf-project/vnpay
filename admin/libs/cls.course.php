<?php
class CLS_COURSE{
	private $pro=array(
			'ID'=>'-1',
			'Name'=>'',
			'Intro'=>'',
			'isActive'=>'1'
			);
	private $objmysql=NULL;
	
	public function CLS_COURSE(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_COURSE Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_COURSE Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_course` WHERE 1=1 ".$where.$limit;
		$this->objmysql->Query($sql);
	}
	public function getCourse($where=''){
		$sql="SELECT * FROM `tbl_course` WHERE `isactive`=1 ".$where;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()){
			echo "<ul class='menu'>";
			while($r=$objdata->Fetch_Assoc()){
				$id=$r["id"];
				$name=$r["name"];
				echo "<li><a href='javascript:void(0);' onclick='course_select(this);' dataid='$id'>$name</a></li>";
			}
			echo "</ul>";
		}
	}
	public function Num_rows() { 
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_course` (`name`,`intro`,`isactive`) VALUES ";
		$sql.=" ('".$this->Name."','".$this->Intro."','".$this->isActive."') ";
		echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	function Update(){		 
		$sql="UPDATE `tbl_course` SET `name`='".$this->Name."',
										`intro`='".$this->Intro."'
										`isactive`='".$this->isActive."' ";
		$sql.=" WHERE `id`='".$this->ID."'";
		echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	
	// set active template
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_course` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_course` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Delete($memid){
		$sql="DELETE FROM `tbl_course` WHERE `id` in ('$memid')";
		return $this->objmysql->Query($sql);
	}
}
?>