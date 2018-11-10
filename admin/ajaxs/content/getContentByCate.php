<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gffunc.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.content.php");
require_once("../../libs/cls.user.php");

$objUser=new CLS_USER;
$objContent = new CLS_CONTENTS;
$objmysql = new CLS_MYSQL();

$strwhere='';
if(isset($_POST['gid'])) {
	$con_id = (int)$_POST['gid'];
	$strwhere.=" AND `cate_id`=$con_id ";
}
if(isset($_POST['strwhere'])) $strwhere.=" AND `title` like '%".$_POST['strwhere']."%'";
else $strwhere.='';

$total_rows = $objContent->getCount($strwhere);
if($total_rows>0){
	$max_rows =10;
	if($_SESSION['CUR_PAGE_CONTENTS']>ceil($total_rows/$max_rows))
		$_SESSION['CUR_PAGE_CONTENTS']=ceil($total_rows/$max_rows);
	$cur_page=(int)$_SESSION['CUR_PAGE_CONTENTS']>0 ? $_SESSION['CUR_PAGE_CONTENTS']:1;
	$star=($cur_page-1)*$max_rows;
	$leng=$max_rows;

	$objContent->getList($strwhere," order by id desc LIMIT $star,$leng ");
	$i=0;
	while ($row=$objContent->Fetch_Assoc()) {
		$i++;
		$ids= (int)$row['id'];
		$category = $objContent->getCatName($row['cate_id']);
		$author = $objUser->getNameById($row['author']);

		if($row['isactive']==1) $icon_active='<i class="fa fa-check-circle cgreen" aria-hidden="true" dataid="'.$ids.'" onclick="active_content(this)"></i>';
		else $icon_active='<i class="fa fa-times cred" aria-hidden="true" dataid="'.$ids.'" onclick="active_content(this)"></i>';

		if($row['ishot']==1) $icon_ishot='<i class="fa fa-check-circle cgreen" aria-hidden="true" dataid="'.$ids.'" onclick="active_ishot(this)"></i>';
		else $icon_ishot='<i class="fa fa-times cred" aria-hidden="true" dataid="'.$ids.'" onclick="active_ishot(this)"></i>';

		echo "<tr name=\"trow\">";
		echo "<td width=\"30\" align=\"center\">$i</td>";
		echo "<td width=\"30\" align=\"center\"><input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" /></td>";
		echo "<td>".$row['title']."</td>";
		echo "<td>".$category."</td>";
		echo "<td>".$author."</td>";

		echo '<td align="center">'.$icon_ishot.'</td>';
		echo '<td align="center">'.$icon_active.'</td>';
		echo '<td align="center"><i class="fa fa-pencil-square-o" aria-hidden="true" dataid="'.$ids.'" onclick="edit_content(this)"></i></td>';

		echo '<td align="center"><i class="fa fa-times cred" aria-hidden="true" dataid="'.$ids.'" onclick="del_content(this)"></i></td>';
		echo "</tr>";
	} // endwhile 
	echo '<div class="text-center">'.paging($total_rows,$max_rows,$cur_page).'</div>';
}// End total_rows?>
<?php unset($objContent);unset($objUser);unset($objmysql); ?>