<?php
require_once '../part/common_start_page.php';
require_once '../models/rewards_penalty.php';

$output = array(
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => array()
    );

if (verify_access_right(current_account(), F_REWARDS_PENALTY_STATISTIC_LIST))
{
    $from = $_REQUEST['from'];
    $to = $_REQUEST['to'];
    
    $model = new rewards_penalty();
    $data = $model->statistic_list($from, $to);
    
    if ($data != NULL) {
        $output['iTotalRecords'] = count($data);
        $output['iTotalDisplayRecords'] = count($data);
        $output['aaData'] = $data;
    }
}

echo json_encode($output);

require_once '../part/common_end_page.php';

/* End of file rewards_statistic_list_server.php */
/* Location: ./ajaxserver/rewards_statistic_list_server.php */