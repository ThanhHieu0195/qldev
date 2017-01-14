<?php 
	require_once '../part/common_start_page.php';
	require_once "../models/mail_helper.php";
	require_once "../models/nhanvien.php";
	require_once "../models/phanquyen.php";
	require_once "../models/danhsachlamthem.php";

	$output = array();
	$output['result'] = 0;
	$output['message'] = "Don't access";
	
	if (isset($_POST['addrequest'])) {
		$request_employee = $_POST['request_employee'];
		$request_day = $_POST['request_day'];
		$request_day_number = $_POST['request_day_number'];
		$request_days_note = $_POST['request_days_note'];

		$model = new list_request();
		$id = create_uid(FALSE);
		$employee_id = $request_employee;
		$manager_id = current_account();
		$date_create = "";
		$date_request = $request_day;
		$number_request = $request_day_number;
		$status = 0;
		$note = $request_days_note;
		
		$result = $model->insert($id, $employee_id, $manager_id, $date_create, $date_request, $number_request, $status, $note);
		if ($result) {
			$output['result'] = 1;
			$mail_helper = new mail_helper();
			$info = new nhanvien();
			$employee = $info->thong_tin_nhan_vien($employee_id);
			$manager = $info->thong_tin_nhan_vien($manager_id);

			$email = $employee['email'];
			$name = $employee['hoten'];

			$body = "Yêu cầu làm thêm từ {$manager['hoten']}.<br /> 
					Mã nhân viên: {$employee['manv']} <br /> 
					Số ngày làm thêm: {$number_request} <br /> 
					Lí do: {$note} <br /> 
					";
			$data = array('to' => array('email' =>$email, 'name' =>$name), 'body' => $body);
			$mail_helper->Send($data, '[Bạn nhận được yêu cầu làm thêm]');

			$output['message'] = "Thao tác thành công";
		} else {
			$output['message'] = "Thao tác thất bại";
		}
	}
	// 
	if (isset($_POST['processrequest'])) {
		$action = $_POST['action'];
		$id = $_POST['id'];
		if ($action == "approve") {
			// database danhsachnghi
			$model_list_request = new list_request();
			if ($model_list_request->approve($id)) {
					$info_request = $model_list_request->getById($id);
					
					$mail_helper = new mail_helper();
					$info = new nhanvien();
					$employee = $info->thong_tin_nhan_vien($info_request['manv']);
					$manager = $info->thong_tin_nhan_vien($info_request['maquanly']);

					$email = $manager['email'];
					$name = $manager['hoten'];

					$body = "Phan hoi tu{$employee['hoten']}.<br /> 
                                                 Da dong y lam them tu ngay:{$info_request['ngaylamthem']} <br>
                                                 So ngay lam them: {$info_request['songay']} <br>
                                                 Ghi chu: {$info_request['ghichu']} <br>
                                                 ";

					$data = array('to' => array('email' =>$email, 'name' =>$name), 'body' => $body);
					$mail_helper->Send($data, '[Xác nhận việc làm thêm]');
                                        //error_log ("Add new " . $mail_helper->ErrorInfo , 3, '/var/log/phpdebug.log');
					// 
					$output['result'] = 1;
					$output['id'] = $id;
					$output['message'] = "Mã đơn {$id} đã approve thành công";

			} else {
				$output['result'] = 0;
				$output['message'] = "Mã đơn {$id} đã approve thất bại";
			}
		}

		if ($action == "reject") {
			$model_list_request = new list_request();
			if ($model_list_request->reject($id)) {
				// lấy thông tin nhân viên từ database danhsachnghi
				$info_request = $model_list_request->getById($id);

				$mail_helper = new mail_helper();
				$info = new nhanvien();
				$employee = $info->thong_tin_nhan_vien($info_request['manv']);
				$manager = $info->thong_tin_nhan_vien($info_request['maquanli']);

				$email = $employee['email'];
				$name = $employee['hoten'];

				$body = "Phản hồi từ {$manager['hoten']}.<br /> 
						Đơn xin làm thêm vào ngày  {$info_request['ngaynghi']} đã bị từ chôi!
						";

				$data = array('to' => array('email' =>$email, 'name' =>$name), 'body' => $body);
				$mail_helper->Send($data, '[Từ chôi việc làm thêm]');

				$output['result'] = -1;
				$output['id'] = $id;
				$output['message'] = "Mã đơn {$id} đã reject thành công";
			} else {
				$output['result'] = 0;
				$output['message'] = "Mã đơn {$id} đã reject thất bại";
			}
		}
	}

	if (isset($_POST['statistic'])) {
	    $action = $_POST['action'];
	    $list_checked = $_POST['listcheck'];

        $model_list_request = new list_request();
		$manager_id = current_account();

		$listData = $model_list_request->statistic_employee_id($manager_id);
		
		$pq = new phanquyen();

	    if ($action == "export") {
			require_once "../models/export-excel.php";
			$file_name = "statistic";
			$header = array("Mã nhân viên", "Số ngày làm thêm");

			$keys = array("employee_id", "number_request");
			$arr = array();

			for ($i=0; $i < count($list_checked); $i++) { 
				$check = $list_checked[$i];
				if (empty($listData[$check])) {
					$arr[] = array("employee_id" => $check, "number_request"=> 0);
				} else {
					$obj = $listData[$check];
					$arr[] = array("employee_id" => $check, "number_request"=> $obj['DAY_REQUEST']);
				}
			}
			export_excel($file_name, $header, $keys, $arr);
			$output['result'] = 1;
	    }	
	}
	echo json_encode($output);
 ?>
