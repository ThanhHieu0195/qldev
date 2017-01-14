
<?php 
	require_once '../part/common_start_page.php';
	require_once "../models/phanquyen.php";

	if (verify_access_right ( current_account (), G_EMPLOYEES, KEY_GROUP )) {
		if (isset($_POST['action'])) {
			$action = $_POST['action'];
			$output = array();

			if ($action  == "load") {
				$model = new phanquyen();
				$arr = $model->load();
				if (is_array($arr) && count($arr)) {
					$output['result'] = "success";
					$output['data'] = $arr;
					$output['message'] = "Load dữ liệu thành công";
				} else {
					$output['result'] = "error";
				}
			}

			if ($action == "add") {
				$model = new phanquyen();
				$obj = $_POST['obj'];
				$return = $model->add($obj);
				if ($return) {
					$output['result'] = "success";
					$output['message'] = "Thêm dữ liệu thành công";
				} else {
					$output['result'] = "error";
				}
			}

			if ($action == "move") {
				$model = new phanquyen();
				$obj = $_POST['obj'];
				$return = $model->move($obj);
				if ($return) {
					$output['result'] = "success";
					$output['message'] = "cập nhật thành công";
				} else {
					$output['result'] = "error";
				}
			}

			if ($action == "edit") {
				$model = new phanquyen();
				$obj = $_POST['obj'];
				$return = $model->edit($obj);
				if ($return) {
					$output['result'] = "success";
					$output['message'] = "cập nhật thành công";
				} else {
					$output['result'] = "error";
				}
			}

			if ($action == "loadkeyvalid") {
				$model = new phanquyen();
				$arr = $model->loadKeyValid();
				if (is_array($arr) && count($arr)) {
					$output['result'] = "success";
					$output['data'] = $arr;
					$output['message'] = "Load key thành công";
				} else {
					$output['result'] = "error";
				}
			}

			if ($action == "loadlistdetail") {
				$model = new phanquyen();
				$arr = $model->getListDetail();
				if (is_array($arr) && count($arr)) {
					$output['result'] = "success";
					$output['data'] = $arr;
					$output['message'] = "Load mô tả thành công";
				} else {
					$output['result'] = "error";
				}
			}

			if ($action == "loadinfo") {
				$model = new phanquyen();
				$arr = $model->loadInfo();
				if (is_array($arr) && count($arr)) {
					$output['result'] = "success";
					$output['data'] = $arr;
					$output['message'] = "Load thông tin nhân viên thành công";
				} else {
					$output['result'] = "error";
				}
			}

			if ($action == "delnode") {
				$obj = $_POST['obj'];
				$model = new phanquyen();
				$return = $model->delNode($obj);
				if ($return) {
					$output['result'] = "success";
					$output['message'] = "Xóa node thành công";
				} else {
					$output['result'] = "error";
				}
			}
			echo json_encode($output);
		}
	}
 ?>

