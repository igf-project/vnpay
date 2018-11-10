<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(isset($_GET['code'])){
    $getcode = addslashes(strip_tags($_GET['code']));
    $strWhere=' AND `code`="'.$getcode.'"';
    $obj->updateView($getcode);
}
else die("PAGE NOT FOUND");

$obj->getList($strWhere);
$row=$obj->Fetch_Assoc();
$id = (int)$row['id'];
$cate_id = (int)$row['cate_id'];
$title = stripslashes($row['title']);
$code = stripslashes($row['code']);
$intro=strip_tags($row['intro']);
$fulltext=html_entity_decode($row['fulltext']);
$time = date('H:i d/m/Y',strtotime($row['cdate']));
$author = $row['author'];
$info_cate = $obj_cate->getInfo(" AND cate_id=".$row['cate_id']);
$link_cate = ROOTHOST.LINK_INTRODUCT.'/'.$info_cate['code'];
?>

<div class="page page-list-contents">
    <div class="page-header">
        <?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner7');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="">Giới thiệu về chúng tôi</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-contents">
                <div class="content">
                    <div class="column-right">
                        <div class="fulltext">
                            <div class="content">
                                <?php echo $fulltext ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <?php
                        $obj->getList(" AND cate_id = $cate_id AND id<>$id ORDER BY cdate DESC", " LIMIT 0,5");
                        if($obj->Num_rows()>0){
                            echo '<div class="box-related"><div class="title-box"><div class="inline">'.RELATED_CONTENT.'</div></div><ul class="list-related">';
                            while ($row_related = $obj->Fetch_Assoc()) {
                                $link_related = ROOTHOST.LINK_INTRODUCT.'/'.$row_related['code'].'.html';
                                echo '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link_related.'" title="'.$row_related['title'].'">'.$row_related['title'].'</a></li>';
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
