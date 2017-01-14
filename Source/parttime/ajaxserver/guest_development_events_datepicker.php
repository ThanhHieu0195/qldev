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
    $start = $_POST['start'];
    $end = $_POST['end'];
    if (!preg_match("/\d{4}\-\d{2}-\d{2}/", $start)) {
        $start = date ( $format, $_POST ['start'] );
    }
    if (!preg_match("/\d{4}\-\d{2}-\d{2}/", $end)) {
        $end = date ( $format, $_POST ['end'] );
    }
    // DB model
    $events_model = new guest_events ();
    $hitory_model = new guest_development_history ();
    
    // Get list event by time
//    $employee_id = '';
//    if (! verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_LIST_ALL )) {

        $employee_id = current_account ();
//    }
    $list = $events_model->statistic_amount_by_time ( $start, $end, $employee_id );
    if (is_array ( $list ) && count ( $list ) > 0) {
        // Get all events
        if (empty ( $employee_id )) {
            foreach ( $list as $items ) {
                foreach ( $items ['employees'] as $e ) {
                    $total = count ( $e ['guests'] );
                    $obj = array (
                            'color' => 'green',
                            'start' => $items ['event_date'],
                            'total' => $total 
                    );
                    if ($total>=35) {
                        $obj ['color'] = 'red';
                    } else {
                        if ($total >=25) {
                           $obj ['color'] = 'yellow';
                        }
                    }
                    
                    $result [] = $obj;
                }
            }
        } else { // Get events by employee
            foreach ( $list as $items ) {
                foreach ( $items ['employees'] as $e ) {
                    $total = count ( $e ['guests'] );
                    $obj = array (
                            'color' => 'green',
                            'start' => $items ['event_date'],
                            'total' => $total
                    );
                    if ($total>=35) {
                        $obj ['color'] = 'red';
                    } else {
                        if ($total >=25) {
                           $obj ['color'] = 'yellow';
                        }
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
