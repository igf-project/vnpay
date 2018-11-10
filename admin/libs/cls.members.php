<?php
class CLS_MEMBERS{
	private $pro=array(
			'ID'=>'-1',
			'Fullname'=>'',
			'Birthday'=>'',
			'Gender'=>'',
			'Address'=>'',
			'Phone'=>'',
			'Email'=>'',
			'Identify'=>'',
			'Joindate'=>'',
			'LastLogin'=>'',
			'isActive'=>'1'
			);
	private $objmysql=NULL;
	
	public function CLS_MEMBERS(){
		$this->Joindate=date('Y-m-d h:i:s');
		$this->LastLogin=date('Y-m-d h:i:s');
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MEMBERS Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MEMBERS Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_member` WHERE 1=1 ".$where.$limit; 
		$this->objmysql->Query($sql);
	}
	public function getInfo($where=''){
		$sql="SELECT * FROM `tbl_member` WHERE 1=1 ".$where;
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
	public function checkUserExists($identify){
		$sql = "SELECT COUNT(id) FROM `tbl_member` WHERE `identify` ='$identify'";
		$this->objmysql->Query($sql);
		if($this->objmysql->Num_rows()>0) {
			return true;
		}
		return false;
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_member` (`fullname`,`birthday`,`gender`,`address`,`phone`,`email`,`identify`,`joindate`,`isactive`) VALUES ";
		$sql.=" ('".$this->Fullname."','".$this->Birthday."','".$this->Gender."','".$this->Address."','";
		$sql.=$this->Phone."','".$this->Email."','".$this->Identify."','";
		$sql.=$this->Joindate."','".$this->isActive."') ";
		// echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	function Update(){		 
		$sql="UPDATE `tbl_member` SET 	`fullname`='".$this->Fullname."',
										`birthday`='".$this->Birthday."',
										`gender`='".$this->Gender."',
										`address`='".$this->Address."',
										`phone`='".$this->Phone."',
										`email`='".$this->Email."',
										`identify`='".$this->Identify."',
										`isactive`='".$this->isActive."' ";
		$sql.=" WHERE `id`='".$this->ID."'";
		// echo $sql;die();
		return $this->objmysql->Query($sql);
	}
	
	// set active template
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_member` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_member` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Delete($memid){
		$sql="DELETE FROM `tbl_member` WHERE `id` in ('$memid')";
		return $this->objmysql->Query($sql);
	}
}
?>