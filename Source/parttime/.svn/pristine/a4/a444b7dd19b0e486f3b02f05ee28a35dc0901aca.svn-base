<?php
require_once '../part/common_start_page.php';
require_once '../models/task_result_category.php';
require_once '../models/task_result.php';

$output = array(
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => array()
    );

if (verify_access_right(current_account(), F_TASK_STATISTIC))
{
    $from = $_REQUEST['from'];
    $to = $_REQUEST['to'];
    
    $model = new task_result();
    $data = $model->average_list($from, $to);
    
    if ($data != NULL) {
        $output['iTotalRecords'] = count($data);
        $output['iTotalDisplayRecords'] = count($data);
        $output['aaData'] = $data;
    }
}

echo json_encode($output);

require_once '../part/common_end_page.php';

/* End of file task_average_list_server.php */
/* Location: ./ajaxserver/task_average_list_server.php */