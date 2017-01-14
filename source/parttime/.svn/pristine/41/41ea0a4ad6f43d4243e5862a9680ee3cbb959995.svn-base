<?php 
	require_once "../models/loaichitietsanpham.php";
 	if ( isset($_GET['action']) ) {
 		$action = $_GET['action'];
 		switch ($action) {
 			case 'add':
 				$maloai = $_POST['maloai'];
 				$mota = $_POST['mota'];

 				if ( empty($maloai) || empty($mota) ) {
 					break;
 				}

 				$mota = trim(preg_replace('/\s\s+/', ' ', $mota));
 				$model = new loaichitietsanpham();
 				if ( $model->insert( array($maloai, $mota) ) ){
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
 				$old_maloai = $_POST['old_maloai'];
 				$new_maloai = $_POST['maloai'];
 				$mota = $_POST['mota'];

 				if ( empty($new_maloai) || empty($mota) ) {
 					break;
 				}
 				$mota = trim(preg_replace('/\s\s+/', ' ', $mota));
 				$model = new loaichitietsanpham();
 				if ( $model->update( $params=array('maloai' => $new_maloai, 'mota' => $mota), $conditions=array('maloai' => $old_maloai) ) ){
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
 				$maloai = $_POST['maloai'];
 				$model = new loaichitietsanpham();
 				if ( $model->delete( $conditions=array('maloai' => $maloai) ) ){
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
