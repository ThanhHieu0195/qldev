<?php 
	
	if ($_REQUEST['method']) {
		$method = $_REQUEST['method'];
		switch ($method) {
			case 'update-date-start':
				$token = $_REQUEST['token'];
				$date_start = $_REQUEST['dateupdate'];
				require_once "../models/danhsachcongtrinh.php";
				$list_building = new list_building();
				$list_building->update(array("id"=>$token, "date_start" => $date_start));
				break;
			case 'update-date-expect-complete':
				$token = $_REQUEST['token'];
				$date_expect_complete = $_REQUEST['dateupdate'];
				require_once "../models/danhsachcongtrinh.php";
				$list_building = new list_building();
				$list_building->update(array("id"=>$token, "date_expect_end" => $date_expect_complete));
				break;
			case 'update-category':
				$params = $_POST['params'];
                                $conditions = $_POST['conditions'];
				require_once "../models/chitiethangmuccongtrinh.php";
				$detail_category_building = new detail_category_building();
				$detail_category_building->update($params, $conditions);
				break;	
                        case 'delete-category':
                                $conditions = $_POST['conditions'];
                                require_once "../models/chitiethangmuccongtrinh.php";
                                require_once "../models/chitietvattucongtrinh.php";
                                $detail_material_category = new detail_material_category();
                                $detail_category_building = new detail_category_building();
                                if ($detail_material_category->delete($conditions)) {
                                    if ($detail_category_building->delete($conditions)) {
                                        echo json_encode( array("result" => "1") );
                                    } else { echo json_encode( array("result" => "0") ); }
                                } else { echo json_encode( array("result" => "0") ); }
                                break;
			case 'update-detail-material-category':
				$params = $_POST['params'];
                                $conditions = $_POST['conditions'];
				require_once "../models/chitietvattucongtrinh.php";
				$detail_material_category = new detail_material_category();
				$result = $detail_material_category->update($params, $conditions);
				echo json_encode( array("result" => $result) );
				break;
			case 'insert-detail-material-category':
				$params = $_POST['params'];
				require_once "../models/chitietvattucongtrinh.php";
				$detail_material_category = new detail_material_category();
				$result = $detail_material_category->insert($params);	
				echo json_encode( array("result" => $result) );
				break;
			case 'del-detail-material-category':
				$params = $_POST['params'];
				require_once "../models/chitietvattucongtrinh.php";
				$detail_material_category = new detail_material_category();
				$result = $detail_material_category->delete($params);	
				echo json_encode( array("result" => $result) );
				break;	
			case 'take-id-detail-material-category':
				require_once "../models/chitietvattucongtrinh.php";
				$detail_material_category = new detail_material_category();
				$id = $detail_material_category->takeLastId();
				echo json_encode( array("result"=>$id) );
			break;
			case 'update-expect-money':
				require_once "../models/danhsachcongtrinh.php";
				$token = $_REQUEST['token'];
				$list_building = new list_building();
				$money_expect = $list_building->update_expect_money($token);
				$result = array('money_expect' => $money_expect);
				echo json_encode($result);
				break;	
                        case 'update-real-money':
                                require_once "../models/danhsachcongtrinh.php";
                                $token = $_REQUEST['token'];
                                $list_building = new list_building();
                                $money_real = $list_building->update_real_money($token);
                                $result = array('money_real' => $money_real);
                                echo json_encode($result);
                                break;
                        case 'update-approve-congtrinh':
                                require_once "../models/danhsachcongtrinh.php";
                                $building = $_REQUEST['id_building'];
                                error_log ("Add new " . json_encode($_REQUEST), 3, '/var/log/phpdebug.log');
                                $list_building = new list_building();
                                $result = $list_building->approvecongtrinh($building);
                                echo json_encode($result);
                                break;
			default:
				break;
		}
	}
 ?>
