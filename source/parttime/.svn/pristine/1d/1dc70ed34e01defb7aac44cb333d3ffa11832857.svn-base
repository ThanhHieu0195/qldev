<?php
require_once '../part/common_start_page.php';
require_once '../models/khach.php';
require_once '../entities/guest_events_entity.php';
require_once '../models/guest_responsibility.php';
require_once '../entities/guest_development_history_entity.php';
require_once '../models/guest_events.php';
require_once '../models/database.php';
require_once '../models/guest_development_history.php';
$query = (isset($_GET['query'])) ? $_GET['query'] : '';
$email = (isset($_GET['email'])) ? $_GET['email'] : '';
$noidung = (isset($_GET['noidung'])) ? $_GET['noidung'] : '';
$mailid = (isset($_GET['mailid'])) ? $_GET['mailid'] : '';
$sendreceive = (isset($_GET['sendreceive'])) ? $_GET['sendreceive'] : '';
$dateT = (isset($_GET['dateT'])) ? $_GET['dateT'] : '';
$khach_model = new khach();
$events_model = new guest_events();
$makhach = $khach_model->get_makhachemail($email);
if (($query) && ($makhach)) {
    echo $makhach;
    exit;
} 
$continue = TRUE;
$nhanvien = "admin";
$today = current_timestamp('Y-m-d');
if ( ! empty ($makhach)) {
    $tmp = $khach_model->detail_by_id($makhach);
    if (($tmp != NULL) && ($tmp->development != GUEST_DEVELOPMENT_ONGOING)) {
        $continue = $khach_model->set_development_date($makhach, $today);
        $continue = $khach_model->set_development_status($makhach, GUEST_DEVELOPMENT_ONGOING);
    }
    if ($continue) {
        $responsibility_model = new guest_responsibility ();
        $res = new guest_responsibility_entity ();
        $res->employee_id = "loanduong";
        $res->guest_id = $makhach;
        if (! ($responsibility_model->check_res_exists($makhach))) {
            $continue = $responsibility_model->insert( $res );
        } else {
            $nhanvien = $responsibility_model->check_res_account($makhach);
        }
    }
    $today = current_timestamp('Y-m-d');
    $tmp = $events_model->schedule_from_date_history($makhach,$today);

    $todayevent = $events_model->is_existing_schedule($makhach, $today);
    $existing_next_schedule = $events_model->schedule_from_date($makhach, $today);
    if ($continue) {
        $event = new guest_events_entity ();
        $event->guest_id = $makhach;
        $event->event_date = $today;
        $event->is_event = BIT_FALSE;
        $event->enable = BIT_TRUE;
        if ($sendreceive=='r') {
            $event->note = "Khách gửi email vào hệ thống"; 
        } else {
            $event->note = "Gửi email cho khách";
        }
        if (! ($todayevent)) {
            if (empty ($tmp)) {
                $continue = $events_model->insert ( $event );
            } else {
                $event->uid = $tmp['uid'];
                $continue = $events_model->update ( $event );
            }
        }
    }

    if ($continue) {
        $history_model = new guest_development_history ();
        $h = new guest_development_history_entity ();
        $h->guest_id = $makhach;
        $h->employee_id = $nhanvien;
        $h->note = $noidung . '\n Chi tiet:  <a href="http://livechat.nhilong.com/mailbox/msg-' . $mailid . '.html" target="blank">Bấm vào đây…</a> ';
        if (($sendreceive=='r') || ($existing_next_schedule==NULL)) {
            $h->is_history = BIT_FALSE;
        } else {
            $h->is_history = BIT_TRUE;
        }
        $continue = $history_model->insert ( $h );
    }
}
?>
