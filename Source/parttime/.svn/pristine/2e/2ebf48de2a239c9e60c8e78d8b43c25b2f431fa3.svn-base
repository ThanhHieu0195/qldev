<?php 

	$output = array();
	if (isset($_REQUEST['action'])) {
		require_once "../models/danhsachthuchi.php";
		$model = new listExpenses();
		$do = $_REQUEST['do'];
		if ($do == "get") {
			$madonhang = $_REQUEST['madonhang'];
			$result = $model->getInfoByOrder($madonhang);
			if (is_array($result)) {
				$output['data'] = $result;
				$output['result'] = 'success';
			} else {
				$output['result'] = 'error';
			}
		}
	} else {
		$output['result'] = "error";
		$output['message'] = "Truy cập trái phép";
	}
	echo json_encode($output);
 ?>