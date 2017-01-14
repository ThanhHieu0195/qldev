<?php 
    require_once "../models/danhsachdoithicong.php";

    $list_group_construction = new list_group_construction();

    if (isset($_POST['del']) && isset($_POST['id'])) {
        $id = $_POST['id'];
        $list_group_construction->delete($id);
    }
    if ( isset($_POST['update']) && isset($_POST['id']) && isset($_POST['name_group']) && isset($_POST['address']) && isset($_POST['num_phone'])&&  isset($_POST['id_group']) ) {

        $id = $_POST['id'];
        $name_group = $_POST['name_group'];
        $address = $_POST['address'];

        $num_phone = $_POST['num_phone'];
        $id_group = $_POST['id_group'];

        $list_group_construction->update($id, $name_group, $address, $num_phone, $id_category, $id_group, $cost);
    }

    if ( isset($_POST['add']) && isset($_POST['name_group']) && isset($_POST['address']) && isset($_POST['num_phone']) && isset($_POST['id_group']) ) {
        
        $name_group = $_POST['name_group'];
        $address = $_POST['address'];

        $num_phone = $_POST['num_phone'];
        $id_group = $_POST['id_group'];

        $list_group_construction->insert( $name_group, $address, $num_phone, $id_group );
    }
 ?>

 