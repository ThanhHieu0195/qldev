<?php 
	$output = array();
	if (isset($_REQUEST['statistics_sum'])) {

		$from = $_REQUEST['tungay'];
		$to = $_REQUEST['denngay'];

		require_once "../models/deliver.php";

		$model = new deliver();
		$dataStatistics = $model->statistics_sum($from, $to);
		
		if (is_array($dataStatistics) && count($dataStatistics) > 0) {
			$output['action'] = "statistics_sum";
			$output['dataStatistics'] = $dataStatistics;
			$output['result'] = "success";
		} else {
			$output['result'] = "error";
			$output['message'] = "Dữ liệu rỗng";
		}
	}
	else if (isset($_REQUEST['statistics']) || isset($_REQUEST['employee_id'])) {
		$from = $_REQUEST['tungay'];
		$to = $_REQUEST['denngay'];
                if (isset($_REQUEST['employee_id'])) {
                    $employee_id = $_REQUEST['employee_id'];
                } else {
                    $employee_id = '';
                }
                //error_log ("Add new" . $employee_id, 3, '/var/log/phpdebug.log');

		require_once "../models/deliver.php";

		$model = new deliver();
                $dataStatistics = $model->statistics_new($from, $to, $employee_id);
		
		if (is_array($dataStatistics) && count($dataStatistics) > 0) {
			$output['action'] = "statistics";
			$output['dataStatistics'] = $dataStatistics;
			$output['result'] = "success";
		} else {
			$output['result'] = "error";
			$output['message'] = "Dữ liệu rỗng";
		}

	}  
	else {
		$output['result'] = "error";
		$output['message'] = "Phương thức không phù hợp";
	}
 ?>
