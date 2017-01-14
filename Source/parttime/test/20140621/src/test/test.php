<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Test model</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Script-Type"
	content="text/javascript; charset=utf-8" />
</head>
<body>
        <?php
        require_once '../part/common_start_page.php';
        ini_set ( 'display_errors', 1 );
        
        require_once '../models/guest_events.php';
        require_once '../models/guest_responsibility.php';
        require_once '../models/guest_development_history.php';
        require_once '../models/guest_favourite.php';
        
        // DB model
        $events_model = new guest_events ();
        $hitory_model = new guest_development_history ();
        
        $start = $end = '2014-06-20';
        
        $result = array ();
        $employee_id = '';
        $list = $events_model->statistic_amount_by_time ( $start, $end, $employee_id );
        if (is_array ( $list ) && count ( $list ) > 0) {
            // Get all events
            if (empty ( $employee_id )) {
                foreach ( $list as $items ) {
                    foreach ( $items ['employees'] as $e ) {
                        $result [] = array (
                                'id' => create_uid (),
                                'title' => sprintf ( "%s: %d", $e ['name'], count ( $e ['guests'] ) ),
                                'start' => $items ['event_date'],
                                'url' => "../guest_development/calendar-detail.php?start={$items['event_date']}",
                                'contacted' => $hitory_model->count_contacted ( $e ['id'], $items ['event_date'] ) 
                        );
                    }
                }
            } else { // Get events by employee
                foreach ( $list as $items ) {
                    foreach ( $items ['employees'] as $e ) {
                        $result [] = array (
                                'id' => create_uid (),
                                'title' => sprintf ( "%d khách hàng", count ( $e ['guests'] ) ),
                                'start' => $items ['event_date'],
                                'url' => "../guest_development/calendar-detail.php?start={$items['event_date']}" 
                        );
                    }
                }
            }
        }
        
        debug ( $result );
        ?>
    </body>
</html>
