<?php 

require_once "../models/hangmucthicong.php";
require_once "../models/congviechangmucthicong.php";
require_once "../models/vattuhangmucthicong.php";
require_once "../models/danhsachdoithicong.php";
require_once "../models/danhsachnhacungcap.php";
require_once "../models/hangmucdoithicong.php";
$category_building = new category_building();
$work_category = new work_category();
$material_category = new material_category();
$list_group_construction = new list_group_construction();
$category_group_building = new category_group_building();
$list_provider = new list_provider();

$data = array();

if (isset($_POST['del']) && isset($_POST['id']) && isset($_POST['table'])) {
	echo "xóa";
	$del_id = $_POST['id'];
	$del_table = $_POST['table'];
        $del_cata = $_POST['cata'];

	switch ($del_table) {
		case 'work_category':
			$table = $work_category;
                        $table->delete($del_id);
			break;
		case 'material_category':
			$table = $material_category;
                        $table->delete($del_id);
			break;
		case 'category_group_building':
			$table = $category_group_building;
                        $table->deleteid($del_id, $del_cata);
			break;
		case 'list_provider':
			$table = $list_provider;
                        $table->delete($del_id);
			break;
	}
}

if (isset($_GET['id'])) {
	$_id =  $_GET['id'];
	$data['category_building'] = $category_building->get_by_id($_id);
	$data['work_category'] = $work_category->get_by_id_category($_id);
	$data['material_category'] = $material_category->get_by_id_category($_id);
	$data['list_group_construction'] = $list_group_construction->get_by_id_category($_id);
	$data['list_provider'] = $list_provider->get_by_id_category($_id);
}
