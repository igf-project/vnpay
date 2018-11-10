<?php
ini_set('display_errors', 1);
class CLS_PARTNER{
    private $pro=array(
        'ID'=>'-1',
        'Cate_ID'=>'0',
        'Title'=>'',
        'Code'=>'',
        'Thumb'=>'',
        'Link'=>'',
        'Order'=>'',
        'Cdate'=>'',
        'isActive'=>'1');
    private $objmysql;
    public function CLS_PARTNER(){
        $this->objmysql=new CLS_MYSQL;
    }
    // property set value
    public function __set($proname,$value){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_PARTNER Class' );
            return;
        }
        $this->pro[$proname]=$value;
    }
    public function __get($proname){
        if(!isset($this->pro[$proname])){
            echo ($proname.' is not member of CLS_PARTNER Class' );
            return '';
        }
        return $this->pro[$proname];
    }
    public function getList($strwhere=""){
        $sql="SELECT * FROM tbl_partner WHERE 1=1 $strwhere";
        return $this->objmysql->Query($sql);
    }
    public function getCount($where=''){
        $objdata=new CLS_MYSQL;
        $sql="SELECT count(id) as count FROM `tbl_partner` WHERE 1=1 ".$where;
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
        $sql="SELECT * FROM `tbl_partner` WHERE isactive='1'";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()){
            $ids=$rows['id'];
            $title=$rows['title'];
            echo "<option value=\"$ids\">$title</option>";
        }
    }
    public function getCatName($catid) {
        $sql="SELECT name FROM tbl_cate_partner WHERE cate_id='$catid'";
        $objdata=new CLS_MYSQL;
        $objdata->Query($sql);
        if($objdata->Num_rows()>0) {
            $r=$objdata->Fetch_Assoc();
            return $r['name'];
        }
    }

    public function listTable($strwhere="",$page){
        $star=($page-1)*MAX_ROWS_ADMIN;
        $leng=MAX_ROWS_ADMIN;
        $sql="SELECT * FROM tbl_partner WHERE 1=1 $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);	$i=0;
        while($rows=$objdata->Fetch_Assoc()){
        	$i++;
            $ids=$rows['id'];
            $cate_id=$rows['cate_id'];
            $title=Substring(stripslashes($rows['title']),0,10);
            $cdate = date('d-m-Y H:i:sa',strtotime($rows['cdate']));
            $category = $this->getCatName($cate_id);
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
          
            echo "<td width='50' align='center'><input type='text' name='txt_order' id='txt_order' value='$order' size='4' class='order'></td>";

            echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/active/$ids'>".$icon_active."</a></td>";

            echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/edit/$ids'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";

            echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

            echo "</tr>";
        }
    }
   
    public function addNew(){
        $objdata=new CLS_MYSQL;
        $sql="INSERT INTO tbl_partner (`cate_id`,`title`,`code`,`thumb`,`link`,`cdate`,`isactive`) 
        VALUES ('".$this->Cate_ID."','".$this->Title."','".$this->Code."','".$this->Thumb."','".$this->Link."','".$this->Cdate."','".$this->isActive."')";
        return $objdata->Query($sql);
    }

    public function Update(){
        $objdata=new CLS_MYSQL;
        $objdata->Query("BEGIN");
        $sql="UPDATE tbl_partner SET 
        `cate_id`='".$this->Cate_ID."', 
        `code`='".$this->Code."',
        `thumb`='".$this->Thumb."',
        `isactive`='".$this->isActive."',
        `title`='".$this->Title."'
        WHERE `id`='".$this->ID."'";
        return $objdata->Query($sql);
    }
    public function Delete($ids){
        $objdata=new CLS_MYSQL;
        $sql="DELETE FROM `tbl_partner` WHERE `id` in ('$ids')";
        return $objdata->Query($sql);
    }
    public function setHot($ids){
        $sql="UPDATE `tbl_partner` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_partner` SET `isactive`='$status' WHERE `id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_partner` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    function Order($arr_id,$arr_quan){
        $n=count($arr_id);
        for($i=0;$i<$n;$i++){
            $sql="UPDATE `tbl_partner` SET `order`='".$arr_quan[$i]."' WHERE `id` = '".$arr_id[$i]."' ";
            $this->objmysql->Exec($sql);
        }
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, name, code FROM tbl_partner WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
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