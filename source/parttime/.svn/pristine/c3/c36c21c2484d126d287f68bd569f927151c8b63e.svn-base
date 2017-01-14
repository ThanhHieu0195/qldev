<?php 
	if ( isset($_POST['update-result-work']) ) {
		$_id = $_GET['token'];
		$account = current_account();
		$conditions = array( 'id' => $_id );
		$params = array();
		
		$status_upload_attachment = 0;
		if ( isset($_FILES['attachment']) ){
			$id = create_uid(FALSE);
			$attachment_target_file = WORKINGDIR . TARGET_ATTACHMENT_DIR . $id. basename($_FILES["attachment"]["name"]);
                        $attachment_url = TARGET_ATTACHMENT_DIR . $id. basename($_FILES["attachment"]["name"]);
			$status_upload_attachment = move_uploaded_file($_FILES["attachment"]["tmp_name"], $attachment_target_file);
		}

		if ( isset($_POST['status']) ) {
			$params['trangthai'] = $_POST['status'];
		}

		if ( $status_upload_attachment ) {
			$old_attachment = $_POST['old_attachment'];
			$params['attachment'] = $old_attachment.' <-> '.$attachment_url;
		}

		if ( isset($_POST['comment']) ) {
			$params['nhanxet'] = $_POST['comment'];
		}

		if ( isset($_POST['note']) ) {
			$params['ghichu'] = $_POST['note'];
		}

		if ($params['trangthai'] == COMPLETED_WORK) {
			require '../models/danhsachthuchi.php';
			$_listExpenses = new listExpenses();
			$money = isset($_POST['cost'])?$_POST['cost']:0;
			$note = "Chi tiền cho cộng tác viên: ".$account." - ".$_id;
			if ( !$_listExpenses->insert('', $account, '',TYPE_PAY,  $money, $note, '', '') ) {
				echo ' <script type="text/javascript">
				 	alert("Tạo phiếu chi thất bại");
				 </script>';
			}
		}

		require_once "../models/ketquacongtac.php";
		$_result_work = new result_work();
		if ( $_result_work->update($params, $conditions) ) {
			echo ' <script type="text/javascript">
				 	alert("Thao tác thành công");
				 </script>';
 		} else {
 			echo ' <script type="text/javascript">
				 	alert("Thao tác thất bại");
				 </script>';
 		}
	}
 ?>
