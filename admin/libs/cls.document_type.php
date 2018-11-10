<?php
class CLS_DOCUMENT_TYPE {
	var $obj=array(
		"ID"=>"-1",
		"ParID"=>"",
		"Name"=>"",
		"Code"=>"",
		"Count"=>"",
		"Content"=>"",
		"Order"=>"",
		"isActive"=>1
		);
	private $objmysql=null;
	public function CLS_DOCUMENT_TYPE(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function getList($where='',$lag_id=0){
		$sql="SELECT * FROM `tbl_document_type`  WHERE 1=1 ".$where; 
		// echo $sql;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	function getListBox(){
		$sql="SELECT * FROM tbl_document_type WHERE `isactive`='1' ";
		// echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);

		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['doctype_id'];
			$title=$rows['name'];
			echo "<option value='$id'> $title</option>";
		}
	}

	function getListCate($parid=0,$level=0){
        $sql="SELECT * FROM tbl_document_type WHERE `par_id`='$parid' AND `isactive`='1' ";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $char="";
        if($level!=0){
            for($i=0;$i<$level;$i++)
                $char.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
            $char.="|---";
        }
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['doctype_id'];
            $parid=$rows['par_id'];
            $title=$rows['name'];
            echo "<option value='$id'>$char $title</option>";
            $nextlevel=$level+1;
            $this->getListCate($id,$nextlevel);
        }
    }

	public function getListCategory($parid=0,$level=0){
        $sql="SELECT * FROM `tbl_document_type` WHERE `par_id`='$parid' AND `isactive`=1 ORDER BY `order` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $char="";
        if($level!=0){
            for($i=0;$i<$level;$i++)
                $char.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
            $char.="|---";
        }
        if($objdata->Num_rows()>0){
            echo "<ul class='menu'>";
            while($r=$objdata->Fetch_Assoc()){
                $id=$r["doctype_id"];
                $name=$r["name"];
                echo"<li data-id='$id'><a href='".ROOTHOST_ADMIN."document/document_type/$id'>$char $name</a></li>";
                $nextlevel=$level+1;
                $this->getListCategory($id,$nextlevel);
            }
            echo "</ul>";
        }
    }

	function getChildID($parid) {
		$sql = "SELECT doctype_id FROM tbl_document_type WHERE par_id IN ('$parid')";
		// echo $sql; 
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		
		$ids='';
		if($objdata->Num_rows()>0) {
			while($r = $objdata->Fetch_Assoc()) {
				$ids.=$r['doctype_id']."','";
				$ids.=$this->getChildID($r['doctype_id']);
			}
		}
		return $ids;
	}
	function getListDocType($parid=0,$level=0){
		$sql="SELECT doctype_id,par_id,name FROM tbl_document_type WHERE `par_id`='$parid' AND `isactive`='1' ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level!=0){
			$char.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$char.="|---";
		}
		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['doctype_id'];
			$parid=$rows['par_id'];
			$name=$rows['name'];
			echo "<option value='$id'>$char $name</option>";
			$nextlevel=$level+1;
			$this->getListDocType($id,$nextlevel);
		}
	}
	function ListDocumentType($minus_id=0,$cur_parid=0,$parid=0,$level=0){
		$childID='';
		if($minus_id!=0)
			$childID = $this->getChildID($minus_id);
		$sql="SELECT doctype_id,par_id,`name`, isactive FROM tbl_document_type WHERE `par_id`='$parid' AND doctype_id NOT IN ('".$childID."')"; 
		// echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level>1){
			for($i=0;$i<$level;$i++)
				$char.="&nbsp;&nbsp;&nbsp;"; 
			$char.="|---";
		}
		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['doctype_id'];
			$parid=$rows['par_id'];
			$name=$rows['name'];
			$str='';
			if($id==$cur_parid) $str=" selected='selected' ";
			if($rows['isactive']==0)
				echo '<option value="'.$id.'" style="color:red"'.$str.'>'.$char." ".$name.'</option>';
			else
				echo '<option value="'.$id.'"'.$str.'>'.$char." ".$name.'</option>';
			
			$nextlevel=$level+1;
			$this->ListDocumentType($minus_id,$cur_parid,$id,$nextlevel);
		}
	}
	function listTableDocumentType($strwhere="",$page=1,$parid=0,$level=0,$rowcount){
		global $rowcount;
		$sql="SELECT* FROM tbl_document_type WHERE `par_id`='$parid' ".$strwhere." ORDER BY `order` ASC";
		// echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$str_space="";
		if($level!=0){	
			for($i=0;$i<$level;$i++)
				$str_space.="&nbsp;&nbsp;&nbsp;"; 
			$str_space.="|---";
		}
		$i=0;
		$save = $parid;
		while($rows=$objdata->Fetch_Assoc()){	
			$rowcount++;
			$id=$rows['doctype_id'];
			$parid=$rows['par_id'];
			$name=Substring(stripslashes($rows['name']),0,10);
			$code=$rows['code'];
			$title=stripslashes($rows['name']);
			$order=$rows['order'];
			echo "<tr name='trow'>";
			echo "<td width='30' align='center'>$rowcount</td>";
			echo "<td width='30' align='center'><label>";
			echo "<input type='checkbox' name='chk' id='chk' onclick='docheckonce(\"chk\");' value='$id' />";
			echo "</label></td>";
			echo "<td width='60' align='center'>$parid</td>";
			echo "<td nowrap='nowrap'>$str_space$name</td>";
			echo "<td nowrap='nowrap'>$code</td>";
			echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";
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
			$nextlevel=$level+1;
			$this->listTableDocumentType($strwhere,$page,$id,$nextlevel,$rowcount);
		}
	}
	function Add_new(){
		$sql='INSERT INTO `tbl_document_type`(`par_id`,`code`,`name`,`isactive`) VALUES ';
		$sql.=' ("'.$this->ParID.'","'.$this->Code.'","'.$this->Name.'","'.$this->isActive.'")';
		// echo $sql;die();
		$objdata=new CLS_MYSQL();
		if($objdata->Query($sql)) 
			return true;
		else return false;
	}
	function Update(){
		$sql='UPDATE `tbl_document_type` SET `par_id`="'.$this->ParID.'",`code`="'.$this->Code.'",`name`="'.$this->Name.'",`isactive`="'.$this->isActive.'"';
		$sql.=' WHERE `doctype_id`="'.$this->ID.'"';
		$objdata=new CLS_MYSQL();
		if($objdata->Query($sql)) 
			return true;
		else return false;
	}
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_document_type` SET `isactive`='$status' WHERE `doctype_id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_document_type` SET `isactive`=if(`isactive`=1,0,1) WHERE `doctype_id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	function Orders($arr_id,$arr_quan){
		$n=count($arr_id); print_r($arr_id);
		for($i=0;$i<$n;$i++){
			$sql="UPDATE `tbl_document_type` SET `order`='".$arr_quan[$i]."' WHERE `doctype_id` = '".$arr_id[$i]."' ";
			$this->objmysql->Exec($sql);
		}
	}
	public function Delete($ids){
		$sql="DELETE FROM `tbl_document_type` WHERE `doctype_id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function getNameById($ids){
		$sql = "SELECT name FROM tbl_document_type WHERE doctype_id IN ('$ids')";
		$objdata = new CLS_MYSQL; 
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row['name'];
	}
}
?>