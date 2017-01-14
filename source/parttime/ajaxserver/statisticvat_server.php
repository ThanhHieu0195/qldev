<?php 

	require_once '../part/common_start_page.php';
	$output = array();
	$output['message'] = array();
	if (verify_access_right ( current_account (), G_FINANCE, KEY_GROUP )) {
		if (isset($_REQUEST['action'])) {
			$do = $_REQUEST['do'];
			if ($do == "update") {
				require_once "../models/hoadondo.php";
				$model = new RedBill();
				$mahoadon = $_REQUEST['mahoadon'];
				$result = $model->update_status_by_order($mahoadon);
				if ($result) {
					$output['result'] = "success";
					$output['message'][] = "Cập nhật thành công";
				} else {
					$output['result'] = "error";
					$output['message'][] = "Xử lý trên database thất bại";
				}
			}
		} else {
			$output['result'] = "error";
			$output['message'][] = "Truy cập trái phép";
		}
	} else {
		$output['result'] = "error";
		$output['message'][] = "Truy cập trái phép";
	}

	echo json_encode($output);

 ?>