<?php
require_once '../part/common_start_page.php';
require_once '../models/khachguicatalog.php';


$result = array(
        'result'   => 0,                // Error status
        'message'  => 'Khong the them khach.' // Message
    );

if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_EVENTS ))
{
    $makhach = $_POST['makhach'];
    error_log ("Add new" . $makhach, 3, '/var/log/phpdebug.log');
    $khachvip = new khachvip();
    if (!($khachvip->khach_exist($makhach))) {
        if ($khachvip->them_khach_vip($makhach)){
            $result['result'] = 1;
            $result['message'] = 'Them khach thanh cong';
        } else {
            $result['result'] = 0;
        } 
    } else {
        $result['result'] = 0;
        $result['message'] = 'Khach da duoc them vao truoc day';
    }
}

echo json_encode( $result );

require_once '../part/common_end_page.php';
?>
