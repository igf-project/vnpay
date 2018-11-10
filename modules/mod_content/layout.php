<?php
$code=isset($_GET['code']) ? addslashes($_GET['code']):'';
$strWhere="WHERE isactive=1";
?>
<div class="mod list-latest-news">
    <h3 class="title"><i class="fa fa-list fa_user" aria-hidden="true"></i>Tin mới nhất</h3>
    <ul class="list latest-post">
        <?php
        $sql="SELECT * FROM view_content $strWhere ORDER BY `cdate` DESC LIMIT 0,8";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<1) echo 'Dữ liệu đang được cập nhật';
        while($rows=$objdata->Fetch_Assoc()){
            $title=stripslashes($rows["title"]);
            $url = ROOTHOST.stripslashes($rows['code']).'.html';
            ?>
            <li><i class="fa fa-circle" aria-hidden="true"></i><a class="name" href="<?php echo $url;?>"><?php echo $title;?></a></li>
            <?php 
        } ?>
    </ul>
</div>
<?php $this->loadModule('left') ?>
<div class="quangcao text-center"><img src="<?php echo ROOTHOST.'images/hh.jpg'?>" class="img-responsive"></div>
