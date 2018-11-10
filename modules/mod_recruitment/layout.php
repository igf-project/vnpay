<?php
include_once(INC_PATH.'func_helper.php');
if ($ismobile==false) {
?>
<div class="hidden-xs">
<div class="box-category">
    <h3 class="title">Tuyển dụng</h3>
    <?php
    $strWhere=" WHERE id!='0' AND type=2";
    include_once(LIB_PATH.'cls.category.php');
    $objCate=new CLS_CATE();
    $objCate->getList($strWhere);?>
    <ul>
        <?php
        $i=0;
        while($rows=$objCate->Fetch_Assoc()){
            $i++;
            $name = $rows['name'];
            $url=ROOTHOST."tuyen-dung/".$rows['code'];
            $active=$code==$rows['code']? 'active':'';
            if($i==1 && $code==''){
                $code=$rows['code'];
                echo '<li class="active"><a href="'.$url.'"><i class="fa fa-angle-right" aria-hidden="true"></i> '.$name.'</a></li>';
            }
            else  echo '<li class="'.$active.'"><a href="'.$url.'"><i class="fa fa-angle-right" aria-hidden="true"></i> '.$name.'</a></li>';
        }
        ?>
    </ul>
</div>
<div class="mod-video">
    <?php  include_once(LIB_PATH.'cls.video.php');
    if(!isset($objVideo)) $objVideo=new CLS_VIDEO();
    $objVideo->getListVideoHot();
    ?>
</div>
<div class="product-relater">
    <?php include_once(LIB_PATH.'cls.food.php');
    $objFood=new CLS_FOOD();
    $objFood->getListStype('WHERE ishot=1', 'LIMIT 0,3');
    ?>
</div>
</div>
<?php } else{
    $select=isset($_GET['code'])? $_GET['code']:'';
    ?>
    <form id="select_gallery" method="post" class="pull-right">
        <select name="opt_type" onchange="doSubmit(this.value)">
            <option value="#">Tuyển dụng</option>
            <?php
            $strWhere=" WHERE id!='0' AND type=2";
            include_once(LIB_PATH.'cls.category.php');
            $objCate=new CLS_CATE();
            $objCate->getList($strWhere);
            $i=0;
            while($rows=$objCate->Fetch_Assoc()){
                $i++;
                $name = $rows['name'];
                $code2 = $rows['code'];
                $url=ROOTHOST."tuyen-dung/".$rows['code'];?>
                <option value="<?php echo $url;?>" <?php if($select==$code2) echo "selected";?>><?php echo $name;?></option>
            <?php }?>
        </select>
    </form>
    <script>
        function doSubmit(val){
            window.location.href=val;
        }
    </script>
    <div class="clearfix" style="margin-bottom: 15px"></div>
<?php } ?>