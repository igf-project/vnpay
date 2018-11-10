<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cur_page=isset($_GET['page'])? $_GET['page']: '1';
$strWhere='';


if(isset($_GET['code'])){
    $getCode = addslashes(strip_tags($_GET['code']));
    $info_cate = $obj_cate->getInfo(" AND `code` = '$getCode' ");
    $strWhere=" AND cate_id = ".$info_cate['cate_id'];
    
}
?>
<div class="page page-list-service">
    <div class="page-header">
        <?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner1');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_SERVICE;?>" title="<?php echo PRODUCT_SERVICE ?>"><?php echo PRODUCT_SERVICE ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-service">
                <div class="content">
                    <div class="row">
                        <?php
                        $total_rows = $obj->getCount($strWhere);
                        if($total_rows>0){
                            $max_rows= MAX_ROWS;
                            $max_page=ceil($total_rows/$max_rows);
                            if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                            if($cur_page>$max_page) $cur_page=$max_page;
                            $start=($cur_page-1)*$max_rows;

                            $obj->getList($strWhere," LIMIT $start,$max_rows");
                            while ($row=$obj->Fetch_Assoc()) {
                                $id = $row['id'];
                                $title = stripcslashes($row['title']);
                                $code = stripcslashes($row['code']);
                                $thumb = getThumb($row['thumb'],'img-responsive',$title);
                                $view = number_format($row['visited']);
                                $date = date('d/m/Y',strtotime($row['cdate']));
                                $intro = Substring(strip_tags($row['intro']),0,50);
                                $link = ROOTHOST.LINK_SERVICE.'/'.$code.'.html';
                                echo '
                                <div class="col-sm-6">
                                    <div class="item">
                                        <a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
                                        <div class="col-info">
                                            <div class="intro">'.$intro.'</div>
                                            <a href="'.$link.'" title="'.$title.'" class="title">'.$title.'</a>
                                            <a href="'.$link.'" title="'.$title.'" class="btn-view">'.VIEW_MORE.'</a>
                                        </div>
                                    </div>
                                </div>';
                            }


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