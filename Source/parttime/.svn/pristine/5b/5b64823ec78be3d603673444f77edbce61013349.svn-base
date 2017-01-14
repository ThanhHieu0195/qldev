<?php 
	$status_upload_attachment = 0;
	if ( isset($_FILES['attachment']) ){
		// upload
		$id = create_uid(FALSE);
		$attachment_target_file = WORKINGDIR . TARGET_ATTACHMENT_DIR . $id. basename($_FILES["attachment"]["name"]);
                $attachment_url = '../' . TARGET_ATTACHMENT_DIR . $id. basename($_FILES["attachment"]["name"]);
		$status_upload_attachment = move_uploaded_file($_FILES["attachment"]["tmp_name"], $attachment_target_file);
	}

	if ( isset($_POST['add-data']) ) {
		// init
		$description = isset( $_POST['description'] ) ? $_POST['description'] :'';
		$date_complete = isset( $_POST['date_complete'] ) ? $_POST['date_complete']: '';
		$cost = 0;
		if ( isset( $_POST['cost'] ) )  {
			$cost = $_POST['cost'];
			$cost = string_2_number($cost);
		}
		$attachment = "";
		if ($status_upload_attachment) {
			$attachment = $attachment_url;
		}
		// process
		require_once "../models/congvieccongtac.php";
 		$collaborative_work = new collaborative_work();
		$cost = string_2_number($cost);

		$params = array('id'=>'', 'description' => $description,'date_complete' => $date_complete, 'cost'=>$cost,
										'attachment' => $attachment, 'status'=> STATUS_DEFAULT);
 		if ( $collaborative_work->insert($params) ) {
 			echo ' <script type="text/javascript">
				 	alert("Thao tác thành công");
				 </script>';
 		} else {
 			echo ' <script type="text/javascript">
				 	alert("Thao tác thất bại");
				 </script>';
 		}
	}
	// process
 ?>
