<?php
class CLS_SCHEDULE{
	private $pro=array(
		'ID'=>'0',
		'IdBoss'=>'',
		'IdUser'=>'',
		'Task'=>'',
		'ScheduleTime'=>'',
		'AttachUser'=>'',
		'TimeNumber'=>'',
		'NumberUser'=>'',
		'Status'=>'0'
		);
	private $objmysql=null;
	public function CLS_SCHEDULE(){
		$this->objmysql=new CLS_MYSQL;
		$this->ScheduleTime=date('Y-m-d H:i:s');
	}
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
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
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}

	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM tbl_schedule ".$where.$limit;
		return $this->objmysql->Query($sql);
	}
	public function getDateTime($id){
		$sql="SELECT * FROM tbl_schedule_task WHERE member_course_id LIKE '%$id%' ORDER BY id DESC";
		return $this->objmysql->Query($sql);
	}	
	public function getSchedule($year,$month){
		$sql="SELECT isday FROM tbl_schedule_task WHERE YEAR(isday)=$year AND MONTH(isday)=$month "; 
		echo $sql;
		$this->objmysql->Query($sql);
		$arr = array();
		while($rows = $this->objmysql->Fetch_Assoc())
			array_push($arr,date("Y-m-d",$rows['isday']));
		return $arr;
	}	
}
?>