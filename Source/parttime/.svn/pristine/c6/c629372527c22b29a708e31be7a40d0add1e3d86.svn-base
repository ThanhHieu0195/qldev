<?php
require_once '../part/common_start_page.php';
require_once '../models/working_calendar.php';

$output = array(
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => array()
    );

if(verify_access_right(current_account(), F_WORKING_CALENDAR_LEAVE_DAYS_STATISTIC))
{
    $from = $_REQUEST['from'];
    $to = $_REQUEST['to'];
    
    $model = new working_calendar();
    $data = $model->leave_days_statistic_list($from, $to);
    
    if ($data != NULL) {
        $output['iTotalRecords'] = count($data);
        $output['iTotalDisplayRecords'] = count($data);
        $output['aaData'] = $data;
    }
}

echo json_encode($output);

require_once '../part/common_end_page.php';

/* End of file working_calendar_leave_days_statistic.php */
/* Location: ./ajaxserver/working_calendar_leave_days_statistic.php */