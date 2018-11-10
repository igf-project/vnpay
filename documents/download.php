<?php
include_once('../includes/gfconfig.php');
include_once('../includes/gfinnit.php');
include_once('../libs/cls.mysql.php');
$obj=new CLS_MYSQL;
if(isset($_GET['id_doc'])) $id_doc=addslashes($_GET['id_doc']);

$sql="SELECT `url`,`fullurl` FROM `tbl_document` WHERE `id`=$id_doc";
$sql_update="UPDATE tbl_document SET `downloads`=`downloads`+1 WHERE `id`=$id_doc";
$obj->Query($sql);
$row=$obj->Fetch_Assoc();
$filename=$row['url'];
$fullurl = $row['fullurl'];
$abc = ROOTHOST.'documents/';
$path = str_replace($abc," ",$fullurl);
$path =explode("/",$path);
if(count($path)>1){
    $path=$path[0].'/';
}else{
    $path="";
}
$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\].]|[\.]{2,})", '', $filename); // simple file name validation
$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
$fullPath = $path.$dl_file;
// echo $fullPath;die();
if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);

    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
        break;
        // add more headers for other content types here
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
        break;
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
$obj->Query($sql_update);
fclose ($fd);
unset($obj);
exit;
?>