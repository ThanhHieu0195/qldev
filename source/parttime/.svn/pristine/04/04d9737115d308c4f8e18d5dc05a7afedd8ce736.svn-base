<?php
/*
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * Easy set variables
 */
require_once '../part/common_start_page.php';
require_once '../models/guest_development_history.php';

/*
 * Array of database columns which should be read and sent back to DataTables. Use a space where you want to insert a non-database field (for example a counter or static image)
 */
$aColumns = array (
        'k.hoten',
        'k.diachi',
        'e.note',
        'n.hoten AS tennv',
        'e.guest_id',
        'e.event_date',
        'r.employee_id' 
);
/* Short name list of columns */
$name_list = array (
        'hoten',
        'diachi',
        'note',
        'tennv',
        'guest_id',
        'event_date',
        'employee_id' 
);

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = 'e.uid';

/* DB table to use */
$sTable = 'guest_events e INNER JOIN khach k ON e.guest_id = k.makhach
                          INNER JOIN guest_responsibility r ON e.guest_id = r.guest_id
                          INNER JOIN nhanvien n ON r.employee_id = n.manv';
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
            // $column = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
            $column = $name_list [intval ( $_GET ['iSortCol_' . $i] )];
            // if($column !== 'doanhso')
            // $column = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
            
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
        // if($i != 2)
        {
            $column = $aColumns [$i];
            if ($i == 3) {
                $column = "n.hoten";
            }
            
            $sWhere .= "" . $column . " LIKE '%" . mysql_real_escape_string ( $_GET ['sSearch'] ) . "%' OR ";
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
        // if($i != 2)
        {
            $column = $aColumns [$i];
            if ($i == 3) {
                $column = "n.hoten";
            }
            
            $sWhere .= "" . $column . " LIKE '%" . mysql_real_escape_string ( $_GET ['sSearch_' . $i] ) . "%' ";
        }
    }
}

/*
 * SQL queries Get data to display
 */
$start = (isset ( $_GET ['start'] )) ? $_GET ['start'] : '';
$development = GUEST_DEVELOPMENT_ONGOING;
$enable = BIT_TRUE;
//$additional = " DATEDIFF(e.event_date, '{$start}') = 0 AND e.enable = '{$enable}' AND k.development = '{$development}' ";
$additional = " DATEDIFF(e.event_date, '{$start}') = 0 AND e.enable = '{$enable}' ";
if (verify_access_right ( current_account (), F_GUEST_DEVELOPMENT_LIST_ALL )) {
    // Do nothing
} else {
    $employee_id = current_account ();
    $additional .= " AND r.employee_id = '{$employee_id}' ";
}

if ($sWhere == "")
    $sWhere = "WHERE ";
else
    $sWhere .= " AND ";
$sWhere .= $additional;

$sOrder = "ORDER BY e.event_date";

$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS " . str_replace ( " , ", " ", implode ( ", ", $aColumns ) ) . "
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
        ";
// debug ( $sQuery );
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
        WHERE $additional
    ";
// debug($sQuery);
error_log ("HUAN " . $sQuery, 3, '/var/log/phpdebug.log');
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

// Checking table
$table = array ();

// DB model
$history_model = new guest_development_history ();

while ( $aRow = mysql_fetch_array ( $rResult ) ) {
    // debug($aRow);
    
    // Add header row
    if (! in_array ( $aRow ['event_date'], $table )) {
        $table [] = $aRow ['event_date'];
        
        $row = array ();
        $row [] = 'header';
        $row [] = $aRow ['event_date'];
        for($i = 2; $i < count ( $aColumns ); $i ++) {
            $row [] = '';
        }
        $output ['aaData'] [] = $row;
    }
    
    // Add data row
    $row = array ();
    for($i = 0; $i < count ( $aColumns ); $i ++) {
        $column = $name_list [$i];
        
        switch ($column) {
            case "employee_id" :
                $row [] = ($history_model->check_updating ( $aRow ['employee_id'], $aRow ['guest_id'], $aRow ['event_date'] )) ? 1 : 0;
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
