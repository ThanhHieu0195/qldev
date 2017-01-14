<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

     require_once '../models/database.php';
     require_once '../config/constants.php';
     require_once '../models/helper.php';
     require_once '../models/import_export_history.php';
     
     error_reporting(E_ALL ^ E_NOTICE);

    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 'DATE(i.datetime)',
                       'TIME(i.datetime)',
                       'n.hoten',
                       'i.product_id',
                       't.tentranh',
                       'k.tenkho',
                       'i.amount',
                       'i.bill_code',
                       'i.type',
                       'i.content'
                     );
    /* Short name list of columns */
    $name_list = array('DATE(i.datetime)',
                       'TIME(i.datetime)',
                       'hoten',
                       'product_id',
                       'tentranh',
                       'tenkho',
                       'amount',
                       'bill_code',
                       'type',
                       'content'
                     );
    /* Get date time */
    $from = (isset($_GET['from'])) ? $_GET['from'] : '1970-01-01';
    $to = (isset($_GET['to'])) ? $_GET['to'] : '1970-01-01';
    $showroom = (isset($_GET['showroom'])) ? $_GET['showroom'] : -1;
    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = 'i.datetime';
    
    /* DB table to use */
    $sTable = 'import_export_history i
                           inner join nhanvien n on i.doer = n.manv
                           inner join tranh t on i.product_id = t.masotranh
                           inner join khohang k on i.store_id = k.makho';
    $sGroupBy = '';
    
    /* Database connection information */
    $gaSql['user']       = database::$USERNAME;
    $gaSql['password']   = database::$PASSWORD;
    $gaSql['db']         = database::$db;
    $gaSql['server']     = database::$SERVER;
    
    /* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
    //include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
    
    /* 
     * MySQL connection
     */
    $gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
        die( 'Could not open connection to server' );

    mysql_query("SET NAMES 'utf8'", $gaSql['link']);
    mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
        die( 'Could not select database '. $gaSql['db'] );
    
    
    /* 
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
            mysql_real_escape_string( $_GET['iDisplayLength'] );
    }
    
    
    /*
     * Ordering
     */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                //$column = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
                $column = $name_list[intval($_GET['iSortCol_'.$i])];
                //if($column !== 'doanhso')
                //    $column = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
                  
                $sOrder .= "" . $column . " ".
                     mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
        
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
        $sOrder = $sGroupBy . ' ' . $sOrder;
    }
    
    
    /* 
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $column = $aColumns[$i];
            $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }

            $column = $aColumns[$i];
            $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
    
    /*
     * SQL queries
     * Get data to display
     */
    $status = import_export_history::$STATUS_ENABLE;
    //$additional = "(i.enable = $status) AND (DATEDIFF(i.datetime, '$from')>=0 OR DATEDIFF(i.datetime, '$to')<=0)";
    $additional = "(i.enable = $status) AND (DATE(i.datetime) BETWEEN '$from' AND '$to')";
    if($showroom != -1)
        $additional .= " AND (i.store_id = '$showroom') ";
    if($sWhere == "")
        $sWhere = "WHERE ";
    else 
        $sWhere .= " AND ";
    $sWhere .= $additional;
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere 
        $sOrder
        $sLimit
        ";
    //debug($sQuery);
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    //debug($rResult);
    
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];
    
    /* Total data set length */
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   $sTable
    ";
    //debug($sQuery);
    $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    $aResultTotal = mysql_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
    
    /*
     * Output
     */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
    
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        //debug($aRow);
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $column = $name_list[$i];
            //debug($column);
            switch($column)
            {
                case 'bill_code':
                    $row[] = sprintf("<a href='../orders/orderdetail.php?item=%s'>%s</a>", $aRow[$column], $aRow[$column]);
                    break;
                case 'type':
                    $row[] = ($aRow[$column] == import_export_history::$TYPE_IMPORT) ? 'Nhập' : 'Xuất';
                    break;
                default:
                    $row[] = $aRow[$column];
            }
        }
        $output['aaData'][] = $row;
    }
    
    //debug($output);
    
    echo json_encode( $output );
?>