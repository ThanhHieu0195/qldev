<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

     require_once '../models/database.php';
     require_once '../config/constants.php';
     require_once '../models/helper.php';
     require_once '../part/error_reporting.php';
     require_once '../models/khohang.php';
     require_once '../models/working_plan.php';
     
     session_start();
     
     error_reporting(E_ALL ^ E_NOTICE);
     
     $model = new working_plan();
     $model->delete_empty_plans();

    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 'p.plan_uid',        //0
                       'p.branches',        //1
                       'p.from_date',       //2
                       'p.to_date',         //3
                       'n.hoten',           //4: created_by
                       'p.created_date'     //5
                     );
    /* Short name list of columns */
    $name_list = array('plan_uid',        //0
                       'branches',        //1
                       'from_date',       //2
                       'to_date',         //3
                       'hoten',           //4: created_by
                       'created_date'     //5
                     );
    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = 'p.plan_uid';
    
    /* DB table to use */
    $sTable = 'working_plan p INNER JOIN nhanvien n ON p.created_by = n.manv';
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
                $column = $name_list[intval($_GET['iSortCol_'.$i])];
                // Change columns name to sort
                if($column === 'hoten') {
                    $column = "created_by";
                }
                  
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
            if($i != 1) // index of searching columns
            {
                $column = $aColumns[$i];
                $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
            }
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
            if($i != 1) // index of searching columns
            {
                $column = $aColumns[$i];
                $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
            }
        }
    }
    
    /*
     * SQL queries
     * Get data to display
     */    
    $approved = BIT_FALSE;
    
    // Additional filtering conditions
    $additional = "(approved = '{$approved}')";

    if ($additional != "") {
        if($sWhere == "")
            $sWhere = "WHERE ";
        else 
            $sWhere .= " AND ";
        $sWhere .= $additional;
    }
    
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
    if ($additional != "") {
        $sQuery .= " WHERE $additional";
    }
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
    
    // DB model
    $kho = new khohang();
    
    $date_format = 'd/m/Y';
    
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
                case 'plan_uid':
                case 'hoten':
                    $row[] = $aRow[$column];
                    break;
                    
                case 'created_date':
                    $row[] = dbtime_2_systime($aRow[$column], 'd/m/Y H:i:s');
                    break;
                    
                case 'from_date':
                    $row[] = sprintf("%s - %s", dbtime_2_systime($aRow['from_date'], $date_format), 
                                                dbtime_2_systime($aRow['to_date'], $date_format));
                    break;
                    
                case 'branches':
                    $arr = explode(ARRAY_DELIMITER, $aRow[$column]);
                    $name = $kho->get_list_name($arr);
                    $tmp = "";
                    
                    if (is_array($name)) {
                        for ($j = 0; $j < count($arr); $j++) {
                            $tmp .= sprintf("• <span>%s</span><br />", $name[$arr[$j]]);
                        }
                    }
                    
                    $row[] = $tmp;
                    break;
                
                default:
            }
        }
        $output['aaData'][] = $row;
    }
    
    echo json_encode( $output );
?>