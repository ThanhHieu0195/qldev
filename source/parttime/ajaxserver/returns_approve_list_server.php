<?php
/*
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * Easy set variables
 */
require_once '../part/common_start_page.php';
require_once '../models/trahang.php';

/*
 * Array of database columns which should be read and sent back to DataTables. Use a space where you want to insert a non-database field (for example a counter or static image)
 */
$aColumns = array (
        'th.id',
        'th.ngaylap',
        'th.madon',
        'th.tientralai',
        'th.tiendoanhso',
        'th.manv', 
        'th.trangthai',
        'th.donhangmoi'
);
/* Short name list of columns */
$name_list = array (
        'id',
        'ngaylap',
        'madon',
        'tientralai',
        'tiendoanhso',
        'manv',
        'trangthai',
        'donhangmoi'
);

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = 'th.id';

/* DB table to use */
$sTable = 'trahang th';
$sGroupBy = '';

/* Database connection information */
$gaSql ['user'] = database::$USERNAME;
$gaSql ['password'] = database::$PASSWORD;
$gaSql ['db'] = database::$db;
$gaSql ['server'] = database::$SERVER;

/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
// include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );

/*
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * If you just want to use the basic configuration for DataTables with PHP server-side, there is no need to edit below this line
 */
    
    /* 
     * MySQL connection
     */
    $gaSql ['link'] = mysql_pconnect ( $gaSql ['server'], $gaSql ['user'], $gaSql ['password'] ) or die ( 'Could not open connection to server' );

mysql_query ( "SET NAMES 'utf8'", $gaSql ['link'] );
mysql_select_db ( $gaSql ['db'], $gaSql ['link'] ) or die ( 'Could not select database ' . $gaSql ['db'] );

/*
 * Paging
 */
$sLimit = "";
if (isset ( $_GET ['iDisplayStart'] ) && $_GET ['iDisplayLength'] != '-1') {
    $sLimit = "LIMIT " . mysql_real_escape_string ( $_GET ['iDisplayStart'] ) . ", " . mysql_real_escape_string ( $_GET ['iDisplayLength'] );
}

/*
 * Ordering
 */
$sOrder = " order by trangthai desc";
if (isset ( $_GET ['iSortCol_0'] )) {
    $sOrder = "ORDER BY  ";
    for($i = 0; $i < intval ( $_GET ['iSortingCols'] ); $i ++) {
        if ($_GET ['bSortable_' . intval ( $_GET ['iSortCol_' . $i] )] == "true") {
            $column = $name_list [intval ( $_GET ['iSortCol_' . $i] )];
            
            // Change column(s) to sort
            switch ($column) {
                case "hoten" :
                    $column = "created_by";
                    break;
            }
            
            $sOrder .= "" . $column . " " . mysql_real_escape_string ( $_GET ['sSortDir_' . $i] ) . ", ";
        }
    }
    
    $sOrder = substr_replace ( $sOrder, "", - 2 );
    if ($sOrder == "ORDER BY") {
        $sOrder = "";
    }
    $sOrder = $sGroupBy . ' ' . $sOrder;
}
$sOrder = " order by trangthai asc";
/*
 * Filtering NOTE this does not match the built-in DataTables filtering which does it word by word on any field. It's possible to do here, but concerned about efficiency on very large tables, and MySQL's regex functionality is very limited
 */
$sWhere = "";
if (isset ( $_GET ['sSearch'] ) && $_GET ['sSearch'] != "") {
    $sWhere = "WHERE (";
    for($i = 0; $i < count ( $aColumns ); $i ++) {
        if ($i != - 1)         // Column(s) index to search
        {
            $column = $aColumns [$i];
            $sWhere .= "" . $column . " LIKE '%" . mysql_real_escape_string ( unicode_to_ascii ( $_GET ['sSearch'] ) ) . "%' OR ";
        }
    }
    $sWhere = substr_replace ( $sWhere, "", - 3 );
    $sWhere .= ')';
}

/* Individual column filtering */
for($i = 0; $i < count ( $aColumns ); $i ++) {
    if (isset ( $_GET ['bSearchable_' . $i] ) && $_GET ['bSearchable_' . $i] == "true" && $_GET ['sSearch_' . $i] != '') {
        if ($sWhere == "") {
            $sWhere = "WHERE ";
        } else {
            $sWhere .= " AND ";
        }
        if ($i != - 1)         // Column(s) index to search
        {
            $column = $aColumns [$i];
            $sWhere .= "" . $column . " LIKE '%" . mysql_real_escape_string ( unicode_to_ascii ( $_GET ['sSearch_' . $i] ) ) . "%' ";
        }
    }
}

/*
 * SQL queries Get data to display
 */
// Additional condition
$trangthai = 0;
$additional = " (`trangthai` >= '{$trangthai}') ";

if ($additional != "") {
    if ($sWhere == "")
        $sWhere = "WHERE ";
    else
        $sWhere .= " AND ";
    $sWhere .= $additional;
}

$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS " . str_replace ( " , ", " ", implode ( ", ", $aColumns ) ) . "
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
        ";
// debug($sQuery);
$rResult = mysql_query ( $sQuery, $gaSql ['link'] ) or die ( mysql_error () );
// debug($rResult);

/* Data set length after filtering */
$sQuery = "
        SELECT FOUND_ROWS()
    ";
$rResultFilterTotal = mysql_query ( $sQuery, $gaSql ['link'] ) or die ( mysql_error () );
$aResultFilterTotal = mysql_fetch_array ( $rResultFilterTotal );
$iFilteredTotal = $aResultFilterTotal [0];

/* Total data set length */
$sQuery = "
        SELECT COUNT(" . $sIndexColumn . ")
        FROM   $sTable
    ";
if ($additional != "") {
    $sQuery .= " WHERE $additional ";
}
// debug($sQuery);
$rResultTotal = mysql_query ( $sQuery, $gaSql ['link'] ) or die ( mysql_error () );
$aResultTotal = mysql_fetch_array ( $rResultTotal );
$iTotal = $aResultTotal [0];

/*
 * Output
 */
$output = array (
        "sEcho" => intval ( $_GET ['sEcho'] ),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array () 
);

// DB model
$detail_model = new trahang ();

while ( $aRow = mysql_fetch_array ( $rResult ) ) {
    // debug ( $aRow );
    $row = array ();
    for($i = 0; $i < count ( $aColumns ); $i ++) {
        $column = $name_list [$i];
                $row [] = $aRow [$column];
        
    }
    
    $output ['aaData'] [] = $row;
}

echo json_encode ( $output );

require_once '../part/common_end_page.php';
?>
