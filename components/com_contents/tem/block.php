<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cur_page=isset($_GET['page'])? $_GET['page']: '1';
$strWhere='';


if(isset($_GET['code'])){
    $getCode = addslashes(strip_tags($_GET['code']));
    $info_cate = $obj_cate->getInfo(" AND `code`= '$getCode' ");
    $arr_cate = $obj_cate->getCatIDParent($info_cate['cate_id']);
    $link_cate = ROOTHOST.LINK_NEWS.'/'.$info_cate['code'];
    $strWhere=" AND `cate_id` = ".$info_cate['cate_id'];
}
?>
<div class="clearfix"></div>
<div class="page page-block-content">
    <div class="page-header">
        <?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner2');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_NEWS;?>" title="<?php echo NEWS ?>"><?php echo NEWS ?></a></li>
                    <li><a href="<?php echo $link_cate;?>" title="<?php echo $info_cate['name'];?>"><?php echo $info_cate['name'];?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="list-block-content">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-9 column-left">
                            <?php
                            $total_rows = $obj->getCount($strWhere);
                            if($total_rows>0){
                                $max_rows= 5;
                                $max_page=ceil($total_rows/$max_rows);
                                if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                                if($cur_page>$max_page) $cur_page=$max_page;
                                $start=($cur_page-1)*$max_rows;

                                $obj->getList($strWhere," LIMIT $start,$max_rows");
                                $i=0;
                                while ($row=$obj->Fetch_Assoc()) {
                                    $i++;
                                    $id = $row['id'];
                                    $title = stripcslashes($row['title']);
                                    $code = stripcslashes($row['code']);
                                    $thumb = getThumb($row['thumb'],'img-responsive',$title);
                                    $view = number_format($row['visited']);
                                    $date = date('d/m/Y H:i A',strtotime($row['cdate']));
                                    $intro = Substring(strip_tags($row['intro']),0,50);
                                    $link = ROOTHOST.LINK_NEWS.'/'.$code.'.html';
                                    if($i==1){
                                        echo '
                                        <div class="ourline">
                                            <div class="first_times">/ '.UPDATE_TIME.' '.$date.'</div>
                                            <div class="border_color"></div>
                                            <div class="item first">
                                                <a href="'.$link.'" class="name" title="'.$title.'">'.$thumb.'</a>
                                                <div class="col-info">
                                                    <div class="title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></div>
                                                    <p class="info_time">'.$date.'</p>
                                                    <p class="intro">'.$intro.'</p>
                                                    <span class="view_detail"><a href="'.$link.'" class="name" title="'.$title.'">'.VIEW_DETAIL.'</a></span>
                                                </div>
                                            </div>
                                        </div>';
                                    }else{
                                        echo '
                                        <div class="ourline">
                                            <div class="item">
                                                <a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
                                                <div class="col-info">
                                                    <div class="title"><a href="'.$link.'" class="name" title="'.$title.'">'.$title.'</a></div>
                                                    <p class="info_time">'.$date.'</p>
                                                    <p class="intro">'.$intro.'</p>
                                                    <span class="view_detail"><a href="'.$link.'" class="name" title="'.$title.'">'.VIEW_DETAIL.'</a></span>
                                                </div>
                                            </div>
                                        </div>';
                                    }
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
                        <div id="advertisement" class="col-sm-3 column-right">
                            <img src="<?php echo ROOTHOST;?>images/root/qc1.jpg" class="img-responsive"><br/>
                            <img src="<?php echo ROOTHOST;?>images/root/qc2.jpg" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>