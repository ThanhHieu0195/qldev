<?php
require_once '../part/common_start_page.php';
require_once '../models/coupon_used.php';

$output = array (
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => array () 
);

if (verify_access_right(current_account(), array(F_COUPON_FREELANCER_STATISTIC, F_COUPON_FREELANCER_STATISTIC_ALL))) {
    $uid = current_account ( UID );
    if (isset ( $_REQUEST ['uid'] ))
        $uid = $_REQUEST ['uid'];
    $from = $_REQUEST ['from'];
    $to = $_REQUEST ['to'];
    $status = $_REQUEST ['status'];
    
    $coupon_used = new coupon_used ();
    $data = $coupon_used->freelancer_statistic ( $uid, $from, $to, $status );
    
    $output ['iTotalRecords'] = count ( $data );
    $output ['iTotalDisplayRecords'] = count ( $data );
    $output ['aaData'] = $data;
}

echo json_encode ( $output );

require_once '../part/common_end_page.php';

/* End of file freelancer_statistic_server.php */
/* Location: ./ajaxserver/freelancer_statistic_server.php */