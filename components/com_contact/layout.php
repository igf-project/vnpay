<script language="javascript">
    function chechemail(){
        var name=document.getElementById("contact_sur_name");
        var phone=document.getElementById("contact_phone");
        var email=document.getElementById("contact_email");
        var subject=document.getElementById("contact_subject");
        var content=document.getElementById("contact_content");
        var capchar=document.getElementById("contact_txt_sercurity");
        reg1=/^[0-9A-Za-z]+[0-9A-Za-z_]*@[\w\d.]+.\w{2,4}$/;
        testmail=reg1.test(email.value);

        if(name.value==""){
            document.getElementById('message').innerHTML = '<font color="#FF0000"><?php echo PLEASE_FULLNAME ?></font>';
            name.focus();
            return false;
        }
        if(phone.value==""){
            document.getElementById('message').innerHTML = '<font color="#FF0000"><?php echo PLEASE_PHONE ?></font>';
            phone.focus();
            return false;
        }
        else if(isNaN(phone.value)){
            document.getElementById('message').innerHTML = '<font color="#FF0000"><?php echo PLEASE_ER_PHONE ?></font>';
            phone.focus();
            return false;
        }
        if(!testmail){
            document.getElementById('message').innerHTML = '<font color="#FF0000"><?php echo PLEASE_ER_EMAIL ?></font>';
            email.focus();
            return false;
        }
        if(subject.value==""){
            document.getElementById('message').innerHTML = '<font color="#FF0000"><?php echo PLEASE_MAIL_TITLE ?></font>';
            subject.focus();
            return false;
        }
        if(content.value==""){
            document.getElementById('message').innerHTML = '<font color="#FF0000"><?php echo PLEASE_MAIL_CONTENT ?></font>';
            content.focus();
            return false;
        }
        // if(capchar.value==""){
        //     document.getElementById('message').innerHTML = '<font color="#FF0000"><?php echo PLEASE_CAPCHA ?></font>';
        //     capchar.focus();
        //     return false;
        // }
        document.getElementById("frmcontact").submit();
        return true;
    }
</script>
<?php
require_once ("libs/cls.configsite.php");
require_once ("libs/cls.mail.php");
$tmp = new CLS_TEMPLATE();
$conf = new CLS_CONFIG();
$conf->getList();
$row_conf = $conf->Fetch_Assoc();
// $email_r = explode(',,|',$row_conf['email']);
$email_r = $row_conf['email'];




$message_ok='';
$err='';
$name=$email=$phone=$subject=$text='';
if(isset($_POST["cmd_send_contact"])){
    // $capchar=addslashes($_POST["contact_txt_sercurity"]);
    // if($_SESSION['SERCURITY_CODE']!=$capchar){
    //     $err='<font color="red">Mã bảo mật không chính xác</font>';
    // }
    // else{
        $name=addslashes($_POST["contact_sur_name"]);
        $email=addslashes($_POST["contact_email"]);
        $phone=addslashes($_POST["contact_phone"]);
        $subject=addslashes($_POST["contact_subject"]);
        $text=addslashes($_POST["contact_content"]);

        if($name!="")
            $noidung.="<strong>Họ tên:</strong> ".$name."<br />";
        if($email!="")
            $noidung.="<strong>Email:</strong> ".$email."<br />";
        if($phone!="")
            $noidung.="<strong>Điện thoại:</strong> ".$phone."<br />";

        if($text!="")
            $noidung.="<strong>Nội dung:</strong><br>".$text."<br />";



        $to = $email_r;  //khai báo địa chỉ mail người nhận
        $subject = $subject; // chủ đề của mail
        // Đây là nội dung mail cần gửi. Để xuống dòng , chèn \n vào cuối dòng
        $message = $noidung;
        // Khai báo thông tin mail người gửi. Cách dòng bằng \r\n
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "From: ".$email."\r\nReply-To: ".$email;
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        $headers .= "From: " .$email. "\r\n" .
                    "Reply-To: " .$email. "\r\n" .
                    "X-Mailer: PHP/" . phpversion();
        
         //Gửi mail
        $mail_sent = @mail( $to, $subject, $message, $headers );
        // Nếu thành công thì xuất dòng thông báo "Mail sent", ngược lại thì xuất  "Mail failed"
        if($mail_sent){
            $message_ok = '<div style="text-align:center;"><font color="#FF0000"><strong>Thư của Quý khách đã được gửi thành công. Chúng tôi sẽ phúc đáp tới Quý khách trong thời gian sớm nhất. Cảm ơn Quý khách ! </strong></font></div><div align="center">--------- o0o ---------</div>';
        }else{
            $message_ok ='Có lỗi trong quá trình gửi mail. Xin vui lòng thử lại sau!.';
        }


        // $objMailer=new CLS_MAILER();
        // $header='MIME-Version: 1.0' . "\r\n";
        // $header.='Content-type: text/html; charset=utf-8' . "\r\n";     //Content-type: text/html; charset=iso-8859-1′ . “\r\n
        // $header.="FROM: <".$email."> \r\n";
        // $objMailer->FROM="$name<$email>";       //WEB_MAIL;
        // $objMailer->HEADER=$header;
        // $objMailer->TO=$email_r;                //somebody@example.com, somebodyelse@example.com
        // if($subject!='') $objMailer->SUBJECT=$subject;
        // else $objMailer->SUBJECT = "Thông tin liên hệ từ Website: ".$_SERVER['SERVER_NAME'];
        // $objMailer->CONTENT=$noidung;


        // if($objMailer->SendMail()){
        //     $message_ok = '<div style="text-align:center;"><font color="#FF0000"><strong>Thư của Quý khách đã được gửi thành công. Chúng tôi sẽ phúc đáp tới Quý khách trong thời gian sớm nhất. Cảm ơn Quý khách ! </strong></font></div><div align="center">--------- o0o ---------</div>';
        // }else{
        //     $message_ok ='Có lỗi trong quá trình gửi mail. Xin vui lòng thử lại sau!.';
        // }
        
    // }
}

?>
<div class="page page-list-service">
    <div class="page-body">
        <div class="contact-form">
            <div class="container">
                <?php if($message_ok==""){ ?>

                <div class="contact-info">
                    <h1><?php echo CONTACT ?></h1><br/>
                </div>
                <div class="row">
                    <form class="frm-contact" id="frmcontact" method="post" >
                        <div id="message" class="col-md-12"><?php if($err!='') echo $err;?></div>
                        <div class="col-md-7 col-sm-7">
                            <p><?php echo CONTACT_TXT_1 ?> </p>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 m-mar15">
                                        <input type="text" placeholder="<?php echo CONTACT_PLA_FULLNAME ?>" required class="form-control" value="<?php echo $name ?>" name="contact_sur_name">
                                    </div>
                                    <div class="col-md-6 in-email">
                                        <input type="email" placeholder="<?php echo CONTACT_PLA_EMAIL ?>" required class="form-control" name="contact_email" value="<?php echo $email ?>" id="contact_email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="<?php echo CONTACT_PLA_PHONE ?>" class="form-control" name="contact_phone" value="<?php echo $phone ?>" id="contact_phone">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="<?php echo CONTACT_PLA_TITLE ?>" required class="form-control" name="contact_subject" value="<?php echo $name ?>" id="contact_subject">
                            </div>

                            <div class="form-group box-area">
                                <textarea placeholder="<?php echo CONTACT_PLA_CONTENT ?>" required class="form-control" style="min-height: 120px" name="contact_content"><?php echo $text ?></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-7 col-xs-6">
                                        <input type="text"  name="contact_txt_sercurity" id="contact_txt_sercurity" class="form-control" required />
                                    </div>
                                    <div class="col-md-6 col-sm-5 col-xs-6">
                                        <img src="<?php echo ROOTHOST;?>admin/extensions/captcha/CaptchaSecurityImages.php?width=110&height=40" align="left" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div><br/><br/>
                            <div class="box-btn text-center">
                                <input type="submit" value="<?php echo SEND_MAIL ?>" id="cmd_send_contact" name="cmd_send_contact" onclick="return chechemail();" class="btn btn-primary">
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="contact-content">
                                <?php $tmp->loadModule('box7') ?>
                            </div>
                        </div>
                    </form>
                </div>

                <?php }else{ echo $message_ok; } ?>
            </div>
        </div>
    </div>
</div>