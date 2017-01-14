<?php 
	require_once "../models/support_process_excel.php";
	require_once "../models/chitietsanphammapping.php";
	if ( !isset($_FILES) ) die;
	$file = $_FILES['upload_scn'];
	$upload = uploadFile($file, '', '../'.EXCEL_FOLDER);
	$result = array('result' => 0, 'total'=> 0, 'success' => 0, 'message' => '');
	if ($upload['result']  == 1) { 
		$obj = loadDatafromExcel($upload['location'], 3);
		if ($obj['result'] == 1) {
			$data = $obj['data'];
			$success = 0;
			$total = count($data);
			$result['total'] = $total; 
			$chitietsanphammapping = new chitietsanphammapping();
			foreach ($data as $arr) {
                            if ( $chitietsanphammapping->is_exist(array('masotranh'=>$arr[0], 'machitiet'=>$arr[1])) ) {
                                $success += $chitietsanphammapping->update(array('soluong'=>$arr[2]), array('masotranh'=>$arr[0], 'machitiet'=>$arr[1]));
                            } else {
				$success += $chitietsanphammapping->insert($arr);
                            }
			}
			$result['success'] = $success; 
			$result['message'] = 'Thêm dữ liệu thành công: '.$success.'/'.$total;
			$result['result'] = 1;
		} else {
			$result['message'] = 'Load file thất bại từ: '.$upload['location'];
		}
	} else {
		$result['message'] = 'Upload file thất bại';
	}
	echo json_encode($result);
 ?>
