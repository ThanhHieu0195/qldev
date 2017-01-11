<?php
 	if ( isset($_GET['action']) ) {
 		$action = $_GET['action'];
        $is_complete = false;
 		switch ($action) {
 			case 'add':
 				$makhoan = $_POST['makhoan'];
 				$mota= $_POST['mota'];
 				if ( empty($makhoan) || empty($mota) ) {
 					break;
 				}
                $is_complete = $model_makhoan->insert( array($makhoan, $mota) );
                break;
			case 'edit':
 				$makhoan = $_POST['makhoan'];
                $makhoancu = $_POST['makhoancu'];
                $mota = $_POST['mota'];

 				if ( empty($makhoan) || empty($mota) ) {
 					break;
 				}
                $condition = array('makhoan' => $makhoancu);
                $param = array('makhoan' => $makhoan, 'mota' => $mota);
                $is_complete = $model_makhoan->update($param, $condition);
 				break;
 			case 'del':
 				if ( !isset($_GET['makhoan']) ) die;
 				$makhoan= $_GET['makhoan'];
                $is_complete = $model_makhoan->delete( array('makhoan' => $makhoan) );
 				break;
 			default:
 				die;
 				break;
 		}
        if ( $is_complete ){
            echo ' <script type="text/javascript">
							 	alert("Thao tác thành công");
							 	window.location = "makhoan.php";
							 </script>';
        } else {
            echo ' <script type="text/javascript">
							 	alert("Thao tác thất bại");
							 	window.location = "makhoan.php";
							 </script>';
        }
 	}
 ?>
