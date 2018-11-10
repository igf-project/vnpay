<script language="javascript">
    // function chechemail(){
    // 	var name=document.getElementById("contact_sur_name");
    // 	var phone=document.getElementById("contact_phone");
    // 	var email=document.getElementById("contact_email");
    // 	var subject=document.getElementById("contact_subject");
    // 	var content=document.getElementById("contact_content");
    // 	var capchar=document.getElementById("contact_txt_sercurity");
    // 	reg1=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
    // 	testmail=reg1.test(email.value);

    // 	if(name.value==""){
    // 		document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập họ tên</font>';
    // 		name.focus();
    // 		return false;
    // 	}
    // 	if(phone.value==""){
    // 		document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập số điện thoại liên hệ</font>';
    // 		phone.focus();
    // 		return false;
    // 	}
    // 	else if(isNaN(phone.value)){
    // 		document.getElementById('message').innerHTML = '<font color="#FF0000">Số điện thoại không hợp lệ</font>';
    // 		phone.focus();
    // 		return false;
    // 	}
    // 	if(!testmail){
    // 		document.getElementById('message').innerHTML = '<font color="#FF0000">Địa chỉ Email không hợp lệ</font>';
    // 		email.focus();
    // 		return false;
    // 	}
    // 	if(subject.value==""){
    // 		document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập tiêu đề thư</font>';
    // 		subject.focus();
    // 		return false;
    // 	}
    // 	if(content.value==""){
    // 		document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập nội dung thư</font>';
    // 		content.focus();
    // 		return false;
    // 	}
    // 	// if(areas.value==""){
    // 	// 	document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng chọn vùng</font>';
    // 	// 	areas.focus();
    // 	// 	return false;
    // 	// }
    // 	if(capchar.value==""){
    // 		document.getElementById('message').innerHTML = '<font color="#FF0000">Vui lòng nhập mã bảo mật</font>';
    // 		capchar.focus();
    // 		return false;
    // 	}
    // 	document.getElementById("frmcontact").submit();
    // 	return true;
    // }
</script>
<?php
$noidung="<h2>Thông tin liên hệ:</h2>";
$conf = new CLS_CONFIG();

$conf->getList();
$row = $conf->Fetch_Assoc();

// $email_r = explode(',,|',$row['email']);
$email_r=$row['email'];
$conf->load_config();
$message_ok='';
$err='';
if(isset($_POST["cmd_send_contact"])){
    $capchar=addslashes($_POST["contact_txt_sercurity"]);
    if($_SESSION['SERCURITY_CODE']!=$capchar){
        $err='<font color="red">Mã bảo mật không chính xác</font>';
    }
    else{
        $name=addslashes($_POST["contact_sur_name"]);
        $email=addslashes($_POST["contact_email"]);
        $phone=addslashes($_POST["contact_phone"]);
        $subject=addslashes($_POST["contact_subject"]);
        $text=addslashes($_POST["contact_content"]);
        // $areas=addslashes($_POST["contact_areas"]);

        if($name!="")
            $noidung.="<strong>Họ tên:</strong> ".$name."<br />";
        if($email!="")
            $noidung.="<strong>Email:</strong> ".$email."<br />";
        if($phone!="")
            $noidung.="<strong>Điện thoại:</strong> ".$phone."<br />";

        if($text!="")
            $noidung.="<strong>Nội dung:</strong><br>".$text."<br />";

        $objMailer=new CLS_MAILER();
        $header='MIME-Version: 1.0' . "\r\n";
        $header.='Content-type: text/html; charset=utf-8' . "\r\n";//Content-type: text/html; charset=iso-8859-1′ . “\r\n
        $header.="FROM: <".$email."> \r\n";
        $objMailer->FROM="$name<$email>";//WEB_MAIL;
        $objMailer->HEADER=$header;
        $objMailer->TO=$email_r; //somebody@example.com, somebodyelse@example.com
        if($subject!='') $objMailer->SUBJECT=$subject;
        else $objMailer->SUBJECT = "Thông tin liên hệ từ Website: ".$_SERVER['SERVER_NAME'];
        $objMailer->CONTENT=$noidung;
        $objMailer->SendMail();
        $message_ok = '<div><font color="#FF0000"><strong>Thư của Quý khách đã được gửi thành công. Chúng tôi sẽ phúc đáp tới Quý khách trong thời gian sớm nhất. Cảm ơn Quý khách ! </strong></font></div><div align="center">--------- o0o ---------</div>';
    }
}

?>
<style type="text/css">
    #frmcontact .form-control {
        margin: 10px 0px;
    }
</style>

<div class="box contact-form">
    <?php if($message_ok!='') echo $message_ok;
    else {
        ?>
        <div class="container">
            <div class="contact-info">
                <h3>CONTACT FORM</h3>
            </div>
            <div class="row">
                <form class="frm-contact">
                    <div class="col-md-7">
                        <p>Quý khách muốn biết thêm thông tin, hỏi đáp, thắc mắc Vui lòng liên hệ với các thông tin dưới đây: </p>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" placeholder="Họ và tên*" required class="form-control" name="contact_sur_name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" placeholder="E-mail" required class="form-control" name="contact_email" id="contact_email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Tiêu đề thư" required class="form-control" name="contact_subject" id="contact_subject">
                        </div>

                        <div class="box-area">
                            <textarea placeholder="Nội dung" required class="form-control" style="min-height: 120px" name="contact_content"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <input type="text"  name="contact_txt_sercurity" id="contact_txt_sercurity" class="form-control"/>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <img src="extensions/captcha/CaptchaSecurityImages.php?width=110&height=40" align="left" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="box-btn text-center">
                            <input type="submit" value="SUBMIT" id="cmd_send_contact" name="cmd_send_contact">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="contact-content">
                            <h3>Thông tin liên hệ</h3>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                include_once(LIB_PATH.'cls.showroom.php');
                                $objRoom=new CLS_SHOWROOM();
                                $objRoom->getList();
                                $i=0;
                                while($rows=$objRoom->Fetch_Assoc()){
                                    $i++;
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading<?php echo $i;?>">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" <?php if($i==1) echo 'aria-expanded="true"';?>  aria-controls="collapse<?php echo $i;?>">
                                                    <?php echo $rows['title'];?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $i;?>" class="panel-collapse collapse <?php if($i==1) echo 'in';?>" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
                                            <div class="panel-body">
                                                <p><?php echo $rows['intro'];?></p>
                                                <ul>
                                                    <li>
                                                        <i class="fa fa-map-marker"></i> <?php echo $rows['address'];?><br>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-phone" aria-hidden="true"></i> <?php echo $rows['phone'];?><br>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-phone" aria-hidden="true"></i> <?php echo $rows['tel'];?><br>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>


                        </div>
                    </div>
                </form>
            </div>

        </div>
    <?php } ?>

</div>
<div class="box-map">
    <div class="container">
        <ul class="list-inline showroom-map" id="action-map">
            <?php
            $objRoom->getList();
            $i=0;
            while($rows=$objRoom->Fetch_Assoc()){
                $i++;?>
                <li <?php if($i==1) echo 'active'?> data-value="<?php echo $rows['id'];?>"><?php echo $rows['title'];?></li>
            <?php
            }
            ?>
        </ul>
        <div class="" id="respon-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d493.35978840029367!2d105.79217333035436!3d20.978333377120155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0xc61d35161c7df3f1!2zQsOyIHTGoSBUw6J5IE5pbmggVMOgaSBTYW5o!5e0!3m2!1sen!2s!4v1460170525701" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
</div>
<script>
    $('#action-map li').click(function(){
        var val=$(this).attr('data-value');
        $.get('<?php echo ROOTHOST;?>ajaxs/map/list.php',{val},function(response_data){
            $('#respon-map').html(response_data);
        })
    });
</script>