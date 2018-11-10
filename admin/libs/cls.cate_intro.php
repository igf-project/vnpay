<?php
class CLS_CATEGORY_INTRO{
    private $pro=array( 'ID'=>'-1',
        'Par_Id'=>"",
        'Name'=>'',
        'Thumb'=>'',
        'Intro'=>'',
        'Code'=>'',
        'Type'=>'',
        'Order'=>'',
        'isActive'=>1);
    private $objmysql=NULL;
    public function CLS_CATEGORY_INTRO(){
        $this->objmysql=new CLS_MYSQL;
    }
    // property set value
    public function __set($proname,$value){
        if(!isset($this->pro[$proname])){
            echo ('Can not found $proname member');
            return;
        }
        $this->pro[$proname]=$value;
    }
    public function __get($proname){
        if(!isset($this->pro[$proname])){
            echo ("Can not found $proname member");
            return;
        }
        return $this->pro[$proname];
    }
    public function getList($where='',$limit=''){
        $sql="SELECT * FROM `tbl_cate_intro` ".$where.' ORDER BY `name` '.$limit;
        return $this->objmysql->Query($sql);
    }
    public function getInfo($where='',$limit=''){
        $sql="SELECT * FROM `tbl_cate_intro` WHERE 1=1 ".$where.' ORDER BY `name` '.$limit;
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
        $sql="SELECT * FROM tbl_cate_intro WHERE `par_id`='$parid' AND `isactive`='1' ";
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
    public function listTable($strwhere="",$page=1,$parid=0,$level=0,$rowcount){
        global $rowcount;
        $star=($page-1)*MAX_ROWS;
        $leng=MAX_ROWS;
        $sql="SELECT * FROM tbl_cate_intro WHERE 1=1 $strwhere AND par_id=$parid ORDER BY `order` ASC LIMIT $star,$leng";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $str_space="";
        if($level!=0){  
            for($i=0;$i<$level;$i++)
                $str_space.="&nbsp;&nbsp;&nbsp;"; 
            $str_space.="|---";
        }
        while($rows=$objdata->Fetch_Assoc()){
            $rowcount++;
            $ids=$rows['cate_id'];

            $title=Substring(stripslashes($rows['name']),0,10);
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$rowcount</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\"   onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
            echo "<td title=''>$str_space$title</td>";
            $order=$rows['order'];
            echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";
            echo "<td align=\"center\">";
            echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$ids\">";
            showIconFun('publish',$rows['isactive']);
            echo "</a>";

            echo "</td>";
            echo "<td align=\"center\">";

            echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$ids\">";
            showIconFun('edit','');
            echo "</a>";

            echo "</td>";

            echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

            echo "</tr>";
            $nextlevel=$level+1;
            $this->listTable($strwhere,$page,$ids,$nextlevel,$rowcount);
        }
    }
    public function getNameById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT `name` FROM `tbl_cate_intro`  WHERE isactive=1 AND `cate_id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['name'];
    }
    public function Add_new(){
        $sql=" INSERT INTO `tbl_cate_intro`(`par_id`,`name`,`code`,`thumb`,`intro`,`type`,`isactive`) VALUES";
        $sql.="('".$this->Par_Id."','".$this->Name."','".$this->Code."','".$this->Thumb."','".$this->Intro."','".$this->Type."','".$this->isActive."')";
        return $this->objmysql->Exec($sql);
    }
    public function Update(){
        $sql = "UPDATE tbl_cate_intro SET 
        `par_id`='".$this->Par_Id."',
        `name`='".$this->Name."',
        `code`='".$this->Code."',
        `thumb`='".$this->Thumb."',
        `intro`='".$this->Intro."',
        `type`='".$this->Type."',
        `isactive`='".$this->pro["isActive"]."' 
        WHERE cate_id='".$this->ID."'";
        return $this->objmysql->Exec($sql);
    }
    public function Delete($id){
        $sql="DELETE FROM `tbl_cate_intro` WHERE `cate_id` in ('$id')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($ids,$status=''){
        $sql="UPDATE `tbl_cate_intro` SET `isactive`='$status' WHERE `cate_id` in ('$ids')";
        if($status=='')
            $sql="UPDATE `tbl_cate_intro` SET `isactive`=if(`isactive`=1,0,1) WHERE `cate_id` in ('$ids')";
        return $this->objmysql->Exec($sql);
    }
    public function Order($arr_id,$arr_quan){
        $n=count($arr_id);
        for($i=0;$i<$n;$i++){
            $sql="UPDATE `tbl_cate_intro` SET `order`='".$arr_quan[$i]."' WHERE `cate_id` = '".$arr_id[$i]."' ";
            $this->objmysql->Exec($sql);
        }
    }
    /* combo box*/
    function getListCbItem($getId='', $swhere=''){
        $sql="SELECT cate_id, name, code FROM tbl_cate_intro ".$swhere." ORDER BY `name` ASC";
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
    public function getListCategory($parid=0,$level=0){
        $sql="SELECT * FROM `tbl_cate_intro` WHERE `par_id`='$parid' AND `isactive`=1 ORDER BY `order` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $char="";
        if($level!=0){
            for($i=0;$i<$level;$i++)
                $char.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
            $char.="|---";
        }
        if($objdata->Num_rows()>0){
            echo "<ul class='menu'>";
            while($r=$objdata->Fetch_Assoc()){
                $id=$r["cate_id"]; $name=$r["name"];
				$cls='';
				if($r['isactive']==0) $cls='class="disable"';
				echo "<li $cls><a href='javascript:void(0);' onclick='group_select(this);'  oncontextmenu='return false;' onmousedown='group_right_select(this);' dataid='$id'>$char $name</a></li>";
                $nextlevel=$level+1;
                $this->getListCategory($id,$nextlevel);
            }
            echo "</ul>";
        }
    }
}
?>