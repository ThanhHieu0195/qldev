<?php
 	if ( isset($_GET['action']) ) {
 		$action = $_GET['action'];
        $is_complete = false;
 		switch ($action) {
 			case 'add':
 				$madanchi = $_POST['madanchi'];
 				$mota= $_POST['mota'];
 				if ( empty($madanchi) || empty($mota) ) {
 					break;
 				}
                $is_complete = $danchi->insert( array($madanchi, $mota) );
                break;
			case 'edit':
 				$madanchi = $_POST['madanchi'];
                $madanchicu = $_POST['madanchicu'];
                $mota = $_POST['mota'];

 				if ( empty($madanchi) || empty($mota) ) {
 					break;
 				}
                $condition = array('madanchi' => $madanchicu);
                $param = array('madanchi' => $madanchi, 'mota' => $mota);
                $is_complete = $danchi->update($param, $condition);
 				break;
 			case 'del':
 				if ( !isset($_GET['madanchi']) ) die;
 				$madanchi= $_GET['madanchi'];
                $is_complete = $danchi->delete( array('madanchi' => $madanchi) );
 				break;
 			default:
 				die;
 				break;
 		}
        if ( $is_complete ){
            echo ' <script type="text/javascript">
							 	alert("Thao tác thành công");
							 	window.location = "danchi.php";
							 </script>';
        } else {
            echo ' <script type="text/javascript">
							 	alert("Thao tác thất bại");
							 	window.location = "danchi.php";
							 </script>';
        }
 	}
 ?>
