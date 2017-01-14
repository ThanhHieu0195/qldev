<?php
require_once '../part/common_start_page.php';

$response = array (
        'status' => 200,
        'makhach' => '?',
        'nhomkhach' => '?',
        'diachi' => '?' 
);
if (verify_access_right ( current_account (), F_VIEW_SALE ) && isset ( $_REQUEST ['makhach'] )) {
    $id = $_REQUEST ['makhach'];
    
    $sql = "SELECT k.makhach, n.tennhom, k.hoten, k.diachi, k.quan, k.tp
            FROM khach k INNER JOIN nhomkhach n ON k.manhom = n.manhom
            WHERE k.makhach = '%d'";
    $sql = sprintf ( $sql, $id );
    $db = new database ();
    $db->setQuery ( $sql );
    $row = mysql_fetch_array ( $db->query () );
    
    if (isset ( $row )) {
        $response = array (
                'status' => 200,
                'makhach' => $row ['makhach'],
                'nhomkhach' => $row ['tennhom'],
                'diachi' => sprintf ( '%s, %s, %s', $row ['diachi'], $row ['quan'], $row ['tp'] ) 
        );
    }
}
echo json_encode ( $response );

require_once '../part/common_end_page.php';
?>