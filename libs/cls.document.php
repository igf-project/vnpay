<?php
class CLS_DOCUMENT{
	private $objmysql;
	public function CLS_DOCUMENT(){
		$this->objmysql=new CLS_MYSQL;
	}
	
	public function getList($strwhere="",$lagid=0){
		$sql=" SELECT * FROM tbl_document WHERE isactive=1 $strwhere";
		return $this->objmysql->Query($sql);
	}

	public function getCount($where=''){
        $objdata=new CLS_MYSQL;
        $sql="SELECT count(id) as count FROM `tbl_document` WHERE isactive=1 ".$where;
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['count'];
    }

	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
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

	
	public function updateView($code){
        if(!isset($_SESSION['VIEW-DOCUMENT'])){
            $sql="UPDATE `tbl_document` SET `views`=`views`+1 WHERE `code`='$code'";
            $_SESSION['VIEW-DOCUMENT']=1;
            return $this->objmysql->Exec($sql);
        }
    }

}
?>