<?php
ob_start(); 
defined("ISHOME") or die("Can't acess this page, please come back!");
if(isset($_GET['code'])){
    $getcode = addslashes(strip_tags($_GET['code']));
    $obj->updateView($getcode);
    $strWhere=' AND `code`="'.$getcode.'"';
}
else die("PAGE NOT FOUND");

if(isset($_GET['viewtype'])){
    $viewtype=addslashes($_GET['viewtype']);
}
$obj->getList($strWhere);
$row=$obj->Fetch_Assoc();
$id = (int)$row['id'];
$title = stripslashes($row['name']);
$code = stripslashes($row['code']);
$time = date('H:i d/m/Y',$row['cdate']);
$author = $row['author'];
$link = ROOTHOST.LINK_DOCUMENT.'/'.$code.'.html';
$info_cate = $obj_cate->getInfo(" AND doctype_id=".$row['type_id']);
$type_id = $row['type_id'];
$link_cate = ROOTHOST.LINK_DOCUMENT.'/'.$info_cate['code'];
?>
<div class="page page-list-contents">
    <div class="page-header">
        <?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner4');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_DOCUMENT;?>">Tài liệu</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-contents">
                <div class="content">
                    <div class="row row_26">
                        <div id="col-left" class="col-sm-4 column-left">
                            <div class="box-title"><?php echo $info_cate['name'] ?></div>
                            <?php
                            $obj_cate->getList();
                            if($obj_cate->Num_rows()>0){
                                echo '<ul class="list-group">';
                                while ($row_left = $obj_cate->Fetch_Assoc()) {
                                    $link_l = ROOTHOST.LINK_DOCUMENT.'/'.$row_left['code'].'.html';

                                    if($row_left['code']==$getcode){
                                        echo '<li class="list-group-item select"><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link_l.'" title="'.$row_left['name'].'">'.$row_left['name'].'</a></li>';
                                    }else{
                                        echo '<li class="list-group-item"><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link_l.'" title="'.$row_left['name'].'">'.$row_left['name'].'</a></li>';
                                    }
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                        <div class="col-sm-8 column-right">
                            <h1><?php echo $title; ?></h1>
                            <div class="info-time">
                                <ul class="list-inline">
                                    <li class="time"><?php echo $time ?></li>
                                    <li class="cate"><a href="<?php echo $link_cate;?>" title="<?php echo $info_cate['name'];?>"><?php echo $info_cate['name'];?></a></li>
                                </ul>
                            </div>

                            <div class="clearfix"></div>
                            <div class="fulltext">
                                <div class="content">
                                    <?php
                                    $url = $row['url'];
                                    $fullurl = $row['fullurl'];
                                    $content=is_file($fullurl)?file_get_contents($fullurl,true):'';

                                    header('Content-Type: application/pdf');
                                    header('Content-Length: ' . strlen($content));
                                    header('Content-Disposition: inline; filename="'.$url.'"');
                                    header('Cache-Control: private, max-age=0, must-revalidate');
                                    header('Pragma: public');
                                    ini_set('zlib.output_compression','0');

                                    die($content);
                                    ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            
                            <?php
                            $obj->getList(" AND type_id = $type_id AND id<>$id ORDER BY cdate DESC", " LIMIT 0,5");
                            if($obj->Num_rows()>0){
                                echo '<div class="box-related"><div class="title-box"><div class="inline">Tài liệu khác</div></div><ul class="list-related">';
                                while ($row_related = $obj->Fetch_Assoc()) {
                                    $link_related = ROOTHOST.LINK_DOCUMENT.'/'.$row_related['code'].'.html';
                                    echo '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link_related.'" title="'.$row_related['name'].'">'.$row_related['name'].'</a></li>';
                                }
                                echo '</ul></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ob_end_flush();?>