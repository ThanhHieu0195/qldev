<?php 
	require_once '../part/common_start_page.php';
	require_once "../models/danhsachnghi.php";
	require_once "../models/danhsachsongaynghi.php";
	require_once "../models/mail_helper.php";
	require_once "../models/nhanvien.php";
	require_once "../models/phanquyen.php";

	$output = array();
	$output['result'] = 0;
	$output['message'] = "Don't access";
	
	if (isset($_GET['max_leave'])) {
		$employee_id = $_GET['employee_id'];
		$model = new leave_number();
		$row = $model->getInfoByEmployeeId($employee_id);
		if ($row) {
			$output['result'] = 1;
			$output['max_leave'] = $row['songaynghi'];
		}
	}

	if (isset($_POST['addleave'])) {
		$leave_manager = $_POST['leave_manager'];
		$leave_day = $_POST['leave_day'];
		$leave_day_number = $_POST['leave_day_number'];
		$leave_days_note = $_POST['leave_days_note'];

		$model = new list_leave();
		$id = create_uid(FALSE);
		$employee_id = current_account();
		$manager_id = $leave_manager;
		$date_create = "";
		$date_leave = $leave_day;
		$number_leave = $leave_day_number;
		$status = 0;
		$note = $leave_days_note;

		$model_leave_number = new leave_number();
		$leave_number = $model_leave_number->getInfoByEmployeeId($employee_id);

		$result = $model->insert($id, $employee_id, $manager_id, $date_create, $date_leave, $number_leave, $status, $note);
		if ($result) {
			$output['result'] = 1;
			$mail_helper = new mail_helper();
			$info = new nhanvien();
			$employee = $info->thong_tin_nhan_vien($employee_id);
			$manager = $info->thong_tin_nhan_vien($manager_id);

			$email = $manager['email'];
			$name = $manager['hoten'];

			$body = "Yêu cầu xin nghỉ việc từ {$employee['hoten']}.<br /> 
					Mã nhân viên: {$employee['manv']} <br /> 
					Số ngày nghỉ: {$number_leave} <br /> 
					Lí do: {$note} <br /> 
					";

			$data = array('to' => array('email' =>$email, 'name' =>$name), 'toarray' =>array(), 'body' => $body);
                        if (! $mail_helper->Send_new_customer ( $data, "[Xin nghỉ việc]" )) {
                            debug ( $mail_helper->ErrorInfo );
                            //error_log ("Add new " . $mail_helper->ErrorInfo , 3, '/var/log/phpdebug.log');
                        }

			$output['message'] = "Thao tác thành công";
		} else {
			$output['message'] = "Thao tác thất bại";
		}
	}
	// 
	if (isset($_POST['processleave'])) {
		$action = $_POST['action'];
		$id = $_POST['id'];
		if ($action == "approve") {
			// database danhsachnghi
			$model_list_leave = new list_leave();
			if ($model_list_leave->approve($id)) {
				// database danhsachsongaynghi
				$model_leave_number = new leave_number();

				// lấy thông tin nhân viên từ database danhsachnghi
				$info_leave = $model_list_leave->getById($id);
				// số ngày nghỉ của nhân viên
				$number_leaver = $info_leave['songaynghi'];

				// lấy thông tinh ngày nghỉ còn lại của nhân viên
				$info_leave = $model_leave_number->getInfoByEmployeeId($info_leave['manv']);
				$number_leaver_max = $info_leave['songaynghi'];

				// tính ngày nghỉ còn lại
				$update = floatval($number_leaver_max) - floatval($number_leaver);
				// cập nhật lại số ngày nghỉ còn lại trong database danhsachsongaynghi
				if ($model_leave_number->updateNumberLeave($info_leave['manv'], $update)) {
					// 
					$mail_helper = new mail_helper();
					$info = new nhanvien();
					$employee = $info->thong_tin_nhan_vien($info_leave['manv']);
					$manager = $info->thong_tin_nhan_vien($info_leave['maquanli']);

					$email = $employee['email'];
					$name = $employee['hoten'];

					$body = "Phản hồi từ {$manager['hoten']}.<br /> 
							Đơn nghỉ phép vào ngày {$info_leave['ngaynghi']} đã được duyệt!
							";

					$data = array('to' => array('email' =>$email, 'name' =>$name), 'body' => $body);
					$mail_helper->Send($data, '[Xác nhận đơn xin nghỉ]');
					// 
					$output['result'] = 1;
					$output['id'] = $id;
					$output['message'] = "Mã đơn {$id} đã approve thành công";
				}

			} else {
				$output['result'] = 0;
				$output['message'] = "Mã đơn {$id} đã approve thất bại";
			}
		}

		if ($action == "reject") {
			$model_list_leave = new list_leave();
			if ($model_list_leave->reject($id)) {
				// lấy thông tin nhân viên từ database danhsachnghi
				$info_leave = $model_list_leave->getById($id);

				$mail_helper = new mail_helper();
				$info = new nhanvien();
				$employee = $info->thong_tin_nhan_vien($info_leave['manv']);
				$manager = $info->thong_tin_nhan_vien($info_leave['maquanli']);

				$email = $employee['email'];
				$name = $employee['hoten'];

				$body = "Phản hồi từ {$manager['hoten']}.<br /> 
						Đơn nghỉ phép vào ngày {$info_leave['ngaynghi']} đã bị từ chôi!
						";

				$data = array('to' => array('email' =>$email, 'name' =>$name), 'body' => $body);
				$mail_helper->Send($data, '[Từ chôi đơn xin nghỉ]');

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

        $model_list_leave = new list_leave();
		$manager_id = current_account();

		$listData = $model_list_leave->statistic_employee_id($manager_id);
		// print_r($listData);
		
		$pq = new phanquyen();

		$num_leave = new leave_number();
		// danh sách tất cả nhân viên được quản lý
		$list_all_employee = $pq->loadEmployee($manager_id);

		// danh sách nghỉ nghỉ được phép của tất cả các nhân viên
		$list_all_data = $num_leave->getByArrayEmployee($list_all_employee);
		// print_r($list_all_employee);
		// print_r($list_all_data);

	    if ($action == "Export") {
			require_once "../models/export-excel.php";
			$file_name = "statistic";
			$header = array("Mã nhân viên", "Số ngày nghỉ", "Ngày còn lại");

			$keys = array("employee_id", "number_leaver", "number_max");
			$arr = array();

			$list_all_data_employee = array();
			for ($i=0; $i < count($list_all_data); $i++) { 
				# code...
				$obj = $list_all_data[$i];
				$list_all_data_employee[$obj['EMPLOYEE_ID']] = array();
				$list_all_data_employee[$obj['EMPLOYEE_ID']] = $obj;
			}

			for ($i=0; $i < count($list_checked); $i++) { 
				

				if (empty($listData[$list_checked[$i]])) {
					$row = $list_all_data_employee[$list_checked[$i]];
					$row['DAY_LEAVE'] = 0;
				}  else {
					$row = $listData[$list_checked[$i]];
				}

				if ($row['EMPLOYEE_ID'] == $list_checked[$i]) {
					$obj = array("employee_id"=>$row['EMPLOYEE_ID'], "number_leaver"=>$row['DAY_LEAVE'], "number_max"=>$row['DAY_LEAVE_MAX']);
					$arr[] = $obj;
				}
			}
			export_excel($file_name, $header, $keys, $arr);
			$output['result'] = 1;
	    }	

	    if ($action == "Reset") {
	    	$max_num_leave = $_POST['max_num_leave'];
	    	$count = 0;
	    	for ($i=0; $i < count($list_checked); $i++) { 
	    		$model_list_leave->reset($list_checked[$i], $max_num_leave);
	    	}

	    	$output['result'] = 2;
	    }
	}
	echo json_encode($output);
 ?>
