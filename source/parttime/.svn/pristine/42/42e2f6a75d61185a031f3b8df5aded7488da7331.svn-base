<?php
require_once '../part/common_start_page.php';
require_once '../models/khach.php';
require_once '../models/nhomkhach.php';
require_once '../models/guest_events.php';
require_once '../models/guest_responsibility.php';
require_once '../models/guest_development_history.php';
require_once '../models/guest_favourite.php';

$result = array ();

if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_EVENTS )) {
    // Get input data
    $format = 'Y-m-d';
    $start = date ( $format, $_POST ['start'] );
    $end = date ( $format, $_POST ['end'] );
    
    // DB model
    $events_model = new guest_events ();
    $hitory_model = new guest_development_history ();
    
    // Get list event by time
    $employee_id = '';
    if (! verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_LIST_ALL )) {
        $employee_id = current_account ();
    }
    $list = $events_model->statistic_amount_by_time ( $start, $end, $employee_id );
    if (is_array ( $list ) && count ( $list ) > 0) {
        // Get all events
        if (empty ( $employee_id )) {
            foreach ( $list as $items ) {
                foreach ( $items ['employees'] as $e ) {
                    $total = count ( $e ['guests'] );
                    $contacted = $hitory_model->count_contacted ( $e ['id'], $items ['event_date'], $items ['event_date'] );
                    
                    $obj = array (
                            'id' => create_uid (),
                            'title' => sprintf ( "%s: %d/%d", $e ['name'], $contacted, $total ),
                            'start' => $items ['event_date'],
                            'url' => "../guest_development/calendar-detail.php?start={$items['event_date']}",
                            'description' => sprintf ( "Đã liên hệ cho %d/%d khách hàng cần liên hệ", $contacted, $total ) 
                    );
                    if ($contacted < $total) {
                        $obj ['color'] = 'red';
                    }
                    
                    $result [] = $obj;
                }
            }
        } else { // Get events by employee
            foreach ( $list as $items ) {
                foreach ( $items ['employees'] as $e ) {
                    $total = count ( $e ['guests'] );
                    $contacted = $hitory_model->count_contacted ( $e ['id'], $items ['event_date'], $items ['event_date'] );
                    
                    $obj = array (
                            'id' => create_uid (),
                            'title' => sprintf ( "%d/%d khách hàng", $contacted, $total ),
                            'start' => $items ['event_date'],
                            'url' => "../guest_development/calendar-detail.php?start={$items['event_date']}",
                            'description' => sprintf ( "Đã liên hệ cho %d/%d khách hàng cần liên hệ", $contacted, $total ) 
                    );
                    if ($contacted < $total) {
                        $obj ['color'] = 'red';
                    }
                    
                    $result [] = $obj;
                }
            }
        }
    }
}

echo json_encode ( $result );
// echo $result ['detail'];
// ob_end_flush();
require_once '../part/common_end_page.php';
?>
