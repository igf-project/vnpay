<?php
class CLS_DOCUMENT_TYPE {
	private $objmysql;
	public function CLS_DOCUMENT_TYPE(){
		$this->objmysql=new CLS_MYSQL;
	}
	
	public function getList($strwhere="",$lagid=0){
		$sql=" SELECT * FROM tbl_document_type WHERE isactive=1 $strwhere";
		return $this->objmysql->Query($sql);
	}

	public function getInfo($where='',$limit=''){
        $sql="SELECT * FROM `tbl_document_type` WHERE isactive=1 ".$where.$limit;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $row = $objdata->Fetch_Assoc();
        return $row;
    }

	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function getCatIDParent($parid){
        $sql="SELECT * FROM `tbl_document_type` WHERE isactive=1 AND doctype_id='$parid' ";
        $objdata=new CLS_MYSQL();
        $this->result=$objdata->Query($sql);
        $par_cate=array();
        if($objdata->Num_rows()>0) {
            while ($rows=$objdata->Fetch_Assoc()) {
                $par_cate=$this->getCatIDParent($rows['par_id']);
                $par_cate[]=$rows['name'];
            }
        }
        return $par_cate;
    }

	function getListBox(){
		$sql="SELECT * FROM tbl_document_type WHERE `isactive`='1' ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);

		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['doctype_id'];
			$title=$rows['name'];
			echo "<option value='$id'> $title</option>";
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
	
	public function getNameById($ids){
		$sql = "SELECT name FROM tbl_document_type WHERE doctype_id IN ('$ids')";
		$objdata = new CLS_MYSQL; 
		$objdata->Query($sql);
		$row = $objdata->Fetch_Assoc();
		return $row['name'];
	}
}
?>