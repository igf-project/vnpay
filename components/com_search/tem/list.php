<?php
require_once('libs/cls.mysql.php');
$tmp = new CLS_TEMPLATE();
defined("ISHOME") or die("Can't acess this page, please come back!");
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cur_page=isset($_GET['page'])? $_GET['page']: '1';
$strWhere='';$keywork='';


if(isset($_GET['q'])){
    $keywork = addslashes(strip_tags($_GET['q']));
    $strWhere=" `title` LIKE '%$keywork%' ";
}
?>
<div class="page page-list-help">
    <div class="page-header">
        <?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner9');
        ?>
        <div class="container">
            <div class="h1">
                <ul class="breadcrumb">
                    <li><a href="<?php echo ROOTHOST.LINK_SEARCH;?>" title="<?php echo SEARCH ?>"><?php echo SEARCH ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="page-body">
            <div class="box-contents">
                <h1 class="h1_search"><?php echo SEARCH_RESULTS ?> <font color="red">"<?php echo $keywork;?>"</font></h1>
                <div class="box-list-help">
                    <?php
                    $objmysql = new CLS_MYSQL();
                    $sql=" SELECT * FROM view_search WHERE $strWhere";
                    $objmysql->Query($sql);

                    $total_rows = $objmysql->Num_rows();
                    if($total_rows>0){
                        $max_rows= MAX_ROWS;
                        $max_page=ceil($total_rows/$max_rows);
                        if(isset($_GET['page'])){$cur_page=$_GET['page'];}
                        if($cur_page>$max_page) $cur_page=$max_page;
                        $start=($cur_page-1)*$max_rows;


                        echo '<ul class="list-help">';
                        while ($row=$objmysql->Fetch_Assoc()) {
                            $title = stripcslashes($row["title"]);
                            $code = stripcslashes($row["code"]);
                            $link='';$str='';
                            switch ($row['type']) {
                                case '1':
                                    $link = ROOTHOST.LINK_SERVICE.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                case '2':
                                    $link = ROOTHOST.LINK_NEWS.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                case '3':
                                    $link = ROOTHOST.LINK_INTRODUCT.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                case '4':
                                    $link = ROOTHOST.LINK_DOCUMENT.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                case '5':
                                    $link = ROOTHOST.LINK_HELP.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-info-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                case '6':
                                    $link = ROOTHOST.LINK_PARTNER.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-arrow-right" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                case '7':
                                    $link = ROOTHOST.LINK_QUESTION.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-question-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                case '8':
                                    $link = ROOTHOST.LINK_RECRUITMENT.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-info-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                                default:
                                    $link = ROOTHOST.LINK_NEWS.'/'.$code.'.html';
                                    $str= '<li><i class="fa fa-circle" aria-hidden="true"></i><a href="'.$link.'" target="_blank" title="'.$title.'">'.$title.'</a></li>';
                                    break;
                            }

                            echo $str;
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