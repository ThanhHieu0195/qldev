<?php ini_set('display_errors', 1);
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

     require_once '../models/database.php';
     require_once '../models/helper.php';
     require_once '../models/donhang.php';

    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 'donhang.madon', 'khach.hoten', 'nhomkhach.tennhom', 
                       'donhang.ngaydat', 'donhang.ngaygiao', 'donhang.thanhtien', 
                       'donhang.madon AS sanpham'
                      );
    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "donhang.madon";
    
    /* DB table to use */
    $sTable = "donhang INNER JOIN khach ON donhang.makhach = khach.makhach
                       INNER JOIN nhomkhach ON khach.manhom = nhomkhach.manhom";
    
    /* Database connection information */
    $gaSql['user']       = database::$USERNAME;
    $gaSql['password']   = database::$PASSWORD;
    $gaSql['db']         = database::$db;
    $gaSql['server']     = database::$SERVER;
    
    /* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
    //include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
    
    // Xoa cac don hang khong hop le
    //$don_hang = new donhang();
    //$don_hang->fix_delivery_return();
    
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
    $sOrder = "ORDER BY donhang.ngaygiao ASC";
    
    
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
            $column = get_column_name($aColumns[$i]);
            if($column != 'sanpham')
                $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
        $sWhere .= sprintf(" AND (support = '%s') AND (approved = '%s')", donhang::$SUPPORT_MONITOR, donhang::$APPROVED);
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
            $column = get_column_name($aColumns[$i]);
            if($column != 'sanpham')
                $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
    if ( $sWhere == "" )
        $sWhere = sprintf("WHERE (support = '%s') AND (approved = '%s')", donhang::$SUPPORT_MONITOR, donhang::$APPROVED);
    
    
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
        ";
    //debug($sQuery);
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
    
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
    
    $temp = NULL;
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $format = "d/m/Y";
    //$format = "Y-m-d";
    $don_hang = new donhang();
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        //debug($aRow);
        
        $date = dbtime_2_systime($aRow[ 'ngaygiao' ], $format);
    
        if($temp == NULL || $temp != $date)
        {
            $row = array('', '', '', $date, '', '', '');
            $output['aaData'][] = $row;
        }
        
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $column_name = get_column_name($aColumns[$i]);
            switch($column_name)
            {
                case 'thanhtien':
                    $row[] = number_2_string($aRow[ $column_name ], '.');
                    break;
                case 'ngaydat':
                case 'ngaygiao':
                    $row[] = dbtime_2_systime($aRow[ $column_name ], $format);
                    break;
                case 'sanpham':
                    $row[] = $don_hang->danh_sach_ma_so_tranh_dat_mua($aRow[ $column_name ]);
                    break;
                default:
                    if ( $column_name != ' ' )
                        $row[] = $aRow[ $column_name ];
            }
        }
        //debug($row);
        $output['aaData'][] = $row;
        
        $temp = $date;
    }
    
    echo json_encode( $output );
?>