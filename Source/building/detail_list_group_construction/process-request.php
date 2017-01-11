<?php 
    require_once "../models/danhsachdoithicong.php";
    require_once "../models/hangmucdoithicong.php";
    require_once "../models/hangmucthicong.php";
    require_once "../models/nhomhangmuc.php";
    $_id          = $_GET['token'];
    $_list_group_construction = new list_group_construction();
    $_category_group_building = new category_group_building();
    $_category_building       = new category_building();
    $nhangmuc = new group_category_building();
    $manhom = $nhangmuc->get_all();

    $_list_group_category = $_category_building->get_all_group_category();
    $_list_category = $_category_building->get_all_category();
    if (isset($_POST['del']) && isset($_POST['id'])) {
        $id_category = $_POST['id'];
        $conditions = array( 'madoithicong' => $_id, 'idhangmuc' => $id_category );
        $_category_group_building->delete($conditions);
    }
    if ( isset($_POST['update']) && isset($_POST['id']) && isset($_POST['id_category']) && isset($_POST['cost']) ) {
        echo "string";
        $id = $_POST['id'];
        $id_category = $_POST['id_category'];
        $cost = string_2_number( $_POST['cost'] );

        $params = array( 'idhangmuc' => $id_category, 'giatien' => $cost );
        $conditions = array( 'madoithicong' => $_id, 'idhangmuc' => $id);
        $_category_group_building->update($params, $conditions);
    }

    if ( isset($_POST['add']) && isset($_POST['id_category']) && isset($_POST['cost']) ) {
        $id_category = $_POST['id_category'];
        $cost = string_2_number($_POST['cost']);
        $params = array('madoithicong' => $_id, 'idhangmuc' => $id_category, 'giatien' => $cost );
        $_category_group_building->insert( $params );
    }
 ?>

 
