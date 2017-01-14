<?php
 	if ( isset($_GET['action']) ) {
 		$action = $_GET['action'];
        $is_complete = false;
 		switch ($action) {
 			case 'submit':
                $list_checkbox = $_POST['checkbox'];
                $is_complete = true;
                $data = array();
                $row = array();
                for ($i=0; $i<count($list_checkbox); $i++) {
               	 	$arr = explode(',' ,$list_checkbox[$i]);
                    $row['madonhang'] = $arr[0];
                    $row['masotranh'] = $arr[1];
                    $row['machitiet'] = $arr[2];
                    $data[] = $row;
                    $is_complete = $chitietphanbu->setDoing($arr[0], $arr[1], $arr[2]);
                }
//                excele
                $time = current_timestamp('Y-m-d');
				$filename = "../phpexcel/xls-data/".$time."_danhsachphuthucansanxuat.xls";
                $column_name = array('madonhang', 'masotranh', 'machitiet');
                $filename = $excel->export_auto_custom_data($filename, $data, $column_name);
                echo ' <script type="text/javascript">
							 	window.open("'.$filename.'");
							 </script>';
                break;
 		}
        if ( $is_complete ){
            echo ' <script type="text/javascript">
							 	window.location = "danhsachchitietphanbucansanxuat.php";
							 </script>';
        } else {
            echo ' <script type="text/javascript">
							 	window.location = "danhsachchitietphanbucansanxuat.php";
							 </script>';
        }
 	}
 ?>
