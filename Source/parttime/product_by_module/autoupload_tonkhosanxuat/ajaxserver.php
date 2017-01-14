<?php 
	require_once "../models/support_process_excel.php";
	require_once "../models/tonkhosanxuat.php";
	require_once "../models/chitietsanpham.php";
	if ( !isset($_FILES) ) die;
	$file = $_FILES['upload_scn'];
	$upload = uploadFile($file, '', '../'.EXCEL_FOLDER);
	$result = array('result' => 0, 'total'=> 0, 'success' => 0, 'message' => '');
	if ($upload['result']  == 1) { 
		$obj = loadDatafromExcel($upload['location'], 10);
		if ($obj['result'] == 1) {
			$data = $obj['data'];
			$chitietsanpham = new chitietsanpham();
			$tonkhosanxuat = new tonkhosanxuat();
			$success = 0;
			$total = count($data);
			$result['total'] = $total; 
			foreach ($data as $arr) {
				$f = 1;
				if ( !$chitietsanpham->is_exist(array('machitiet' => $arr[0])) ){
					$params = $arr;
					unset($params[9]);
					unset($params[8]);
					$f = $chitietsanpham->insert($params);
				} 

				if ($f) {
					$params = array($arr[8], $arr[0], $arr[9]);
					if ( $tonkhosanxuat->is_exist(array('machitiet'=>$arr[0], 'makho'=>$arr[8])) ) {
						$success += $tonkhosanxuat->updateAdd($arr[9], $arr[0], $arr[8]);
					} else {
						$success += $tonkhosanxuat->insert($params);
					}
					$result['result'] = 1;
				} else {
					$result['message'] = 'Thêm dữ liệu mới vào bảng chitietsanpham thất bại';
				}
			}
			if ( $result['result'] ) {
				$result['success'] = $success; 
				$result['message'] = 'Thêm dữ liệu thành công: '.$success.'/'.$total;
			}
		} else {
			$result['message'] = 'Load file thất bại từ: '.$upload['location'];
		}
	} else {
		$result['message'] = 'Upload file thất bại';
	}
	echo json_encode($result);
 ?>
