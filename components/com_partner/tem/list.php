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
        $tmp->loadModule('banner8');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_PARTNER;?>" title="<?php echo PARTNER ?>"><?php echo PARTNER ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-service">
                <div class="content">
                    <div class="row row_26">
                        <div id="col-left" class="col-sm-3 column-left">
                            <div class="box-title"><a href="<?php echo ROOTHOST.LINK_PARTNER;?>" title="<?php echo PARTNER ?>"><?php echo BLOCK_PARTNER ?></a></div>
                            <?php
                            $obj_cate->getList();
                            if($obj_cate->Num_rows()>0){
                                echo '<ul class="list-group">';
                                while ($rowCate = $obj_cate->Fetch_Assoc()) {
                                    $name = stripcslashes($rowCate['name']);
                                    $code = stripcslashes($rowCate['code']);
                                    $linkCate = ROOTHOST.LINK_PARTNER.'/'.$code;
                                    echo '<li class="list-group-item"><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$linkCate.'" title="'.$name.'">'.$name.'</a></li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                        <div class="col-sm-9 column-right">
                            <div class="content">
                                <h1><?php echo PARTNER ?></h1>
                                <div class="box-list-partner">
                                    <?php
                                    $total_rows = $obj->getCount();
                                    if($total_rows>0){
                                        $max_rows= MAX_ROWS;
                                        $max_page=ceil($total_rows/$max_rows);
                                        if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                                        if($cur_page>$max_page) $cur_page=$max_page;
                                        $start=($cur_page-1)*$max_rows;

                                        echo '<ul class="list-partner">';
                                        $obj->getList(''," LIMIT $start,$max_rows");
                                        while ($row=$obj->Fetch_Assoc()) {
                                            $id = $row['id'];
                                            $title = stripcslashes($row['title']);
                                            $code = stripcslashes($row['code']);
                                            $link = ROOTHOST.LINK_PARTNER.'/'.$code.'.html';
                                            echo '<li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
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
</div>