<?php 
     include_once '../models/donhang.php';
     include_once '../models/trahang.php';
     include_once '../models/chitiettrahang.php';

	 $action = $_POST['action'];
     $output = array();

     if (!empty($action)) {
	    if ($action == 'load') {
            $id = $_POST['id'];

            if (isset($_POST['trahang'])) {
                $th = new trahang();
                $arr = $th->tim_kiem($id);
                $output['result'] = true;
                $output['trahang'] = $arr;
            }


            if (isset($_POST['chitiettrahang'])) {
                $ctth = new chitiettrahang();
                $arr = $ctth->laythongtin($id);
                $output['result'] = true;
                $output['chitiettrahang'] = $arr;
            }
            echo json_encode($output);
        }
    }

 ?>
