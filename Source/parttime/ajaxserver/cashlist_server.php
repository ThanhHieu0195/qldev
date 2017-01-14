<?php 
require_once '../part/common_start_page.php';

	do_authenticate(G_ORDERS, F_ORDERS_CASH_LIST, TRUE);
	$output = array();
	if (isset($_GET['action']) || isset($_GET['do'])) {
		$action = $_GET['action'];
		$do = $_GET['do'];
		$output['message'] = array();

		if ($action == 'get') {
			if ($do == 'getValueRedBill') {
				require_once "../models/donhang.php";
				$order = new donhang();
				$order_id = $_GET['order_id'];

				$output['order_id'] = $order_id;
				$result = $order->lay_thong_tin_don_hang($order_id);

				if (!empty($result)) {
					$output['result'] = "success";
					$output['data'] = $result;
					$output['message'][] = "Lấy dữ liệu giá trị hóa đơn đỏ thành công!";
				} else {
					$output['result'] = "error";
				}
			}
		}
	} else {
		$output['result'] = "error"; 
	}
	echo json_encode($output);
require_once '../part/common_end_page.php';
 ?>