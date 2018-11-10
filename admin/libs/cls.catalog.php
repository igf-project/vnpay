<?php
class CLS_CATALOG{
	private $pro=array(
		'Id'=>0,
		'Par_Id'=>0,
		'Name'=>'',
		'Intro'=>'',
		'Class'=>'',
		'ProIds'=>'',
		'Order'=>0,
		'MetaTitle'=>'',
		'MetaDesc'=>'',
		'isactive'=>1
	);
	private $objmysql=null;
	function CLS_CATALOG(){
		$objmysql=new CLS_MYSQL;
	}
	function __set($proname,$value){
		$objmysql->__set($proname,$value);
	}
	function __get($proname){
		$objmysql->__get($proname);
	}
}