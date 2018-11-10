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
        $tmp->loadModule('banner6');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_RECRUITMENT;?>" title="<?php echo RECRUITMENT ?>"><?php echo RECRUITMENT ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-contents">
                <div class="content">
                    <div class="row">
                        <?php
                        $total_rows = $obj->getCount();
                        if($total_rows>0){
                            $max_rows= MAX_ROWS;
                            $max_page=ceil($total_rows/$max_rows);
                            if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                            if($cur_page>$max_page) $cur_page=$max_page;
                            $start=($cur_page-1)*$max_rows;

                            $obj->getList(''," LIMIT $start,$max_rows");
                            while ($row=$obj->Fetch_Assoc()) {
                                $id = $row['id'];
                                $title = stripcslashes($row['title']);
                                $code = stripcslashes($row['code']);
                                $thumb = getThumb($row['thumb'],'img-responsive',$title);
                                $view = number_format($row['visited']);
                                $date = date('d/m/Y',strtotime($row['cdate']));
                                $intro = Substring(strip_tags($row['intro']),0,50);
                                $link = ROOTHOST.LINK_RECRUITMENT.'/'.$code.'.html';
                                echo '
                                <div class="col-sm-6 ourline">
                                    <div class="item">
                                        <a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
                                        <div class="col-info">
                                            <div class="title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></div>
                                            <div class="info">
                                                <ul class="list-inline">
                                                    <li class="date">'.$date.'</li>
                                                    <li class="comment">268 bình luận</li>
                                                    <li class="view">'.$view.'</li>
                                                </ul>
                                            </div>
                                            <p class="intro">'.$intro.'</p>
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