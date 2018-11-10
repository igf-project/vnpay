<?php
//ini_set('display_errors', '1');
class CLS_MODULE{
	private $pro=array(
		'ID'=>'-1',
		'Title'=>'',
		'Type'=>'menu',
		'ViewTitle'=>'1',
		'MnuID'=>'0',
		'Cate_ID'=>'0',
		'Cata_ID'=>'0',
		'Gdoc_ID'=>'0',
		'Album'=>'0',
		'Theme'=>'',
		'HTML'=>'',
		'Position'=>'',
		'Class'=>'',
		'LangID'=>'0',
		'Order'=>'',
		'isActive'=>1
		);
	private $objmysql=NULL;
	public function CLS_MODULE(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo $proname. ' can not found in module class';
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo $proname. ' can not found in module class';
			return;
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `view_module` WHERE isactive=1 ".$where." ORDER BY `position` ASC, `order` ASC ".$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getPosition(){
		$sql='SELECT DISTINCT `position` FROM `tbl_modules`';
		$this->objmysql->Query($sql);
		while($rows=$this->objmysql->Fetch_Assoc()){
			$pos=$rows['position'];
			echo "<option value=\"$pos\">$pos</option>";
		}
	}
	public function LoadModType(){
		$sql='SELECT * FROM `tbl_modtype` ';
		$this->objmysql->Query($sql);
		while($rows=$this->objmysql->Fetch_Assoc()){
			$code=$rows['code'];
			$name=$rows['name'];
			echo "<option value=\"$code\">$name</option>";
		}
	}
	public function getListMod($strwhere)
	{
		$sql='SELECT * FROM `tbl_modules` '.strwhere;
		$this->objmysql->Query($sql);
		while($rows=$this->objmysql->Fetch_Assoc()){
			$id=$rows['id'];
			$name=$rows['title'];
			echo "<option value=\"$id\">$title</option>";
		}
	}
	public function Add_new(){
		$sql='INSERT INTO `tbl_modules` (`type`,`viewtitle`,`mnu_id`,`cate_id`,`cata_id`,`gdoc_id`,`album`,`theme`,`position`,`class`,`isactive`) VALUES ';
		$sql.="('".$this->pro['Type']."','".$this->pro['ViewTitle']."','".$this->pro['MnuID']."','".$this->pro['Cate_ID']."','".$this->pro['Cata_ID']."','".$this->pro['Gdoc_ID']."','".$this->pro['Album']."','".$this->pro['Theme']."','".$this->pro['Position']."','".$this->pro['Class']."','".$this->pro['isActive']."')";

		$this->objmysql->Exec('BEGIN');
		$result=$this->objmysql->Exec($sql);

		$id=$this->objmysql->LastInsertID();
		$sql="INSERT INTO `tbl_modules_text` (`mod_id`,`title`,`content`,`lag_id`) VALUES ('$id','".$this->pro['Title']."','".$this->pro['HTML']."','".$this->pro['LangID']."')";

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
		$sql="UPDATE `tbl_modules` SET 
		`type`='".$this->pro['Type']."',
		`viewtitle`='".$this->pro['ViewTitle']."',
		`mnu_id`='".$this->pro['MnuID']."',
		`cate_id`='".$this->pro['Cate_ID']."',
		`cata_id`='".$this->pro['Cata_ID']."',
		`gdoc_id`='".$this->pro['Gdoc_ID']."',
		`album`='".$this->pro['Album']."',
		`theme`='".$this->pro['Theme']."',
		`position`='".$this->pro['Position']."',
		`class`='".$this->pro['Class']."',
		`isactive`='".$this->pro['isActive']."' 
		WHERE `id`='".$this->pro['ID']."'";
		$this->objmysql->Exec('BEGIN');
		$result=$this->objmysql->Exec($sql);

		$sql="UPDATE `tbl_modules_text` SET `title`='".$this->pro['Title']."',`content`='".$this->pro['HTML']."' WHERE `mod_id`='".$this->pro['ID']."' AND `lag_id`='".$this->pro['LangID']."'";
		$result1=$this->objmysql->Exec($sql);

		if($result && $result1 ){
			$this->objmysql->Exec('COMMIT');
			return true;
		}else {
			$this->objmysql->Exec('ROLLBACK');
			return false;
		}
	}
	function Order($arr_id,$arr_quan){
		$n=count($arr_id); print_r($arr_id);
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_modules` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
	}
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_modules` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_modules` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Delete($ids){
		$sql="DELETE FROM `tbl_modules` WHERE `id` in ('$ids')";
		$this->objmysql->Exec('BEGIN');
		$result=$this->objmysql->Exec($sql);

		$sql="DELETE FROM `tbl_modules_text` WHERE `mod_id` in ('$ids')";
		$result1=$this->objmysql->Exec($sql);

		if($result && $result1 ){
			$this->objmysql->Exec('COMMIT');
			return true;
		}else {
			$this->objmysql->Exec('ROLLBACK');
			return false;
		}
	}
}
?>