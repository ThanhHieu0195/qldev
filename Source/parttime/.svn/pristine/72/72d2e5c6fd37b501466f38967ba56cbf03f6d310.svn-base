<?php 
	require_once "../models/tranh.php";
	require_once "../models/chitietsanpham.php";
	require_once "../models/chitietsanphammapping.php";
	if ( !isset($_GET['token']) ) die;
	$_token = $_GET['token'];

 	if ( isset($_GET['action']) ) {
 		$action = $_GET['action'];
 		switch ($action) {
 			case 'add':
 				$masotranh = $_token;
 				$machitiet = $_POST['machitiet'];
 				$soluong = $_POST['soluong'];

 				if ( empty($machitiet) || empty($soluong) ) {
 					break;
 				}
 				$soluong = string_2_number($soluong);
 				$chitietsanphammapping = new chitietsanphammapping();
 				if ( $chitietsanphammapping->insert( array($masotranh, $machitiet, $soluong) ) ){
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
 				$masotranh = $_token;
 				$machitiet = $_POST['old_machitiet'];
 				$soluong = $_POST['soluong'];
 				$soluong = string_2_number($soluong);

 				if ( empty($machitiet) || empty($soluong) ) {
 					break;
 				}
 				$model = new chitietsanphammapping();
 				if ( $model->update( $params=array('soluong' => $soluong), $conditions=array( 'masotranh' => $masotranh,'machitiet' => $machitiet) ) ){
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
 				$model = new chitietsanphammapping();
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
