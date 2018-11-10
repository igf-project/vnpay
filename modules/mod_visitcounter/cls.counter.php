<?php
class CLS_COUNTER{
	private $pro=array(	'id'=>0,
						'Ip'=>'',
						'Date'=>'',
						'isOnline'=>1);
	private $objmysql=null;
	public function CLS_COUNTER(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo 'Lỗi';
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo 'Lỗi';
			return;
		}
		return $this->pro[$proname];
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function getList($where=''){
		$sql="SELECT * FROM tbl_visit ".$where;
		return $this->objmysql->Query($sql);
	}
	public function addnew(){
		$sql="INSERT INTO tbl_visit(`ip`,`date`) VALUES('".$this->Ip."','".$this->Date."')";
		//echo $sql;
		return $this->objmysql->Query($sql);
	}
	public function update($ip){
		$sql="UPDATE tbl_visit SET `isonline`='0' WHERE `ip`='$ip'";
		return $this->objmysql->Query($sql);
	}
	public function showvisit(){
		$sql="UPDATE tbl_visit SET `isonline`='0' WHERE `date`<'".date('Y-m-d')."'";
		$this->objmysql->Query($sql);
		$online=1;
		$today=1;
		$monday=1;
		$all=26584;
		$this->getList(' WHERE `isonline`=1');
		$online+=$this->Num_rows();
		$this->getList(" WHERE `date`='".date('Y-m-d')."'");
		$today+=$this->Num_rows();
		$this->getList(" WHERE month(`date`)='".date('m')."'");
		$monday+=$this->Num_rows();
		$this->getList();
		$all+=$this->Num_rows();
		$all=substr($all,strlen($all)-7,7);
		echo "<div class='visit'>";
		$arr=array();
		for($i=0;$i<strlen($all);$i++){
			$arr[$i]=substr($all,$i,1);
			echo "<span class='num".$arr[$i]."'></span>";
		}
		echo "</div>";
		echo "<div class='online'>Đang trực tuyến: <strong>$online</strong></div>";
		echo "<div class='today'>Hôm nay: <strong>$today</strong></div>";
		echo "<div class='month'>Trong tháng: <strong>$monday</strong></div>";
		echo "<div class='all'>Tổng lượt truy cập: <strong>$all</strong></div>";
	}
}