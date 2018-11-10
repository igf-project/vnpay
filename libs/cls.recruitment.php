<?php
ini_set('display_errors', 1);
class CLS_RECRUITMENT{
    private $objmysql;
    public function CLS_RECRUITMENT(){
        $this->objmysql=new CLS_MYSQL;
    }
    
    public function getList($strwhere="",$limit=''){
        $sql="SELECT * FROM tbl_recruitment WHERE isactive=1 $strwhere $limit";
        return $this->objmysql->Query($sql);
    }
    public function getCount($where=''){
        $objdata=new CLS_MYSQL;
        $sql="SELECT count(id) as count FROM `tbl_recruitment` WHERE isactive=1 ".$where;
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
        $sql="SELECT * FROM `tbl_recruitment` WHERE  isactive='1'";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        while($rows=$objdata->Fetch_Assoc()){
            $ids=$rows['id'];
            $title=$rows['title'];
            echo "<option value=\"$ids\">$title</option>";
        }
    }
    
    public function updateView($code){
        if(!isset($_SESSION['VIEW-RECRUITMENT'])){
            $sql="UPDATE `tbl_recruitment` SET `visited`=`visited`+1 WHERE `code` ='$code'";
            $_SESSION['VIEW-RECRUITMENT']=1;
            return $this->objmysql->Exec($sql);
        }
    }

    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, name, code FROM tbl_recruitment WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
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