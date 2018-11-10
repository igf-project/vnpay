<?php
class CLS_TAGS {
	private $pro=array( 
		'ID'=>'-1',
		'Name'=>'',
		'Code'=>'',
		'Order'=>'',
		'MetaTitle'=>'',
		'MetaKey'=>'',
		'MetaDesc'=>'',
		'isActive'=>1);
	private $objmysql=NULL;
	public function CLS_TAGS(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ('Can not found $proname member');
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_tags` where 1=1 ".$where.' ORDER BY `order` '.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}


	public function getArrListTag(){
		$sql="SELECT `id` from `tbl_tags` where `isactive`=1  ";
		// echo $sql;
		$objdata=new CLS_MYSQL;
		$tmp=array();
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			while($row=$objdata->Fetch_Assoc()){
				array_push($tmp,$row['id']);
			}
			
		}
		return $tmp;
	}


	public function getListConidByTagId($tagid) {
		$sql="SELECT `list_conid` FROM `tbl_tags` WHERE id=$tagid";
		$objdata=new CLS_MYSQL;
		$list_conid="";
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			$r=$objdata->Fetch_Assoc();
			$list_conid=$r['list_conid'];
			$tmp=explode(",", $list_conid);
			$list_conid=join("','",$tmp);
			return $list_conid;
		}
	}
	public function getArrConIdByTagId($tagid) {
		$sql="SELECT `list_conid` FROM `tbl_tags` WHERE id=$tagid";
		$objdata=new CLS_MYSQL;
		
		$objdata->Query($sql);
		if($objdata->Num_rows()>0) {
			$r=$objdata->Fetch_Assoc();
			
			$tmp=explode(",", $r['list_conid']);
			
			return $tmp;
		}
	}

	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function listTable($strwhere="",$page=1){
		$star=0; if($page>1) $star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_tags` WHERE 1=1 ".$strwhere." ORDER BY `order` DESC LIMIT $star,$leng";
			// echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->Fetch_Assoc()){
			$i++;
			$id=$rows['id'];
			$name=$rows['name'];
			$code=$rows['code'];
			$order=$rows['order'];
			echo "<tr name='trow'>";
			echo "<td width='30' align='center'>$i</td>";
			echo "<td width='30' align='center'><label>";
			echo "<input type='checkbox' name='chk' id='chk' onclick='docheckonce(\"chk\");' value='$id' />";
			echo "</label></td>";
			echo "<td>$name &nbsp;</td>";
			echo "<td>$code &nbsp;</td>";
			echo "<td width=\"70\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";
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
			echo "<a href='javascript:detele_field(\"index.php?com=".COMS."&amp;task=delete&amp;id=$id\")'>";
			showIconFun('delete','');
			echo "</a>";
			echo "</td>";
			echo "</tr>";
		}
	}

	public function Add_new(){
		$sql="INSERT INTO `tbl_tags` (`name`,`code`,`meta_title`,`meta_key`,`meta_desc`,`isactive`) VALUES ";
		$sql.="('".$this->Name."','".$this->Code."','".$this->MetaTitle."','".$this->MetaKey."','".$this->MetaDesc."','".$this->isActive."')";
		return $this->objmysql->Exec($sql);
	}
	
	public function Update(){
		$sql="UPDATE `tbl_tags` SET  
		`name`='".$this->Name."',
		`code`='".$this->Code."',	
		`meta_title`='".$this->MetaTitle."',	
		`meta_key`='".$this->MetaKey."',	
		`meta_desc`='".$this->MetaDesc."',	
		`isactive`='".$this->isActive."' 
		WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($ids){
		$sql="DELETE FROM `tbl_tags` WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}

	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_tags` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_tags` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Order($arr_id,$arr_quan){
		$n=count($arr_id); 
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_tags` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
	}
	public function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++){
			$this->Order($arids[$i],$arods[$i]);
		}
	}
}
?>