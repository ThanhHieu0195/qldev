<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

     require_once '../models/database.php';
     require_once '../config/constants.php';
     require_once '../models/helper.php';
     require_once '../models/task.php';
     require_once '../models/task_detail.php';
     
     session_start();
     
     error_reporting(E_ALL ^ E_NOTICE);
     
     $task = new task();
     $task->refresh_status();

    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 't.task_id',
                       't.title',
                       'n1.hoten as hoten1',
                       'n2.hoten as hoten2',
                       't.deadline',
                       't.status',
                       't.has_detail',
                       't.content',
                       't.created_date'
                     );
    /* Short name list of columns */
    $name_list = array( 'task_id',
                        'title',
                        'hoten1',
                        'hoten2',
                        'deadline',
                        'status',
                        'has_detail',
                        'content',
                        'created_date'
                     );
    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = 'task_id';
    
    /* DB table to use */
    $sTable = 'task t INNER JOIN nhanvien n1 ON t.created_by = n1.manv INNER JOIN nhanvien n2 ON t.assign_to = n2.manv';
    
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
    $sOrder = "ORDER BY t.deadline ASC";
    
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
            if($i == 1 || $i == 4 || $i == 7)
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
            if($i == 1 || $i == 4 || $i == 7)
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
    $is_finished = BIT_FALSE;

    $additional = "(is_finished = $is_finished)";

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
        WHERE $additional
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
    
    $model = new task_detail();
    $temp = NULL;
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        //debug($aRow);
        $date = $aRow['deadline'];
        if($temp == NULL || $temp != $date) {
            $row = array('', '', '', '', $date, '', '', '');
            $output['aaData'][] = $row;
        }
        
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $column = $name_list[$i];
            //debug($column);
            switch($column)
            {
                case 'has_detail':
                    if($aRow['has_detail'] == BIT_TRUE) {
                        $result = "<span class='price'>Gồm các công việc nhỏ sau:</span><br />";
                        $arr = $model->detail_list($aRow['task_id']);
                        foreach ($arr as $item)
                        {
                            $format = "&bull; <span class='blue'>%s</span><br />";
                            $result .= sprintf($format, $item->content);
                        }
                    }
                    else {
                        $format = "<span class='blue'>%s</span><br />";
                        $result = sprintf($format, $aRow['content']);
                    }
                
                    $row[] = $result;
                    break;
                    
                default:
                    $row[] = $aRow[$column];
            }
        }
        $output['aaData'][] = $row;
        
        $temp = $date;
    }
    
    echo json_encode( $output );
?>