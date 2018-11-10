<?php
define('HOSTNAME','localhost');
// if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='0'){
// 	define('DB_USERNAME','comvong_db1');
// 	define('DB_PASSWORD','JH0ENpt3vJ');
// 	define('DB_DATANAME','comvong_db1');
// }else{
// 	define('DB_USERNAME','comvong_vnpay');
// 	define('DB_PASSWORD','GK4aQo62');
// 	define('DB_DATANAME','comvong_vnpay');	
// }
if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='0'){
	define('DB_USERNAME','root');
	define('DB_PASSWORD','');
	define('DB_DATANAME','db_vnpay');
}else{
	define('DB_USERNAME','root');
	define('DB_PASSWORD','');
	define('DB_DATANAME','db_vnpay_en');	
}
date_default_timezone_set("Asia/Ho_Chi_Minh");