<?php
ini_set('display_errors', 1);
class CLS_INTRODUCT{
    private $pro=array(
        'ID'=>'-1',
        'Title'=>'',
        'Code'=>'',
        'Cate_ID'=>'0',
        'Intro'=>'',
        'Fulltext'=>'',
        'Thumb'=>'',
        'Author'=>'',
        'View'=>'',
        'ListTags'=>'',
        'ListConId'=>'',
        'Cdate'=>'',
        'Mdate'=>'',
        'Meta_title'=>'',
        'Meta_key'=>'',
        'Meta_desc'=>'',
        'isHot'=>'0',
        'LangID'=>'0',
        'isActive'=>'1');
    private $objmysql;
    public function CLS_INTRODUCT(){
        $this->objmysql=new CLS_MYSQL;
    }
    // property set value
    public function __set($proname,$value){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_INTRODUCT Class' );
            return;
        }
        $this->pro[$proname]=$value;
    }
    public function __get($proname){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_INTRODUCT Class' );
            return '';
        }
        return $this->pro[$proname];
    }
    public function getList($strwhere=""){
        $sql="SELECT * FROM tbl_intro WHERE 1=1 $strwhere";
        return $this->objmysql->Query($sql);
    }
    public function getCount($where=''){
        $objdata=new CLS_MYSQL;
        $sql="SELECT count(id) as count FROM `tbl_intro` WHERE 1=1 ".$where;
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['count'];
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function LoadConten($lagid=0){
        $sql="SELECT * FROM `tbl_intro` WHERE  isactive='1'";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()){
            $ids=$rows['id'];
            $title=$rows['title'];
            echo "<option value=\"$ids\">$title</option>";
        }
    }
    public function getCatName($catid) {
        $sql="SELECT name FROM tbl_cate_intro WHERE cate_id='$catid'";
        $objdata=new CLS_MYSQL;
        $objdata->Query($sql);
        if($objdata->Num_rows()>0) {
            $r=$objdata->Fetch_Assoc();
            return $r['name'];
        }
    }
    public function getListCbTags($getId='', $swhere='', $arrId=''){
        $sql="SELECT id,name FROM tbl_tags WHERE ".$swhere." `isactive`='1' ORDER BY `id` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['name'];
            if(!$arrId){?>
                <option value='<?php echo $id;?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
                <?php
            }else{?>
                <option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
                <?php
            }
        }
    }

    public  function getListCbRelateContent($getId='', $swhere='', $arrId=''){
        $sql="SELECT `id`,`title` FROM `tbl_intro` WHERE ".$swhere." `isactive`='1' ORDER BY `id` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['title'];
            if(!$arrId){?>
                <option value='<?php echo $id;?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
                <?php
            }else{?>
                <option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
                <?php
            }
        }
    }
    public function listTable($strwhere="",$page){
        $star=($page-1)*MAX_ROWS_ADMIN;
        $leng=MAX_ROWS_ADMIN;
        $sql="SELECT * FROM tbl_intro WHERE 1=1 $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);	$i=0;
        while($rows=$objdata->Fetch_Assoc()){
        	$i++;
            $ids=$rows['id'];
            $cate_id=$rows['cate_id'];
            $title=Substring(stripslashes($rows['title']),0,10);
            $cdate = date('d-m-Y H:i:sa',strtotime($rows['cdate']));
            $category = $this->getCatName($cate_id);
            $visited= number_format($rows['visited']);
            $order= number_format($rows['order']);
            if($rows['thumb']=='')
                $thumb ='<img src="'.IMG_DEFAULT.'" alt="'.$title.'" width="60px">';
            else $thumb ='<img src="'.$rows["thumb"].'" alt="'.$title.'" width="60px">';

            if($rows['isactive']==1) 
                $icon_active="<i class='fa fa-check cgreen' aria-hidden='true'></i>";
            else $icon_active='<i class="fa fa-times-circle-o cred" aria-hidden="true"></i>';
            
            echo "<tr name='trow'>";
            echo "<td width='30' align='center'>$i</td>";
            echo "<td width='30' align='center'><label>";
            echo "<input type='checkbox' name='chk' id='chk' onclick=\"docheckonce('chk');\" value='$ids'/>";
            echo "</label></td>";
            echo "<td>$category</td>";
            echo "<td>$thumb $title</td>";
            echo "<td>$cdate</td>";
            echo "<td align='center'>$visited</td>";
          
            echo "<td width='50' align='center'><input type='text' name='txt_order' id='txt_order' value='$order' size='4' class='order'></td>";

            echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/active/$ids'>".$icon_active."</a></td>";

            echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/edit/$ids'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";

            echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

            echo "</tr>";
        }
    }
    public function getOldArrListTags($con_id){
        $sql="SELECT * FROM `tbl_intro` WHERE `id`=$con_id ";
        $arrTags=array();
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        $arrTags=explode(",", $row['list_tagid']);
        return $arrTags;
    }
    public function addNew($arrTags=array()){
        $objdata=new CLS_MYSQL;
        $sql="INSERT INTO tbl_intro (`cate_id`,`code`,`thumb`,`list_tagid`,`list_conid`,`cdate`,`mdate`,`author`,`ishot`,`isactive`,`title`,`intro`,`fulltext`,`meta_title`,`meta_key`,`meta_desc`) VALUES ";
        $sql.="('".$this->Cate_ID."','".$this->Code."','".$this->Thumb."','";
        $sql.=$this->ListTags."','".$this->ListConId."','".$this->Cdate."','".$this->Mdate."','".$this->Author."','".$this->isHot."','".$this->isActive."','".$this->Title."','".$this->Intro."','";
        $sql.=$this->Fulltext."','".$this->Meta_title."','".$this->Meta_key."','".$this->Meta_desc."')";
        return $objdata->Query($sql);
    }

    public function Update($arrTags=array(),$arrListTags=array()){
        $objdata=new CLS_MYSQL;
        $objdata->Query("BEGIN");
        $sql="UPDATE tbl_intro SET 
        `cate_id`='".$this->Cate_ID."', 
        `code`='".$this->Code."',
        `thumb`='".$this->Thumb."',
        `list_tagid`='".$this->ListTags."',
        `list_conid`='".$this->ListConId."',
        `mdate`='".$this->Mdate."',
        `author`='".$this->Author."',
        `ishot`='".$this->isHot."',
        `isactive`='".$this->isActive."',
        `title`='".$this->Title."',
        `intro`='".$this->Intro."',
        `fulltext`='".$this->Fulltext."',
        `meta_title`='".$this->Meta_title."',
        `meta_key`='".$this->Meta_key."',
        `meta_desc`='".$this->Meta_desc."' 
        WHERE `id`='".$this->ID."'";
        return $objdata->Query($sql);
    }
    public function Delete($ids){
        $objdata=new CLS_MYSQL;
        $sql="DELETE FROM `tbl_intro` WHERE `id` in ('$ids')";
        return $objdata->Query($sql);
    }
    public function setHot($ids){
        $sql="UPDATE `tbl_intro` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_intro` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_intro` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    function Order($arr_id,$arr_quan){
        $n=count($arr_id);
        for($i=0;$i<$n;$i++){
            $sql="UPDATE `tbl_intro` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
            $this->objmysql->Exec($sql);
        }
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, name, code FROM tbl_intro WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $name=$rows['name'];
            if(!$arrId){
                ?>
                <option value='<?php echo $rows['id'];?>' <?php if(isset($getId) && $id==$getId) echo "selected";?>><?php echo $name;?></option>
            <?php
            }else{?>
                <option value='<?php echo $id;?>' <?php if(isset($arrId) and in_array($id, $arrId)) echo "selected";?>><?php echo $name;?></option>
            <?php
            }
        }
    }
}
?>