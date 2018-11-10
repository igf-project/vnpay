<?php
$tmp = new CLS_TEMPLATE();
defined("ISHOME") or die("Can't acess this page, please come back!");
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cur_page=isset($_GET['page'])? $_GET['page']: '1';
$strWhere='';


if(isset($_GET['code'])){
    $getCode = addslashes(strip_tags($_GET['code']));
    $info_cate = $obj_cate->getInfo(" AND code='$getCode'");
    $strWhere=' AND cate_id='.$info_cate['cate_id'];
}
?>
<div class="page page-list-service">
    <div class="page-header">
        <?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner5');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_QUESTION;?>" title="<?php echo QUESTION ?>"><?php echo QUESTION ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-contents">
                <div class="row row_26">
                    <div class="col-sm-4 column-left">
                        <?php $tmp->loadModule('box6') ?>
                    </div>
                    <div class="col-sm-8 column-right">
                        <h1><?php echo $info_cate['name'] ?></h1>
                        <div class="box-list-help">
                            <?php
                            $total_rows = $obj->getCount($strWhere);
                            if($total_rows>0){
                                $max_rows= MAX_ROWS;
                                $max_page=ceil($total_rows/$max_rows);
                                if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                                if($cur_page>$max_page) $cur_page=$max_page;
                                $start=($cur_page-1)*$max_rows;

                                echo '<ul class="list-help">';
                                $obj->getList($strWhere," LIMIT $start,$max_rows");
                                while ($row=$obj->Fetch_Assoc()) {
                                    $id = $row['id'];
                                    $title = stripcslashes($row['title']);
                                    $code = stripcslashes($row['code']);
                                    $link = ROOTHOST.LINK_QUESTION.'/'.$code.'.html';
                                    echo '<li><i class="fa fa-info-circle" aria-hidden="true"></i><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
                                }
                                echo '</ul>';


                                echo '<div class="clearfix"></div><div class="text-center">';
                                $par=getParameter($thisurl);
                                $par['page']="{page}";
                                $link_full=conver_to_par($par);
                                paging1($total_rows,$max_rows,$cur_page,$link_full);
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>