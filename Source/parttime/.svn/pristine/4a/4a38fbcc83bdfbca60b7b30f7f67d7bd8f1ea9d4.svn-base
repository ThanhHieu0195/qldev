<?php
ini_set('display_errors', 1);

require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "mail.nhilong.net";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "nguyenhai@nhilong.net";  // SMTP username
$mail->Password = "Watw123@"; // SMTP password
$mail->Timeout = 10; // SMTP server timeout in seconds. 
$mail->MailerDebug = false; // Mailer class debugging on or off.

$mail->From = "nguyenhai@nhilong.net";
$mail->FromName = "Nhi Long";
//$mail->AddAddress("hainguyensms@gmail.com");
$mail->AddAddress("luubinh273@gmail.com");
//$mail->AddAddress("ellen@example.com");                  // name is optional
//$mail->AddReplyTo("info@example.com", "Information");

$mail->WordWrap = 80;                                 // set word wrap (in characters)
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "Thong bao cong viec moi";
$body = "Chào bạn, <b>Bình</b>!<br />
         <br>Bạn vừa được phân công 5 công việc với nội dung: <br>
         &nbsp; <b>Thực hiện báo cáo công việc ABC...</b><br>
         Các ngày phải hoàn thành:
         <br> &nbsp;&nbsp;• 05/05/2014
         <br> &nbsp;&nbsp;• 06/05/2014
         <br> &nbsp;&nbsp;• 07/05/2014
         <br> &nbsp;&nbsp;• 08/05/2014
         <br> &nbsp;&nbsp;• 09/05/2014
         <br> Chi tiết xem tại trang Dashboard của hệ thống website bán hàng.
         <br><br> Thân ái,<br> Admin
        ";
$mail->Body    = $body;

$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

//$mail->MsgHTML(file_get_contents('contents.html'));

if(!$mail->Send())
{
   echo "<br />Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";
?>