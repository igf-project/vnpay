<?php
$tmp = new CLS_TEMPLATE();
defined("ISHOME") or die("Can't acess this page, please come back!");
$thisurl= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cur_page=isset($_GET['page'])? $_GET['page']: '1';
$strWhere='';$keywork='';


if(isset($_GET['q'])){
	$keywork = addslashes(strip_tags($_GET['q']));
	$strWhere=" AND `title` LIKE '%$keywork%' OR `intro` LIKE '%$keywork%' ";
}
?>
<div class="page page-list-help">
	<div class="page-header">
		<?php
        $tmp = new CLS_TEMPLATE();
        $tmp->loadModule('banner3');
        ?>
		<div class="container">
			<div class="h1">
				<ul class="breadcrumb">
					<li><a href="<?php echo ROOTHOST.LINK_HELP;?>"><?php echo HELP ?></a></li>
					<li><a href="<?php echo ROOTHOST.LINK_HELP.'/'.LINK_SEARCH;?>"><?php echo SEARCH ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="page-body">
			<div class="box-contents">
				<div class="row row_26">
					<div class="col-sm-4 column-left">
						<?php $tmp->loadModule('box5') ?>
					</div>
					<div class="col-sm-8 column-right">
						<h1 class="h1_search"><?php echo SEARCH_RESULTS ?> <font color="red">"<?php echo $keywork;?>"</font></h1>
						<div class="form-search-help">
							<form id="form_search_help" name="frm-search" method="get" action="<?php echo ROOTHOST.LINK_HELP.'/'.LINK_SEARCH;?>">
                                <input type="hidden" name="q" value="">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="ip_search_help" name="" class="form-control input-lg" placeholder="<?php echo PLACEHOLDER_SEARCH ?>" required>
                                        <div class="input-group-btn"><button class="btn btn-lg"><?php echo SEARCH ?></button></div>
                                    </div>
                                </div>
                            </form>
						</div>
						<div class="box-list-help">
							<?php
							$total_rows = $obj->getCount($strWhere);
							if($total_rows>0){
								$max_rows= MAX_ROWS;
								$max_page=ceil($total_rows/$max_rows);
								if(isset($_GET['page'])){$cur_page=$_GET['page'];}
								if($cur_page>$max_page) $cur_page=$max_page;
								$start=($cur_page-1)*$max_rows;


								echo '<ul class="list-help">';
								$obj->getList($strWhere," LIMIT $start,$max_rows");
								while ($row=$obj->Fetch_Assoc()) {
									$id = $row['id'];
									$title = stripcslashes($row['title']);
									$code = stripcslashes($row['code']);
									$link = ROOTHOST.LINK_HELP.'/'.$code.'.html';
									echo '<li><i class="fa fa-info-circle" aria-hidden="true"></i><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
								}
								echo '</ul>';


								echo '<div class="clearfix"></div><div class="text-center">';
								$par=getParameter($thisurl);
								$par['page']="{page}";
								$link_full=conver_to_par($par);
								paging1($total_rows,$max_rows,$cur_page,$link_full);
								echo '</div>';
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>