<?php
class CLS_CATE_SERVICE{
    private $objmysql=NULL;
    public function CLS_CATE_SERVICE(){
        $this->objmysql=new CLS_MYSQL;
    }
    public function getList($where='',$limit=''){
        $sql="SELECT * FROM `tbl_cate_service` WHERE isactive=1 ".$where.$limit;
        return $this->objmysql->Query($sql);
    }
    public function getInfo($where='',$limit=''){
        $sql="SELECT * FROM `tbl_cate_service` WHERE isactive=1 ".$where.$limit;
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

    public function getCatIDParent($parid){
        $sql="SELECT * FROM `tbl_cate_service` WHERE isactive=1 AND cate_id='$parid' ";
        $objdata=new CLS_MYSQL();
        $this->result=$objdata->Query($sql);
        $par_cate=array();
        if($objdata->Num_rows()>0) {
            while ($rows=$objdata->Fetch_Assoc()) {
                $par_cate=$this->getCatIDParent($rows['par_id']);
                $par_cate[]=$rows['name'];
            }
        }
        return $par_cate;
    }
    
    function getListCate($parid=0,$level=0){
        $sql="SELECT * FROM tbl_cate_service WHERE `par_id`='$parid' AND `isactive`='1' ";
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
        $sql="SELECT `name` FROM `tbl_cate_service`  WHERE isactive=1 AND `cate_id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }

    /* combo box*/
    function getListCbItem($getId='', $swhere=''){
        $sql="SELECT cate_id, name, code FROM tbl_cate_service ".$swhere." ORDER BY `name` ASC";
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