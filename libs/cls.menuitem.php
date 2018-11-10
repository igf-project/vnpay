<?php
//ini_set('display_error',1);
class CLS_MENUITEM{
	private $objmysql=NULL;
	public function CLS_MENUITEM(){
		$this->objmysql=new CLS_MYSQL;
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `view_menuitem` ".$where.' ORDER BY `order` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getListMenuItem($mnuid,$par_id,$level){
		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0)
			return;
		$strspace="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$strspace.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$strspace.="|---";
		}
		$str="";
		while($rows=$objdata->Fetch_Assoc()){
			$str.="<option onclick=\"getIDs();\" value=\"".$rows["id"]."\" >".$strspace.$rows["name"]."</option>";
			$nextlevel=$level+1;
			$str.=$this->getListMenuItem($mnuid,$rows["id"],$nextlevel);
		}
		return $str;
	}
	public function getLevelChild($parid,$level=1){
		$sql=" SELECT * FROM view_menuitem WHERE id= $parid AND isactive=1 ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql); 
		if($objdata->Num_rows()>0){
			$number = $level++;
			$rows = $objdata->Fetch_Assoc();
			$this->getLevelChild($rows['par_id'],$number);
		}
		return $level;
	}
	public function getChildID($parid) {
		$sql = "SELECT id FROM tbl_mnuitem WHERE par_id IN ('$parid')"; 
		$this->objmysql->Query($sql);
		$ids='';
		if($this->objmysql->Num_rows()>0) {
			while($r = $this->objmysql->Fetch_Assoc()) {
				$ids.=$r[0]."','";
				$ids.=$this->getChildID($r[0]);
			}
		}
		return $ids;
	}
	public function ListMenuItem($mnuid=0,$par_id=0,$level=0){
		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ORDER BY `order`";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0)
			return;
		$style="";$str='';
		if($level>=1) $str.="<ul class=\"dropdown-menu\">";
		else {
			$str="
			<ul class='nav navbar-nav'>";
				$str.='<li><a href="'.ROOTHOST.'" title="Trang chủ"><img src="'.ROOTHOST.'images/root/icon_home.png"></a></li>';
			}
			$i=0;
			while($rows=$objdata->Fetch_Assoc()){
				$urllink="";
				if($rows['viewtype']=='link'){
					if(trim($rows['link'])!=''){
						$urllink=$rows['link'];
					}else{
						$urllink=ROOTHOST.un_unicode($rows["name"])."-mnu".$rows["mnuitem_id"].".html";
					}
				}
				else if($rows['viewtype']=='article'){
					$obj=new CLS_CONTENTS;
					$obj->getList(" AND id = '".$rows['con_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_NEWS.'/'.$row['code'].'.html';
				}
				else if($rows['viewtype']=='block'){
					$obj=new CLS_CATEGORY;
					$obj->getList("AND cate_id = '".$rows['cate_id']."' ");
					$row_cate=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_NEWS.'/'.$row_cate['code'].'/';
				}

				else if($rows['viewtype']=='cate_intro'){
					$obj = new CLS_CATEGORY_INTRO;
					$obj->getList(" AND cate_id = '".$rows['cate_intro_id']."' ");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_INTRODUCT.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='introduct'){
					$obj = new CLS_INTRODUCT;
					$obj->getList(" AND id = '".$rows['introduct_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_INTRODUCT.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='cate_service'){
					$obj = new CLS_CATE_SERVICE;
					$obj->getList(" AND cate_id = '".$rows['cate_service_id']."' ");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_SERVICE.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='service'){
					$obj = new CLS_SERVICE;
					$obj->getList(" AND id = '".$rows['service_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_SERVICE.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='cate_partner'){
					$obj = new CLS_CATE_PARTNER;
					$obj->getList(" AND cate_id = '".$rows['cate_partner_id']."' ");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_PARTNER.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='partner'){
					$obj = new CLS_PARTNER;
					$obj->getList(" AND id = '".$rows['partner_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_PARTNER.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='document_type'){
					$obj = new CLS_DOCUMENT_TYPE();
					$obj->getList(" AND doctype_id = '".$rows['gdoc_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_DOCUMENT.'/'.$row['code'].'-'.$row['doctype_id'].'/';
				}
				else if($rows['viewtype']=='document'){
					$obj = new CLS_DOCUMENT;
					$obj->getList(" AND id = '".$rows['doc_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_DOCUMENT.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='question_group'){
					$obj = new CLS_QUESTION_GROUP();
					$obj->getList(" AND cate_id = '".$rows['question_group_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_QUESTION.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='question'){
					$obj = new CLS_QUESTION;
					$obj->getList(" AND id = '".$rows['question_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_QUESTION.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='cate_guide'){
					$obj = new CLS_CATEGORY_GUIDE();
					$obj->getList(" AND cate_id = '".$rows['cate_guide_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_HELP.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='guide'){
					$obj = new CLS_GUIDE;
					$obj->getList(" AND id = '".$rows['guide_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_HELP.'/'.$row['code'].'.html';
				}


				else if($rows['viewtype']=='cate_recruitment'){
					$obj = new CLS_CATEGORY_RECRUITMENT();
					$obj->getList(" AND cate_id = '".$rows['cate_recruitment_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_RECRUITMENT.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='recruitment'){
					$obj = new CLS_RECRUITMENT;
					$obj->getList(" AND id = '".$rows['recruitment_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_RECRUITMENT.'/'.$row['code'].'.html';
				}


				$cls='';
				$cls.=$rows['class'];
				$child = $this->ListMenuItem($mnuid,$rows["id"],$level+1);
				$cls = $cls!=''?"class='".$cls."'":'';

				$str.="<li $cls>";
				if(!$child)
					$str.="<a href='".$urllink."' title='".$rows['name']."'><span>".$rows["name"]."</span></a>";
				else {
					$str.="<a class='dropdown-toggle' role='button' aria-haspopup='true'  aria-expanded='false' href='".$urllink."' title='".$rows['name']."'><span>".$rows["name"]."</span><span class='arrow_down'></span></a>";
					$str.="<span class='bulet-dropdown'></span>";
					$str.=$child;
				}
				$str.='</li>';
			}
			$str.='
		</ul>';
		return $str;
	}

	public function ListMenuFooter($mnuid=0,$par_id=0,$level=0){
		$sql="SELECT * FROM `view_menuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ORDER BY `order`";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0)
			return;
		$style="";$str='';
		if($level>=1) $str.="<ul class=\"dropdown-menu\">";
		else {
			$str="
			<ul>";
			}
			$i=0;
			while($rows=$objdata->Fetch_Assoc()){
				$urllink="";
				if($rows['viewtype']=='link'){
					if(trim($rows['link'])!=''){
						$urllink=$rows['link'];
					}else{
						$urllink=ROOTHOST.un_unicode($rows["name"])."-mnu".$rows["mnuitem_id"].".html";
					}
				}
				else if($rows['viewtype']=='article'){
					$obj=new CLS_CONTENTS;
					$obj->getList(" AND id = '".$rows['con_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_NEWS.'/'.$row['code'].'.html';
				}
				else if($rows['viewtype']=='block'){
					$obj=new CLS_CATEGORY;
					$obj->getList("AND cate_id = '".$rows['cate_id']."' ");
					$row_cate=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_NEWS.'/'.$row_cate['code'].'/';
				}

				else if($rows['viewtype']=='cate_intro'){
					$obj = new CLS_CATEGORY_INTRO;
					$obj->getList(" AND cate_id = '".$rows['cate_intro_id']."' ");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_INTRODUCT.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='introduct'){
					$obj = new CLS_INTRODUCT;
					$obj->getList(" AND id = '".$rows['introduct_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_INTRODUCT.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='cate_service'){
					$obj = new CLS_CATE_SERVICE;
					$obj->getList(" AND cate_id = '".$rows['cate_service_id']."' ");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_SERVICE.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='service'){
					$obj = new CLS_SERVICE;
					$obj->getList(" AND id = '".$rows['service_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_SERVICE.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='cate_partner'){
					$obj = new CLS_CATE_PARTNER;
					$obj->getList(" AND cate_id = '".$rows['cate_partner_id']."' ");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_PARTNER.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='partner'){
					$obj = new CLS_PARTNER;
					$obj->getList(" AND id = '".$rows['partner_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_PARTNER.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='document_type'){
					$obj = new CLS_DOCUMENT_TYPE();
					$obj->getList(" AND doctype_id = '".$rows['gdoc_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_DOCUMENT.'/'.$row['code'].'-'.$row['doctype_id'].'/';
				}
				else if($rows['viewtype']=='document'){
					$obj = new CLS_DOCUMENT;
					$obj->getList(" AND id = '".$rows['doc_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_DOCUMENT.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='question_group'){
					$obj = new CLS_QUESTION_GROUP();
					$obj->getList(" AND cate_id = '".$rows['question_group_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_QUESTION.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='question'){
					$obj = new CLS_QUESTION;
					$obj->getList(" AND id = '".$rows['question_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_QUESTION.'/'.$row['code'].'.html';
				}

				else if($rows['viewtype']=='cate_guide'){
					$obj = new CLS_CATEGORY_GUIDE();
					$obj->getList(" AND cate_id = '".$rows['cate_guide_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_HELP.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='guide'){
					$obj = new CLS_GUIDE;
					$obj->getList(" AND id = '".$rows['guide_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_HELP.'/'.$row['code'].'.html';
				}


				else if($rows['viewtype']=='cate_recruitment'){
					$obj = new CLS_CATEGORY_RECRUITMENT();
					$obj->getList(" AND cate_id = '".$rows['cate_recruitment_id']."' ");
					$row = $obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_RECRUITMENT.'/'.$row['code'].'/';
				}
				else if($rows['viewtype']=='recruitment'){
					$obj = new CLS_RECRUITMENT;
					$obj->getList(" AND id = '".$rows['recruitment_id']."'");
					$row=$obj->Fetch_Assoc();
					$urllink=ROOTHOST.LINK_RECRUITMENT.'/'.$row['code'].'.html';
				}


				$cls='';
				$cls.=$rows['class'];
				$child = $this->ListMenuFooter($mnuid,$rows["id"],$level+1);
				$cls = $cls!=''?"class='".$cls."'":'';

				$str.="<li $cls>";
				if(!$child)
					$str.="<a href='".$urllink."' title='".$rows['name']."'><span>".$rows["name"]."</span></a>";
				else {
					$str.="<a class='dropdown-toggle' role='button' aria-haspopup='true'  aria-expanded='false' href='".$urllink."' title='".$rows['name']."'><span>".$rows["name"]."</span><span class='arrow_down'></span></a>";
					$str.="<span class='bulet-dropdown'></span>";
					$str.=$child;
				}
				$str.='</li>';
			}
			$str.='
		</ul>';
		return $str;
	}
}
?>