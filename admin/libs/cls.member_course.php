<?php
class CLS_MEMBER_COURSE{
	private $pro=array(
		'ID'=>'-1',
		'Name'=>'',
		'Intro'=>'',
		'isActive'=>'1'
		);
	private $objmysql=NULL;
	
	public function CLS_MEMBER_COURSE(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MEMBER_COURSE Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MEMBER_COURSE Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_member_course` WHERE 1=1 ".$where.$limit;
		$this->objmysql->Query($sql);
	}
	public function getInfo($where=''){
		$sql="SELECT * FROM `tbl_member_course` WHERE 1=1 ".$where;
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row;
	}
	public function Num_rows() { 
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getmemberbymemcourseID($ids){
		$sql="SELECT tbl_member.id AS mem_id, fullname FROM tbl_member 
		LEFT JOIN tbl_member_course ON tbl_member_course.mem_id = tbl_member.id 
		WHERE tbl_member_course.id IN($ids)";
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$str='';
		if($objdata->Num_rows()>0){
			while ($row = $objdata->Fetch_Assoc()) {
				$str.=$row['fullname'].'<br>';
			}
		}
		return $str;
	}
	public function getInfoMem($id){
		$sql="SELECT * FROM tbl_member WHERE isactive=1 AND id=$id";
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row;
	}
	public function getNameMemByID($id){
		$sql="SELECT `fullname` FROM tbl_member WHERE isactive=1 AND id=$id";
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row['fullname'];
	}
	public function getNameUserByID($id){
		$sql="SELECT CONCAT(`lastname`,' ',`firstname`) AS 'fullname' FROM tbl_user WHERE isactive=1 AND id=$id";
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row['fullname'];
	}
	public function getNameCourseByID($id){
		$sql="SELECT `name` FROM tbl_course WHERE isactive=1 AND id=$id";
		$objdata = new CLS_MYSQL();
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row['name'];
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_member_course` (`name`,`intro`,`isactive`) VALUES ";
		$sql.=" ('".$this->Name."','".$this->Intro."','".$this->isActive."') ";
		echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	function Update(){		 
		$sql="UPDATE `tbl_member_course` SET `name`='".$this->Name."',
		`intro`='".$this->Intro."'
		`isactive`='".$this->isActive."' ";
		$sql.=" WHERE `id`='".$this->ID."'";
		echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	
	// set active template
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_member_course` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_member_course` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Delete($memid){
		$sql="DELETE FROM `tbl_member_course` WHERE `id` in ('$memid')";
		return $this->objmysql->Query($sql);
	}
}
?>