<?php
require_once '../config/constants.php';

if ( !isset($_REQUEST['action']) ) die;
	$action = $_REQUEST['action'];
	$result = array( 'result'=>0, 'data' => array() );

	if ($action == 'detail_list_group_construction') {
		$do = $_GET['do'];
		switch ($do) {
			case 'getlistcategory':
				require_once "../models/hangmucthicong.php";
				$category_building = new category_building();
				$group_category = $_GET['group_category'];
				$data = $category_building->get_category_by_group($group_category);
				if ( count($data) > 0 ) {
					$result['result'] = 1;
					$result['data'] = $data;
				} 
				break;
			
			default:
				# code...
				break;
		}
	}

    if ( $action == 'comfrim-duyetyeucau') {
        $loai = $_POST['loai'];
        $id = $_POST['id'];
        $idcongtrinh = $_POST['idcongtrinh'];
        $res = 0;
        if ($loai == 0) {
            require_once "../models/yeucauthaydoihangmuc.php";
            $yeucauthaydoihangmuc = new yeucauthaydoihangmuc();
            $res = $yeucauthaydoihangmuc->xacnhan($id);
            if ($res) {
                $result['result'] = 1;
            }
        }

        if ($loai == 1) {
            require_once "../models/yeucauthaydoivattu.php";
            $yeucauthaydoivattu= new yeucauthaydoivattu();
            $res = $yeucauthaydoivattu->xacnhan($id);
            if ($res) {
                $result['result'] = 1;
            }
        }
        if ($res) {
            require_once "../models/danhsachcongtrinh.php";
            $model = new list_building();
            $model->update_over_money($idcongtrinh);
        }
    }

if ( $action == 'reject-duyetyeucau') {
    $loai = $_POST['loai'];
    $id = $_POST['id'];
    $res = 0;
    if ($loai == 0) {
        require_once "../models/yeucauthaydoihangmuc.php";
        $yeucauthaydoihangmuc = new yeucauthaydoihangmuc();
        $res = $yeucauthaydoihangmuc->huy($id);
        if ($res) {
            $result['result'] = 1;
        }
    }

    if ($loai == 1) {
        require_once "../models/yeucauthaydoivattu.php";
        $yeucauthaydoivattu= new yeucauthaydoivattu();
        $res = $yeucauthaydoivattu->huy($id);
        if ($res) {
            $result['result'] = 1;
        }
    }
}
	echo json_encode($result);
 ?>