<div id="menus" class="toolbars">
    <form id="frm_menu" name="frm_menu" method="post" action="">
        <input type="hidden" name="txtorders" id="txtorders" />
        <input type="hidden" name="txtids" id="txtids" />
        <input type="hidden" name="txtaction" id="txtaction" />

        <ul class="list-inline">
            <?php 
            if(!isset($_GET["task"])){ ?>

            <li><a class="btn btn-default" onclick="dosubmitAction('frm_menu','public');"><i class="fa fa-check-circle-o cgreen" aria-hidden="true"></i> Hiển thị</a></li>

            <li><a class="btn btn-default" onclick="dosubmitAction('frm_menu','unpublic');"><i class="fa fa-times-circle-o cred" aria-hidden="true"></i> Ẩn</a></li>

            <li><a class="addnew btn btn-default" href="<?php echo ROOTHOST_ADMIN.COMS;?>/add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm mới</a></li>

            <li><a class="delete btn btn-default" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="Xóa"><i class="fa fa-times-circle cred" aria-hidden="true"></i> Xóa</a></li>

            <?php }else{?>

            <li><a class="save btn btn-default" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</a></li>

            <li><a class="btn btn-default"  href="<?php echo ROOTHOST_ADMIN.COMS;?>" title="Đóng"><i class="fa fa-sign-out" aria-hidden="true"></i> Đóng</a></li>

            <?php } ?>
        </ul>
    </form>
</div>