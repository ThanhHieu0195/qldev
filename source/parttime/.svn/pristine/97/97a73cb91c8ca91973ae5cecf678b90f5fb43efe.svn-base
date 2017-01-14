<?php
require_once '../part/common_start_page.php';
require_once '../models/orders_question_result.php';

$result = array (
        'result' => "success", // Error status
        'message' => 'Thực hiện thao tác thanh cong.', // Message
        'items' => array ()
);

if (isset ( $_POST ['nam'] )) {
    $nam = $_POST ['nam'];
}
$dashboard_model = new orders_question_result();
$dash = $dashboard_model->dashboard_cskh($nam);
$result['items'] = $dash;
echo json_encode ( $result );
require_once '../part/common_end_page.php';
?>
