<?php
/*
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * Easy set variables
 */
require_once '../part/common_start_page.php';
require_once '../models/finance_token_detail.php';

/*
 * Array of database columns which should be read and sent back to DataTables. Use a space where you want to insert a non-database field (for example a counter or static image)
 */
$aColumns = array (
        't.token_id',
        't.created_date',
        't.amount',
        'n.hoten',
        't.token_type' 
);
/* Short name list of columns */
$name_list = array (
        'token_id',
        'created_date',
        'amount',
        'hoten',
        'token_type' 
);

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = 't.token_id';

/* DB table to use */
$sTable = 'finance_token t INNER JOIN nhanvien n ON t.created_by = n.manv';
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
$sOrder = "";
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
$is_finished = BIT_TRUE;
$approved = BIT_FALSE;
$additional = " (`is_finished` = '{$is_finished}') AND (`approved` = '{$approved}') AND (amount > 0) ";

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
$detail_model = new finance_token_detail ();

while ( $aRow = mysql_fetch_array ( $rResult ) ) {
    // debug ( $aRow );
    $row = array ();
    for($i = 0; $i < count ( $aColumns ); $i ++) {
        $column = $name_list [$i];
        // debug ( $column );
        switch ($column) {
        	case 'amount':
        	    $row [] = $aRow [$column];
        	    
        	    // Calculate total money of the token
        	    $row [] = number_format ( $detail_model->total_money_by_token ( $aRow ['token_id'] ), 0, ",", "." );
        	    
        	    break;
        	    
            default :
                $row [] = $aRow [$column];
        }
    }
    
    $output ['aaData'] [] = $row;
}

echo json_encode ( $output );

require_once '../part/common_end_page.php';
?>
