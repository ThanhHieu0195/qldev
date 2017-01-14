<?php 
	require_once "../models/loaichitietsanpham.php";
	require_once "../models/chitietsanpham.php";
 	if ( isset($_GET['action']) ) {
 		$action = $_GET['action'];
 		switch ($action) {
 			case 'add':
 				$machitiet = $_POST['machitiet'];
 				$maloai = $_POST['maloai'];
 				$mota = $_POST['mota'];
 				$hinhanh = $_POST['hinhanh'];
 				$mausac = $_POST['mausac'];
 				$dai = $_POST['dai'];
 				$rong = $_POST['rong'];
 				$cao = $_POST['cao'];

 				if ( empty($machitiet) || empty($maloai) ) {
 					break;
 				}

 				$status_upload_attachment = 0;
				if ( isset($_FILES['hinhanh']) ){
					// upload
					$id = create_uid(FALSE);
					$attachment_target_file = WORKINGDIR . TARGET_ATTACHMENT_DIR ."chitietsanpham/". $id. basename($_FILES["hinhanh"]["name"]);
			        $attachment_url = '../' . TARGET_ATTACHMENT_DIR ."chitietsanpham/". $id. basename($_FILES["hinhanh"]["name"]);
					$status_upload_attachment = move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $attachment_target_file);
				}

				$hinhanh = "";
				if ($status_upload_attachment) {
					$hinhanh = $attachment_url;
				}
 				$mota = trim(preg_replace('/\s\s+/', ' ', $mota));
 				$model = new chitietsanpham();
 				if ( $model->insert( array($machitiet, $maloai, $mota, $hinhanh, $mausac, $dai, $rong, $cao) ) ){
 						echo ' <script type="text/javascript">
							 	alert("Thao tác thành công");
							 </script>';
 				} else {
 					echo ' <script type="text/javascript">
							 	alert("Thao tác thất bại");
							 </script>';
 				}
 				break;
			case 'edit':
 				$machitiet = $_POST['machitiet'];
 				$old_machitiet = $_POST['old_machitiet'];
 				$maloai = $_POST['maloai'];
 				$mota = $_POST['mota'];
 				$mota = trim(preg_replace('/\s\s+/', ' ', $mota));
 				$hinhanh = $_POST['hinhanh'];
 				$mausac = $_POST['mausac'];
 				$dai = $_POST['dai'];
 				$rong = $_POST['rong'];
 				$cao = $_POST['cao'];
 				$params = array('machitiet' => $machitiet, 'maloai' =>$maloai, 'mota' => $mota, 'mausac' => $mausac, 'dai' => $dai, 'rong'=> $rong, 'cao' => $cao);
 				$conditions = array('machitiet' => $old_machitiet);

 				if ( empty($machitiet) || empty($maloai) ) {
 					break;
 				}

 				$status_upload_attachment = 0;
				if ( isset($_FILES['hinhanh']) ){
					// upload
					$id = create_uid(FALSE);
					$attachment_target_file = WORKINGDIR . TARGET_ATTACHMENT_DIR ."chitietsanpham/". $id. basename($_FILES["hinhanh"]["name"]);
			        $attachment_url = '../' . TARGET_ATTACHMENT_DIR ."chitietsanpham/". $id. basename($_FILES["hinhanh"]["name"]);
					$status_upload_attachment = move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $attachment_target_file);
				}

				$hinhanh = "";
				if ($status_upload_attachment) {
					$hinhanh = $attachment_url;
					$params['hinhanh'] = $hinhanh;
				}

 				$model = new chitietsanpham();
 				if ( $model->update( $params, $conditions ) ){
 						echo ' <script type="text/javascript">
							 	alert("Thao tác thành công");
							 </script>';
 				} else {
 					echo ' <script type="text/javascript">
							 	alert("Thao tác thất bại");
							 </script>';
 				}
 				break; 	
 			case 'del':
 				$machitiet = $_POST['machitiet'];
 				$model = new chitietsanpham();
 				if ( $model->delete( $conditions=array('machitiet' => $machitiet) ) ){
 						echo ' <script type="text/javascript">
							 	alert("Thao tác thành công");
							 </script>';
 				} else {
 					echo ' <script type="text/javascript">
							 	alert("Thao tác thất bại");
							 </script>';
 				}
 				
 				break; 				
 			default:
 				die;
 				break;
 		}
 	}
 ?>
