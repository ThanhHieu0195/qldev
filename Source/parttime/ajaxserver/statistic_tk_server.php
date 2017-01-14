<?php 
	require_once "../models/finance_token_detail.php";
	require_once "../models/motataikhoan.php";
	$result = array(
		"result"=>0,
		"message"=>""
	);

	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		if ($action == "load") {
			$from = $_POST['from'];
			$to = $_POST['to'];

			$model = new finance_token_detail();
			$data = $model->statistic_tk($from, $to);
			$detail_tk = new detail_tk();
			if (is_array($data)) {
				$result['result'] = 1;
				$result['statistic'] = $data;
				$result['detail_tk'] = $detail_tk->detail_tk();
				$result['message'] = "Tải dữ liệu thống kê tài khoản thành công";
			} else {
				$result['message'] = "Lỗi tải dữ liệu từ database 'finance_token_detail'";
			}	
		}
	}

	echo json_encode($result);
 ?>