<?php
require_once '../part/common_start_page.php';
require_once '../models/guest_events.php';
require_once '../models/guest_development_history.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<?php
    require_once '../models/news.php';
    require_once '../models/news_group.php';
    require_once '../models/mail_helper.php';
    function sendInformMail($title, $content, $dest, $subject) {
        $body = "Chào bạn, <br />
                 <br><b>Bài viết mới với tiêu đề: </b><br>
                 &nbsp;&nbsp;{$title}
                 <br><b>Nội dung: </b><br>
                  {$content}
                 <br><br>Chi tiết xem tại trang khách hàng của hệ thống website bán hàng.
                 <br><br> Thân ái,<br> Admin
                ";
        
        // Send a mail
        $data = array (
                'to' => array (
                        'email' => $dest,
                        'name' => "NhiLong" 
                ),
         	'toarray' =>array(
		),
                'body' => $body 
        );
        // debug ( $data );
        $mail = new mail_helper ();
        //error_log ("Add new " . $dest, 3, '/var/log/phpdebug.log');
        if (! $mail->Send( $data, $subject )) {
             debug ( $mail->ErrorInfo );
             //error_log ("Add new " . $mail->ErrorInfo . $dest, 3, '/var/log/phpdebug.log');
        }
    }
				
   
if(isset($_POST['submit'])){
	$nhomkhach = 69;
	$diachi = $_POST['diachi'];
	$hoten = $_POST['hoten'];
	$ghichu = $_POST['ghichu'];
	$dienthoai = $_POST['sdt'];
	$email = $_POST['email'];
        if ($ghichu=="Khách liên hệ chờ khuyến mãi") {
            $dest = "cskh@nhilong.com";
            $subject = "Khách liên hệ chờ khuyến mãi";
        } else {
            $dest = "kinhdoanh@nhilong.com";
            $subject = "Khách liên hệ làm đối tác";
        }
        include_once '../models/khach.php';
        include_once '../models/marketing.php';      
        $guest = new khach();
	$customerid = $guest->get_customerid($dienthoai) ;
	if($customerid){
            $title = "Phản hồi của khách hàng đã có trong hệ thông";
            $content = "&nbsp;&nbsp; Khách hàng:{$hoten}<br> &nbsp;&nbsp; Số điện thoại:{$dienthoai} <br> &nbsp;&nbsp; Email:{$email}<br> &nbsp;&nbsp; Địa chỉ:{$diachi}<br> &nbsp;&nbsp; Nội dung yêu cầu:<br>&nbsp; &nbsp; &nbsp; {$ghichu}";
            if (empty($title) || empty($content)) {
                $result = FALSE;
                $message = "Vui lòng nhập tiêu đề và nội dung bài viết!";
            } else {                                                               
                    sendInformMail($title, $content, $dest, $subject);                
                
            }
           
  	    //khach hang cu
 	    $events_model = new guest_events ();
	    $history_model = new guest_development_history ();
	    $event = $events_model->update_customer_online($customerid);
	    //add note
	    $h = new guest_development_history_entity ();
            $h->guest_id = $customerid;
            $h->employee_id = "admin";
	    $h->note = $ghichu;
	    $h->is_history = BIT_TRUE;
	    $continue = $history_model->insert ( $h );
	    echo '<center><span class="input-notification success png_bg">Cảm ơn quý khách, công ty sẽ liên hệ với quý khách sớm nhất có thể </span><br /><br /></center>';
            if ($continue) {
                $maketing = new marketing();
                $maketing->khach_hang_lienhe($customerid);
            }
	}else{
            $them_khach = $guest->them_khach_online($nhomkhach, $hoten, $diachi, 0, $dienthoai,$email);
            //them khach hang thanh cong
            if ($them_khach) {
                include_once '../models/marketing.php';
                //echo $guest->_sql . '<br />';
	        $maketing = new marketing();
                $makhach = $maketing->get_makhach($dienthoai);
	        $lienhe = $maketing->insert_lienhe("admin",$makhach,"Khách hàng liên hệ qua website",0,$ghichu );
	        if($lienhe){
	    	    //
	    	    $title = "Phản hồi của khách hàng mới";
                    $content = "&nbsp;&nbsp; Khách hàng:{$hoten}<br> &nbsp;&nbsp; Số điện thoại:{$dienthoai} <br> &nbsp;&nbsp; Email:{$email}<br> &nbsp;&nbsp; Địa chỉ:{$diachi}<br> &nbsp;&nbsp; Nội dung yêu cầu:<br>&nbsp; &nbsp; &nbsp; {$ghichu}";
                    if (empty($title) || empty($content)) {
                        $result = FALSE;
                        $message = "Vui lòng nhập tiêu đề và nội dung bài viết!";
                    } else {                                                               
                        sendInformMail($title, $content, $dest, $subject);                
                    }
                    echo '<center><span class="input-notification success png_bg">Cảm ơn quý khách, công ty sẽ liên hệ với quý khách sớm nhất có thể</span><br /><br /></center>';
	    	}else{
	    	    echo '<center><span class="input-notification success png_bg">thêm liên hệ thất bại</span><br /><br /></center>';
	    	}
            } else {
                echo '<center><span class="input-notification error png_bg">' . $guest->getMessage() . '</span></center>';
	    }
        }
}
?>
</body>
</html>
