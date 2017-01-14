<?php 
	if ( isset($_POST['action']) ) {
		$action = $_POST['action'];
		$_id = $_POST['id'];
		require_once "../models/approvecongviec.php";
		require_once "../models/congvieccongtac.php";
		$approve_work = new approve_work();
		$collaborative_work = new collaborative_work();

		$data = array("result" => 0);
		switch ($action) {
			case 'approve':
				require_once "../models/ketquacongtac.php";
				$_idcongviec = $_POST['idcongviec'];
				if ( $collaborative_work->approve( array('id'=>$_idcongviec) ) ) {
					if ( $approve_work->approve( array('id'=>$_id) )) {
						$result_work = new result_work();
						$result = $result_work->insert( $approve_work->getDateInsertResultList($_id) );
						$data['result'] = $result;
					}
				}
				break;
			case 'reject':
				$result = $approve_work->reject( array('id'=>$_id) );
				$data['result'] = $result;
				break;
			default:
				break;
		}
		echo json_encode( $data );
	}

 ?>