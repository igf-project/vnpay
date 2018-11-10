<?php
$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	$isSecure = true;
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$isSecure = true;
}
$REQUEST_PROTOCOL = $isSecure ? 'https://' : 'http://';

define('ROOTHOST',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/vnpay/');
define('ROOTHOST_ADMIN',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/vnpay/admin/');
define('WEBSITE',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/vnpay/');
define('BASEVIRTUAL0',ROOTHOST.'images/');
define('IMG_DEFAULT',BASEVIRTUAL0.'user.png');

define('APP_ID','1663061363962371');
define('APP_SECRET','dd0b6d3fb803ca2a51601145a74fd9a8');

define('ROOT_PATH',''); 
define('TEM_PATH',ROOT_PATH.'templates/');
define('COM_PATH',ROOT_PATH.'components/');
define('MOD_PATH',ROOT_PATH.'modules/');
define('INC_PATH',ROOT_PATH.'includes/');
define('LAG_PATH',ROOT_PATH.'languages/');
define('EXT_PATH',ROOT_PATH.'extensions/');
define('EDI_PATH',EXT_PATH.'editor/');
define('DOC_PATH',ROOT_PATH.'documents/');
define('DAT_PATH',ROOT_PATH.'databases/');
define('IMG_PATH',ROOT_PATH.'images/');
define('MED_PATH',ROOT_PATH.'media/');
define('LIB_PATH',ROOT_PATH.'libs/');
define('JSC_PATH',ROOT_PATH.'js/');
define('LOG_PATH',ROOT_PATH.'logs/');

define('MAX_ROWS','20');
define('MAX_ROWS_ADMIN','6');
define('TIMEOUT_LOGIN','60');
define('URL_REWRITE','1');
define('MAX_ROWS_INDEX',40);

define('SMTP_SERVER','smtp.gmail.com');
define('SMTP_PORT','465');
define('SMTP_USER','xuanhuan2812@gmail.com');
define('SMTP_PASS','xuanhuantb');
define('SMTP_MAIL','xuanhuan2812@gmail.com');

define('SHOP_CODE','TD');//hàng tiêu dùng
define('SITE_NAME','seogoogle.com');
define('SITE_TITLE','');
define('SITE_DESC','');
define('SITE_KEY','');
define('COM_NAME','Copyright &copy; by Web DXPRO');
define('COM_CONTACT','');
define('THUMB_DEFAULT','ad/uploads/user.png');/* ding nghia ảnh mặc định khi khong load được ảnh*/
?>