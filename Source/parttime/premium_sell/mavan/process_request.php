<?php
 	if ( isset($_GET['action']) ) {
 		$action = $_GET['action'];
        $is_complete = false;
 		switch ($action) {
 			case 'add':
 				$mavan = $_POST['mavan'];
 				$mota= $_POST['mota'];
 				if ( empty($mavan) || empty($mota) ) {
 					break;
 				}
                $is_complete = $model_mavan->insert( array($mavan, $mota) );
                break;
			case 'edit':
 				$mavan = $_POST['mavan'];
                $mavancu = $_POST['mavancu'];
                $mota = $_POST['mota'];

 				if ( empty($mavan) || empty($mota) ) {
 					break;
 				}
                $condition = array('mavan' => $mavancu);
                $param = array('mavan' => $mavan, 'mota' => $mota);
                $is_complete = $model_mavan->update($param, $condition);
 				break;
 			case 'del':
 				if ( !isset($_GET['mavan']) ) die;
 				$mavan= $_GET['mavan'];
                $is_complete = $model_mavan->delete( array('mavan' => $mavan) );
 				break;
 			default:
 				die;
 				break;
 		}
        if ( $is_complete ){
            echo ' <script type="text/javascript">
							 	alert("Thao tác thành công");
							 	window.location = "mavan.php";
							 </script>';
        } else {
            echo ' <script type="text/javascript">
							 	alert("Thao tác thất bại");
							 	window.location = "mavan.php";
							 </script>';
        }
 	}
 ?>
