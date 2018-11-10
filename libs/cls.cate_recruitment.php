<?php
class CLS_CATEGORY_RECRUITMENT{
    private $objmysql=NULL;
    public function CLS_CATEGORY_RECRUITMENT(){
        $this->objmysql=new CLS_MYSQL;
    }
    
    public function getList($where='',$limit=''){
        $sql="SELECT * FROM `tbl_cate_recruitment` WHERE isactive=1 ".$where.$limit;
        return $this->objmysql->Query($sql);
    }
    public function getInfo($where=''){
        $sql="SELECT * FROM `tbl_cate_recruitment` WHERE isactive=1 ".$where;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $row = $objdata->Fetch_Assoc();
        return $row;
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }

    function getListCate($parid=0,$level=0){
        $sql="SELECT * FROM tbl_cate_recruitment WHERE `par_id`='$parid' AND `isactive`='1' ";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $char="";
        if($level!=0){
            for($i=0;$i<$level;$i++)
                $char.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
            $char.="|---";
        }
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['cate_id'];
            $parid=$rows['par_id'];
            $title=$rows['name'];
            echo "<option value='$id'>$char $title</option>";
            $nextlevel=$level+1;
            $this->getListCate($id,$nextlevel);
        }
    }
    
    public function getNameById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `name` FROM `tbl_cate_recruitment`  WHERE isactive=1 AND `cate_id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }
    
    /* combo box*/
    function getListCbItem($getId='', $swhere=''){
        $sql="SELECT cate_id, name, code FROM tbl_cate_recruitment ".$swhere." ORDER BY `name` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['cate_id'];
            $name=$rows['name'];
            ?>
            <option value='<?php echo $id;?>' <?php if(isset($getId) && $getId==$id) echo "selected";?>><?php echo $name;?></option>
            <?php
        }
    }
}
?>