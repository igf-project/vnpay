<?php
ini_set('display_errors', 1);
class CLS_SLIDER{
	private $pro=array(
			'ID'=>'-1',
			'Slogan'=>'',
			'Intro'=>'',
			'Link'=>'',
			'Thumb'=>'',
			'Type'=>'0',
			'Order'=>'0',
			'isActive'=>'1');
	private $objmysql;
	public function CLS_SLIDER(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_PRODUCTS Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_PRODUCTS Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($strwhere=""){
		$sql=" SELECT * FROM tbl_slider $strwhere";
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function listTable($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT tbl_slider.* FROM tbl_slider $strwhere LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);	$i=0;
		while($rows=$objdata->Fetch_Assoc()){
			$i++;
			$ids=$rows['id'];
            $slogan=$rows['slogan'];
            $img=$rows['thumb'];
            $order=$rows['order'];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";

			echo "<td width=\"30\" align=\"center\"><input type=\"checkbox\" name=\"chk\" id=\"chk\" onclick=\"docheckonce('chk');\" value=\"$ids\"/></td>";

			echo "<td><img src='$img' class='img-obj' width='120px'></td>";
			echo "<td>$slogan</td>";
            echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" class=\"order\"></td>";
			echo "<td align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$ids\">";
			showIconFun('publish',$rows['isactive']);
			echo "</a>";
			echo "</td>";
			echo "<td align=\"center\">";
		
			echo "<a href=\"".ROOTHOST_ADMIN.COMS."/edit/$ids\">";
			showIconFun('edit','');
			echo "</a>";
		
			echo "</td>";
			
			echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

			echo "</tr>";
		}
	}
	public function Add_new(){
		$sql="INSERT INTO `tbl_slider` ( `slogan`, `intro`, `type`,`thumb`,`link`, `isactive`) VALUES ";
		$sql.="('".$this->Slogan."','".$this->Intro."','".$this->Type."','".$this->Thumb."','".$this->Link."','".$this->isActive."')";
		return $this->objmysql->Exec($sql);
	}
	public function Update(){
		$sql="UPDATE `tbl_slider` SET  
				`slogan`='".$this->Slogan."',
				`intro`='".$this->Intro."',
				`thumb`='".$this->Thumb."',
				`link`='".$this->Link."'
		        WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	public function Delete($ids){
		$sql="DELETE FROM `tbl_slider` WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setHot($ids){
		$sql="UPDATE `tbl_slider` SET `ishot`=if(`ishot`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function setActive($ids,$status=''){
		$sql="UPDATE `tbl_slider` SET `isactive`='$status' WHERE `id` in ('$ids')";
		if($status=='')
			$sql="UPDATE `tbl_slider` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$ids')";
		return $this->objmysql->Exec($sql);
	}
	public function Order($ids,$order){
		$sql="UPDATE tbl_slider SET `order`='".$order."' WHERE `id`='".$ids."'";	
		return $this->objmysql->Exec($sql);
	}
	public function Orders($arids,$arods){
		for($i=0;$i<count($arids);$i++){
			$this->Order($arids[$i],$arods[$i]);
		}
	}
    /* combo box*/
    function getListCbItem($getId='', $swhere='', $arrId=''){
        $sql="SELECT id, name, code FROM tbl_slider WHERE ".$swhere." `isactive`='1' ORDER BY `name` ASC";
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
            ?>


        <?php
        }
    }
}
?>