<?php
class CLS_DOCUMENT{
	private $pro=array(
		'ID'=>'-1',
		'TypeID'=>'0',
		'Name'=>'',
		'Code'=>'0',
		'Intro'=>'',
		'Content'=>'',
		'Url'=>'',
		'Fullurl'=>'',
		'Author'=>'',
		'Filetype'=>'',
		'Filesize'=>'',
		'Date_issued'=>'',
		'Cdate'=>'',
		'Mdate'=>'',
		'Pages'=>'',
		'Views'=>'',
		'Downloads'=>'',
		'Order'=>'',
		'Mtitle'=>'',
		'Mkey'=>'',
		'Mdesc'=>'',
		'IsActive'=>1);
	private $objmysql;
	public function CLS_DOCUMENT(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_DOCUMENT Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_DOCUMENT Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($strwhere="",$lagid=0){
		$sql=" SELECT * FROM tbl_document WHERE 1=1 $strwhere";
		// echo $sql;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function LoadGmem($cur_id=0,$par_id=0,$space){
		if($par_id!='0')	$space.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$char='';
		if($space!='') $char=$space.'|---';
		
		$sql="SELECT * FROM `tbl_gmember` WHERE par_id=$par_id";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->Fetch_Assoc())
		{
			$modid=$rows['id'];
			$name=$rows['name'];
			if($cur_id==$modid)
				echo "<option value=\"$modid\" selected=\"selected\">$char$name</option>";
			else
				echo "<option value=\"$modid\">$char$name</option>";
			$this->LoadGmem($cur_id,$modid,$space);
		}
	}
	public function getTypeName($TypeID) {
		$sql="SELECT name from tbl_document_type where id='$TypeID'";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			$r=$objdata->Fetch_Assoc();
			return $r['name'];
		}
	}
	public function listTable($strwhere="",$page){
		$star=0;
		if($page>1) $star=($page-1)*MAX_ROWS_ADMIN;
		$leng=MAX_ROWS_ADMIN;
		$sql="	SELECT * FROM tbl_document WHERE 1=1 $strwhere ORDER BY id DESC LIMIT $star,$leng"; 
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->Fetch_Assoc()){
			$i++;
			$ids=$rows['id'];
			$name=Substring(stripslashes($rows['name']),0,10);
			$author=$rows['author'];
			include_once('libs/cls.document_type.php');
			$obj_doctype = new CLS_DOCUMENT_TYPE();
			$doctype_name = $obj_doctype->getNameById($rows['type_id']);
			$order=$rows['order'];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
			echo "</label></td>";
			echo "<td>$name</td>";
			echo "<td>$doctype_name</td>";
			echo "<td>$author &nbsp;</td>";
			echo "<td align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";

			echo "<td align=\"center\">";

			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$ids\">";
			showIconFun('publish',$rows['isactive']);
			echo "</a>";

			echo "</td>";
			echo "<td align=\"center\">";

			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$ids\">";
			showIconFun('edit','');
			echo "</a>";

			echo "</td>";
			echo "<td align=\"center\">";

			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$ids')\" >";
			showIconFun('delete','');
			echo "</a>";

			echo "</td>";
			echo "</tr>";
		}
	}

	public function Add_new(){
		$sql="INSERT INTO `tbl_document` (`type_id`,`name`,`code`,`url`,`fullurl`,`author`,`filetype`,`filesize`,`cdate`,`isactive`) VALUES ";
		$sql.="('".$this->TypeID."','".$this->Name."','".$this->Code."','".$this->Url."','".$this->Fullurl."','".$this->Author."','".$this->Filetype."','".$this->Filesize."','";
		$sql.=$this->Cdate."','".$this->IsActive."')";
		return $this->objmysql->Exec($sql);
	}
	
	public function Update(){
		$sql="UPDATE `tbl_document` SET  
		`type_id`='".$this->TypeID."',
		`name`='".$this->Name."',
		`url`='".$this->Url."',
		`fullurl`='".$this->Fullurl."',
		`author`='".$this->Author."',
		`filetype`='".$this->Filetype."',
		`filesize`='".$this->Filesize."',
		`mdate`='".$this->Mdate."',
		`isactive`='".$this->IsActive."' 
		WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($ids){
		$sql="DELETE FROM `tbl_document` WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_document` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_document` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Order($arr_id,$arr_quan){
		$n=count($arr_id); 
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_document` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
	}
	public function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++){
			$this->Order($arids[$i],$arods[$i]);
		}
	}
	// -----------------
	

	public function LoadConten($lagid=0){
		$sql="SELECT * FROM `tbl_document` WHERE isactive='1'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->Fetch_Assoc()){
			$ids=$rows['id'];
			$title=$rows['name'];
			echo "<option value=\"$ids\">$title</option>";
		}
	}
	

}
?>