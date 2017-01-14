<?php 

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
	echo json_encode($result);
 ?>