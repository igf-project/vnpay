<?php
$strWhere="WHERE isactive=1 AND groupservice_id='$group'";
?>
<div class="mod list-latest-news">
    <h3 class="title">
        Project Other
    </h3>
    <ul class="latest-post">
        <?php
        $sql="SELECT * FROM tbl_product $strWhere AND ishot=1 LIMIT 0,8";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<1) echo 'Dữ liệu đang được cập nhật';
        while($rows=$objdata->Fetch_Assoc()){
            $title=Substring($rows["name"], 0 , 50);
            $date = date("d/m/Y", strtotime($rows['cdate']));
            $img= getThumb($rows['thumb'], 'img-responsive thumb-hot',$rows['title']);
            ?>
            <li>
                <a href="<?php echo $url;?>">
                    <?php echo $img;?>
                </a>
                <div class="recent-post-details">
                    <a class="post-title" href="<?php echo $url;?>"><?php echo $title;?></a>
                   <span class="txt-time"><i class="fa fa-clock-o"></i> <?php echo $date;?></span>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="mod list-latest-news">
    <h3 class="title">
        Blog Relater
    </h3>
    <ul class="latest-post">
        <?php
        $sql="SELECT * FROM tbl_contents WHERE isactive=1 AND product_id='$product_id' AND ishot=1 LIMIT 0,8";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<1) echo 'Dữ liệu đang được cập nhật';
        while($rows=$objdata->Fetch_Assoc()){
            $title=Substring($rows["title"], 0 , 50);
            $date = date("d/m/Y", strtotime($rows['cdate']));
            $img= getThumb($rows['thumb'], 'img-responsive thumb-hot',$rows['title']);
            ?>
            <li>
                <a href="<?php echo $url;?>">
                    <?php echo $img;?>
                </a>
                <div class="recent-post-details">
                    <a class="post-title" href="<?php echo $url;?>"><?php echo $title;?></a>
                    <span class="txt-time"><i class="fa fa-clock-o"></i> <?php echo $date;?></span>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>

