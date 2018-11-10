<?php
//ini_set('display_error',1);
class CLS_MENUITEM{
	private $pro=array(
		'ID'=>'-1',
		'Par_ID'=>'0',
		'Code'=>'',
		'Name'=>'default',
		'Intro'=>'',
		'Mnu_ID'=>'0',
		'Viewtype'=>'block',
		'Cate_ID'=>'0',
		'Con_ID'=>'0',
		'Cate_intro'=>'0',
		'Introduct'=>'0',
		'Cate_service'=>'0',
		'Service'=>'0',
		'Cate_partner'=>'0',
		'Partner'=>'0',
		'Gdoc_ID'=>'0',
		'Document'=>'0',
		'Question_group'=>'0',
		'Question'=>'0',
		'Cate_guide'=>'0',
		'Guide'=>'0',
		'Cate_recruitment'=>'0',
		'Recruitment'=>'0',
		'Link'=>'',
		'Class'=>'',
		'Order'=>'',
		'LangID'=>'0',
		'isActive'=>1
		);
	private $rowcount=0;
	private $objmysql=NULL;
	public function CLS_MENUITEM(){
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
		$sql="SELECT * FROM `view_menuitem` ".$where.' ORDER BY `order` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getListMenuItem($mnuid,$par_id,$level){
		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0)
			return;
		$strspace="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$strspace.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$strspace.="|---";
		}
		$str="";
		while($rows=$objdata->Fetch_Assoc()){
			$str.="<option onclick=\"getIDs();\" value=\"".$rows["id"]."\" >".$strspace.$rows["name"]."</option>";
			$nextlevel=$level+1;
			$str.=$this->getListMenuItem($mnuid,$rows["id"],$nextlevel);
		}
		return $str;
	}
	public function getLevelChild($parid,$level=1){
		$sql=" SELECT * FROM view_menuitem WHERE id= $parid AND isactive=1 ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql); 
		if($objdata->Num_rows()>0){
			$number = $level++;
			$rows = $objdata->Fetch_Assoc();
			$this->getLevelChild($rows['par_id'],$number);
		}
		return $level;
	}
	public function listTableItemMenu($strwhere="",$page,$par_id,$level){
		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' ".$strwhere." ORDER BY `order` ASC, id ASC";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$str_space="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$str_space.="&nbsp;&nbsp;&nbsp;";
			$str_space.="|---";
		}
		while($rows=$objdata->Fetch_Assoc()){
			$this->rowcount++;
			$mnuids=$rows['id'];
			$par_id=$rows['par_id'];
			$code=$rows['code'];
			$order=$rows['order'];
			$name=Substring($rows['name'],0,10);
			$type=$rows['viewtype'];
			echo "<tr name='trow'>";
			echo "<td width='30' align='center'><label>";
			echo "<input type='checkbox' name='chk' id='chk' onclick=\"docheckonce('chk');\" value='$mnuids' />";
			echo "</label></td>";
			echo "<td width='50' align='center'>$par_id</td>";
			echo "<td>$str_space $name</td>";
			echo "<td align='left'>$str_space $code</td>";
			echo "<td width='100' align='center'>$type &nbsp;</td>";
			echo "<td width='50' align='center'><input type='text' name='txt_order' id='txt_order' value='$order' size='4' class='order'></td>";
			echo "<td width='50' align='center'>";
			echo "<a href='".ROOTHOST_ADMIN.COMS."/active/$mnuids'>";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			echo "</td>";
			echo "<td width='50' align='center'>";
			echo "<a href='".ROOTHOST_ADMIN.COMS."/edit/$mnuids'>";
			showIconFun('edit','');
			echo "</a>";			
			echo "</td>";
			echo "<td width='50' align='center'>";
			echo "<a href='".ROOTHOST_ADMIN.COMS."/delete/$mnuids' onclick=\"return confirm('Do you want to delete this record?');\">";
			showIconFun('delete','');
			echo "</a>";
			echo "</td>";
			echo "</tr>";
			$nextlevel=$level+1;
			$this->listTableItemMenu($strwhere,$page,$mnuids,$nextlevel);
		}
	}
	public function getChildID($parid) {
		$sql = "SELECT id FROM tbl_mnuitem WHERE par_id IN ('$parid')"; 
		$this->objmysql->Query($sql);
		$ids='';
		if($this->objmysql->Num_rows()>0) {
			while($r = $this->objmysql->Fetch_Assoc()) {
				$ids.=$r[0]."','";
				$ids.=$this->getChildID($r[0]);
			}
		}
		return $ids;
	}
	public function Add_new(){
		$sql="INSERT INTO `tbl_mnuitem`(`par_id`,`code`,`mnu_id`,`viewtype`,`cate_id`,`con_id`,`link`,`cate_intro_id`,`introduct_id`,`cate_service_id`,`service_id`,`cate_partner_id`,`partner_id`,`gdoc_id`,`doc_id`,`question_group_id`,`question_id`,`cate_guide_id`,`guide_id`,`cate_recruitment_id`,`recruitment_id`,`class`,`isactive`) VALUES ";
		$sql.=" ('".$this->Par_ID."','".$this->Code."','".$this->Mnu_ID."','".$this->Viewtype."','".$this->Cate_ID."','".$this->Con_ID."','".$this->Link."','".$this->Cate_intro."','".$this->Introduct."','".$this->Cate_service."','".$this->Service."','".$this->Cate_partner."','".$this->Partner."','".$this->Gdoc_ID."','".$this->Document."','".$this->Question_group."','".$this->Question."','".$this->Cate_guide."','".$this->Guide."','".$this->Cate_recruitment."','".$this->Recruitment."','".$this->Class."','".$this->isActive."') ";
		// echo $sql;
		$this->objmysql->Exec("BEGIN");
		$result = $this->objmysql->Exec($sql);
		$mnuitemid=$this->objmysql->LastInsertID();

		$sql="INSERT INTO `tbl_mnuitem_text`(`mnuitem_id`,`name`,`intro`,`lag_id`) VALUES ";
		$sql.=" ('$mnuitemid','".$this->Name."','".$this->Intro."','".$this->LangID."')";
		// echo $sql;die();
		$result1=$this->objmysql->Exec($sql);

		if($result && $result1){
			$this->objmysql->Exec('COMMIT');
			return true;
		}else{
			$this->objmysql->Exec('ROLLBACK');
			return false;
		}
	}
	function Update(){
		$sql="UPDATE `tbl_mnuitem` SET  `par_id`='".$this->Par_ID."',
		`code`='".$this->Code."',
		`mnu_id`='".$this->Mnu_ID."',
		`viewtype`='".$this->Viewtype."',
		`cate_id`='".$this->Cate_ID."',
		`con_id`='".$this->Con_ID."',
		`link`='".$this->Link."',
		`cate_intro_id`='".$this->Cate_intro."',
		`introduct_id`='".$this->Introduct."',
		`cate_service_id`='".$this->Cate_service."',
		`service_id`='".$this->Service."',
		`cate_partner_id`='".$this->Cate_partner."',
		`partner_id`='".$this->Partner."',
		`gdoc_id`='".$this->Gdoc_ID."',
		`doc_id`='".$this->Document."',
		`question_group_id`='".$this->Question_group."',
		`question_id`='".$this->Question."',
		`cate_guide_id`='".$this->Cate_guide."',
		`guide_id`='".$this->Guide."',
		`cate_recruitment_id`='".$this->Cate_recruitment."',
		`recruitment_id`='".$this->Recruitment."',
		`class`='".$this->pro['Class']."',
		`isactive`='".$this->isActive."'";
		$sql.=" WHERE `id`='".$this->ID."'";
		// echo $sql;
		$this->objmysql->Exec("BEGIN");
		$result=$this->objmysql->Exec($sql);
		$sql="UPDATE `tbl_mnuitem_text` SET `intro`='".$this->Intro."',`name`='".$this->Name."'";
		$sql.=" WHERE `mnuitem_id`='".$this->ID."'";
		// echo $sql;die();
		$result1=$this->objmysql->Exec($sql);
		if($result && $result1){
			$this->objmysql->Exec('COMMIT');
			return true;
		}else{
			$this->objmysql->Exec('ROLLBACK');
			return false;
		}
	}
	function Order($arr_id,$arr_quan){
		$n=count($arr_id);
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_mnuitem` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
	}
	function setActive($ids,$status=''){
		$sql="UPDATE `tbl_mnuitem` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_mnuitem` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Delete($ids){
		$sql="DELETE FROM `tbl_mnuitem` WHERE `id` in ('$ids')";
		$this->objmysql->Exec('BEGIN');
		$result=$this->objmysql->Exec($sql);

		$sql="DELETE FROM `tbl_mnuitem_text` WHERE `mnuitem_id` in ('$ids')";
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