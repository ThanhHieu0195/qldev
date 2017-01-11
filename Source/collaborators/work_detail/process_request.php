<?php 
	if ( isset($_POST['insert-approvecongviec']) ) {
		if ( !empty($_POST['date_complete']) ) {
			$date_complete  = $_POST['date_complete'];
			unset( $_POST['insert-approvecongviec'] );
			$idcongviec  = $_GET['token'];
			$manv = current_account();

			require_once "../models/approvecongviec.php";
			$approve_work = new approve_work();
			$cl_name = $approve_work->_NAME_COLUMN;
			$params = array( $cl_name['id'] => "", $cl_name['id_work'] => $idcongviec, $cl_name['id_employee'] => $manv, 
							$cl_name['status'] => STATUS_DEFAULT,  $cl_name['date_complete']=>$date_complete );

			if ( !$approve_work->is_exist( array("idcongviec" => $idcongviec, "manv" => $manv ) ) ) {
				if ( $approve_work->insert( $params ) ) {
					require_once "../models/mail_helper.php";
					$mail_helper = new mail_helper();
					$email = GMAIL_WORK_DETAIL;
					$name = $manv;
					$body = "Thông báo có nhân viên nhận việc chờ approve. Từ $manv";
					$data = array('to' => array('email' =>$email, 'name' =>$name), 'body' => $body);
					$mail_helper->Send($data, '[Approve]'); 

					require_once "../models/mail_helper.php";
					echo ' <script type="text/javascript">
					 	alert("Thêm thành công");
					 </script>';
				} else {
					echo ' <script type="text/javascript">
					 	alert("Thêm thất bại");
					 </script>';
				}
			}

		}
	}
 ?>
