<?php
class CLS_CONFIG{
	private $pro=array(
		'ID'=>'-1',			
		'Title'=>'',
		'CompanyName'=>'',	
		'Intro'=>'',
		'Address'=>'',		
		'Phone'=>'',
		'Tel'=>'',			
		'Fax'=>'',			
		'Email'=>'',
		'Meta_keyword'=>'',	
		'Meta_descript'=>'',
		'Langid'=>'',			
		'Website'=>'',
		'Banner'=>'',			
		'Logo'=>'',
		'Contact'=>'',		
		'Footer'=>'',
		'Temid'=>'',			
		'Nickyahoo'=>'',
		'Facebook'=>'',    
		'Twitter'=>'',
		'Gplus'=>'',    
		'Youtube'=>'',
		'Nameyahoo'=>'');
	private $objmysql=null;
	public function CLS_CONFIG(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USERS Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USERS Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList(){
		$sql="SELECT * FROM `tbl_configsite` WHERE `config_id`=1";
		return $this->objmysql->Query($sql); 
	}
	public function Num_rows() { 
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function Update(){
		$sql = "UPDATE tbl_configsite SET ";
		$sql .="title='".$this->Title."',";
		$sql .="company_name='".$this->CompanyName."',";
		$sql .="intro='".$this->Intro."',";
		$sql .="address='".$this->Address."',";
		$sql .="phone='".$this->Phone."',";
		$sql .="fax='".$this->Fax."',";
		$sql .="email='".$this->Email."',";

		$sql .="meta_keyword='".$this->Meta_keyword."',";
		$sql .="meta_descript='".$this->Meta_descript."',";

		$sql .="lang_id='".$this->Langid."',";

		$sql .="website='".$this->Website."',";
		$sql .="banner='".$this->Banner."',";
		$sql .="contact='".$this->Contact."',";
		$sql .="logo='".$this->Logo."',";
		$sql .="tem_id='".$this->Temid."',";
		$sql .="nick_yahoo='".$this->Nickyahoo."',";
		$sql .="name_yahoo='".$this->Nameyahoo."',";
		$sql .="footer='".$this->Footer."' WHERE config_id=1";
		return $this->objmysql->Query($sql);
	}
	public function Update2(){
		$sql = "UPDATE tbl_configsite SET ";
		$sql .="title='".$this->Title."',";
		$sql .="company_name='".$this->CompanyName."',";
		$sql .="phone='".$this->Phone."',";
		$sql .="tel='".$this->Tel."',";
		$sql .="fax='".$this->Fax."',";
		$sql .="email='".$this->Email."',";
		$sql .="address='".$this->Address."',";
		$sql .="meta_keyword='".$this->Meta_keyword."',";
		$sql .="twitter='".$this->Twitter."',";
		$sql .="gplus='".$this->Gplus."',";
		$sql .="facebook='".$this->Facebook."',";
		$sql .="youtube='".$this->Youtube."',";
		$sql .="meta_descript='".$this->Meta_descript."' WHERE config_id=1";
		return $this->objmysql->Query($sql);
	}
}
?>