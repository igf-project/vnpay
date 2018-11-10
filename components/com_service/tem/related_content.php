<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$strWhere='';$str='';
$code=isset($_GET['code']) ? addslashes($_GET['code']):'';
$name_cate = $obj->getNameCateByCode($code);
if($code=='')
    echo 'Dữ liệu đang cập nhật';
else{
    $obj->getList(" AND code='$code' LIMIT 0,1");
    $row_con = $obj->Fetch_Assoc();
    $arr_cate = $obj_cate->getCatIDParent($row_con['cate_id']);
    $strWhere.=" AND `id` IN(".$row_con['list_conid'].")";
    $cur_page=isset($_POST['txtCurnpage'])? $_POST['txtCurnpage']: '1';
    ?>
    <div class="page page-bock-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 column-left">
                    <div class="page-body">
                        <div class="box-breadcrumb">
                            <ul class="breadcrumb">
                                <li><a href="<?php echo ROOTHOST;?>" title="Trang chủ"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo ROOTHOST.$code.'.html';?>" title="<?php echo $row_con['title'];?>"><?php echo $row_con['title'];?></a></li>
                                <li><a href="<?php echo ROOTHOST.$code.'/bai-viet-lien-quan';?>" title="Bài viết liên quan">Bài viết liên quan</a></li>
                            </ul>
                        </div>
                        <?php
                        $obj->getList($strWhere);
                        if($obj->Num_rows()>0){
                            echo '<div class="box-category box-category1">';
                            echo '<div class="list_item related">';
                            while ($row=$obj->Fetch_Assoc()) {
                                $title = stripslashes($row['title']);
                                $code_con = stripslashes($row['code']);
                                $intro = Substring(strip_tags($row['intro']),0,50);
                                $thumb = getThumb(stripslashes($row['thumb']),'img-responsive',$title);
                                $link = ROOTHOST.$code_con.'.html';
                                echo '
                                <div class="item">
                                    <div class="inner">
                                        <a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
                                        <div class="title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></div>
                                        <p class="intro">'.$intro.'</p>
                                    </div>
                                </div>
                                ';
                            }
                            echo '</div>';
                            echo '</div>';
                        }else{ echo '<div class="text-center">Chưa có bài viết liên quan nào.</div>';}?>
                    </div>
                </div>
                <div class="col-sm-4 column-right">
                    <?php include_once(MOD_PATH.'mod_content/layout.php');?>
                </div>
            </div>
        </div>
    </div>
    <?php 
} ?>
