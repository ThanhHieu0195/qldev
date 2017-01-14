<?php
require_once '../part/common_start_page.php';
require_once '../models/khach.php';
require_once '../entities/guest_events_entity.php';
require_once '../models/guest_responsibility.php';
require_once '../models/guest_events.php';
require_once '../models/database.php';
$phone = (isset($_GET['phone'])) ? $_GET['phone'] : '';
echo $phone;
$khach_model = new khach();
$events_model = new guest_events();
$makhach = $khach_model->get_makhach($phone);
$continue = TRUE;
if ( ! empty ($makhach)) {
    $tmp = $khach_model->detail_by_id($makhach);
    if (($tmp != NULL) && ($tmp->development != GUEST_DEVELOPMENT_ONGOING)) {
        $date = current_timestamp('Y-m-d');
        $continue = $khach_model->set_development_date($makhach, $date);
        $continue = $khach_model->set_development_status($makhach, GUEST_DEVELOPMENT_ONGOING);
    }
    if ($continue) {
        $responsibility_model = new guest_responsibility ();
        $res = new guest_responsibility_entity ();
        $res->employee_id = current_account ();
        $res->guest_id = $makhach;
        if (! ($responsibility_model->check_res_exists($makhach))) {
            $continue = $responsibility_model->insert( $res );
        }
    }
    if ($continue) {
        $event = new guest_events_entity ();
        $today = current_timestamp('Y-m-d');
        $event->guest_id = $makhach;
        $event->event_date = $today;
        $event->note = "Khach hang goi vao"; 
        $event->is_event = BIT_FALSE;
        $event->enable = BIT_TRUE;
        $todayevent = $events_model->is_existing_schedule($makhach, $today);
        if (! ($todayevent)) {
            $continue = $events_model->insert ( $event ); // DB insert
        }
        if ($continue) {
            redirect("../guest_development/contact.php?i=" . $makhach . "#history");
        }
    }
} else {
    redirect("../guest_development/add-new.php?phone=" . $phone);
}
?>
