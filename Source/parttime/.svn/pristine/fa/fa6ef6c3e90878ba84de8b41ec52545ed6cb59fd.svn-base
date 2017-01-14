
<?php 
/*================================================
=			 Section Init block                  =
=            @author: HT                         =
=            @datetime: 2016-12-07               =
=            @describe: Khởi tạo giá trị ban đầu =
=================================================*/
	$id = $_GET['token_id'];
	$id_building = $id;
    $list_id_material = array();

	if (isset($_POST['addcategory'])) {
		require_once "../models/chitiethangmuccongtrinh.php";
		$id_category = $_POST['add_id_category'];
		if ( !empty($id_building) && !empty($id_category) ) {
			print_r($id_category);
		    $detail_category_building = new detail_category_building();
		    $detail_category_building->insert($id_building, $id_category);
		}
	}
	
	require_once "../models/danhsachcongtrinh.php";
	require_once "../models/chitiethangmuccongtrinh.php";
        require_once "../models/nhomhangmuc.php";
        $nhangmuc = new group_category_building();
        $manhomhangmuc = $nhangmuc->get_all();
	$list_building = new list_building();
	$detail_category_building = new detail_category_building();
	$data_building = array();
	$data_detail_category_building = array();
	if ( isset($id) ) :
	    $data_building = $list_building->getdetailupdate($id);
	    $data_detail = $detail_category_building->getdetailupdate($id);
	endif;

	require_once '../models/hangmucthicong.php';
	$category_building = new category_building();
	$data_category_building = $category_building->get_all();
        $status = $data_building->trangthai;
/*=====  End of Section comment block  ======*/
 ?> 

