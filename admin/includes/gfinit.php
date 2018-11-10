<?php
define('HOSTNAME','localhost');
if(isset($_SESSION['LANGUAGE_ADMIN']) && $_SESSION['LANGUAGE_ADMIN']=='0') {
	define('DB_USERNAME','comvong_db1');
	define('DB_PASSWORD','JH0ENpt3vJ');
	define('DB_DATANAME','comvong_db1');
}else{
	define('DB_USERNAME','comvong_vnpay');
	define('DB_PASSWORD','GK4aQo62');
	define('DB_DATANAME','comvong_vnpay');
}
date_default_timezone_set("Asia/Ho_Chi_Minh");