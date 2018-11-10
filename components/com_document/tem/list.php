<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cur_page=isset($_GET['page'])? $_GET['page']: '1';
$strWhere='';
?>
<div class="page page-list-service">
    <div class="page-header">
        <?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner4');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_DOCUMENT;?>" title="<?php echo DOCUMENT ?>"><?php echo DOCUMENT ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-contents">
                <div class="content">
                    <div class="row row_26">
                        <div id="col-left" class="col-sm-4">
                            <div class="box-title"><a href="<?php echo ROOTHOST.LINK_DOCUMENT;?>" title="<?php echo DOCUMENT ?>"><?php echo DOCUMENT ?></a></div>
                            <?php
                            $obj_cate->getList();
                            echo '<ul class="list-group">';
                            while ($row_cate = $obj_cate->Fetch_Assoc()) {
                                $idCate = $row_cate['doctype_id'];
                                $nameCate = stripcslashes($row_cate['name']);
                                $codeCate = stripcslashes($row_cate['code']);
                                $linkCate = ROOTHOST.LINK_DOCUMENT.'/'.$codeCate;
                                echo '<li class="list-group-item"><i class="fa fa-circle" aria-hidden="true"></i>';
                                echo '<a href="'.$linkCate.'" title="'.$nameCate.'">'.$nameCate.'</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            ?>
                        </div>
                        <div class="col-sm-8">
                            <h1><?php echo DOCUMENT ?></h1>
                            <div class="box-list-help">
                                <?php
                                $total_rows = $obj->getCount();
                                if($total_rows>0){
                                    $max_rows= MAX_ROWS;
                                    $max_page=ceil($total_rows/$max_rows);
                                    if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                                    if($cur_page>$max_page) $cur_page=$max_page;
                                    $start=($cur_page-1)*$max_rows;

                                    echo '<ul class="list-help">';
                                    $obj->getList(''," LIMIT $start,$max_rows");
                                    while ($row=$obj->Fetch_Assoc()) {
                                        $id = $row['id'];
                                        $title = stripcslashes($row['name']);
                                        $code = stripcslashes($row['code']);
                                        $link = ROOTHOST.LINK_DOCUMENT.'/'.$code.'.html';
                                        echo '<li><i class="fa fa-info-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
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
</div>