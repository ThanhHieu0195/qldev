<?php
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

     require_once '../models/database.php';
     require_once '../models/helper.php';
     require_once '../models/donhang.php';
     require_once '../models/hoadondo.php';

     
    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 'donhang.madon', 'khach.hoten', 'donhang.thanhtien', 'donhang.cashing_date', 
                       'donhang.cashed_money', 'donhang.conlai', 'donhang.delivery_date',
                       'donhang.duatruoc', 'donhang.tien_giao_hang', 'donhang.hoa_don_do', 'nhomkhach.tennhom', 'donhang.giatrihoadondo'
                      );
    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "donhang.madon";
    
    /* DB table to use */
    $sTable = "donhang INNER JOIN khach ON donhang.makhach = khach.makhach
                       INNER JOIN nhomkhach ON khach.manhom = nhomkhach.manhom
                       LEFT JOIN trahang ON trahang.madon = donhang.madon
                       LEFT JOIN finance_token_detail AS ft ON (ft.madon = donhang.madon) AND (ft.item_id = '53b22965bf2d5')";
    
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
    $sOrder = "GROUP BY donhang.madon ORDER BY donhang.cashing_date ASC";
    
    
    /* 
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $cho_giao = ($_GET['cho_giao'] == 'true');
    $da_giao = ($_GET['da_giao'] == 'true');
    $tmpQuery = "";
    if ($cho_giao && $da_giao)
    {
        $tmpQuery = "";
    }
    else
    {
        if ($cho_giao)
        {
            $tmpQuery = sprintf(" AND (donhang.trangthai = '%s') ", donhang::$CHO_GIAO);
        }   
        else if ($da_giao)
        {
            $tmpQuery = sprintf(" AND (donhang.trangthai = '%s') ", donhang::$DA_GIAO);
        }
        else
        {
            $tmpQuery = sprintf(" AND (donhang.trangthai <> '%s') AND (donhang.trangthai <> '%s') ", donhang::$CHO_GIAO, donhang::$DA_GIAO);
        }
    }

    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $column = get_column_name($aColumns[$i]);
            if($column != 'sanpham') {
                if ($column == 'madon') { $column = "donhang.madon"; }
                $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
        $sWhere .= sprintf(" AND (approved = '%s') AND ((conlai > 0) OR ((conlai=0) AND (hoa_don_do<>'0') AND (money_amount IS NULL) AND (cashing_date>'2016-09-26')) ) AND (thanhtien > 0) {$tmpQuery} ", donhang::$APPROVED);
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
            if($column != 'sanpham') {
                if ($column == 'madon') { $column = "donhang.madon"; }
                $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
            }
        }
    }
    if ( $sWhere == "" )
        $sWhere = sprintf("WHERE (approved = '%s') AND ((conlai > 0) OR ((conlai=0) AND (hoa_don_do<>'0') AND (money_amount IS NULL) AND (cashing_date>'2016-09-26'))) AND (thanhtien > 0) {$tmpQuery} ", donhang::$APPROVED);
    
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns)).", IFNULL(SUM(trahang.tientralai),0) AS tralai, IFNULL(SUM(trahang.tiendoanhso),0) AS doanhsogiam
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
        ";
    //error_log ("Add new " . $sQuery, 3, '/var/log/phpdebug.log');
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
    $format = "d/m/Y";
    //$format = "Y-m-d";
    $don_hang = new donhang();
    $hoadondo = new RedBill();
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $date = dbtime_2_systime($aRow[ 'cashing_date' ], $format);
    
        if($temp == NULL || $temp != $date)
        {
            $row = array('', '', '', $date, '', '', '', '', '', '');
            $output['aaData'][] = $row;
        }
        
        $row = array();
        for ( $i=0 ; $i<count($aColumns)-1 ; $i++ )
        {
            $column_name = get_column_name($aColumns[$i]);
            switch($column_name)
            {
                case 'thanhtien':
                    $row[] = number_2_string($aRow[ $column_name ], '.');
                    break;
                case 'cashed_money':
                    $row[] = number_2_string($aRow[ $column_name ] - $aRow[ 'tralai' ], '.');
                    break;
                case 'conlai':
                    $row[] = number_2_string($aRow[ $column_name ], '.');
                    //number_2_string($aRow[ $column_name ] - $aRow[ 'doanhsogiam' ] + $aRow[ 'tralai' ], '.');
                    break;
                case 'duatruoc':
                case 'tien_giao_hang':
                    $row[] = number_2_string($aRow[ $column_name ], '');
                    break;
                case 'cashing_date':
                case 'delivery_date':
                    $row[] = dbtime_2_systime($aRow[ $column_name ], $format);
                    break;
                case 'hoa_don_do':
                case 'tennhom':
                    break;
                case 'IFNULL(SUM(trahang.tientralai),0) AS tralai':
                    $row[] = number_2_string($aRow[ $column_name ], '.');
                    break;
                case 'IFNULL(SUM(trahang.tiendoanhso),0) AS doanhsogiam':
                    $row[] = number_2_string($aRow[ $column_name ], '.');
                    break;
                default:
                    if ( $column_name != ' ' ) {
                        $row[] = $aRow[ $column_name ];
                    }
                    break;
            }
        }
        $row[] = number_2_string($aRow['conlai'], '');
        $row[] = $don_hang->danh_sach_ma_so_tranh_dat_mua($aRow[ 'madon' ]);
        $row[] = $aRow['hoa_don_do'];
        $row[] = $aRow['tennhom'];
        $row[] = number_2_string($aRow['conlai'], '');
        //number_2_string($aRow['conlai'] - $aRow[ 'doanhsogiam' ] + $aRow[ 'tralai' ], '');
        if (($aRow['hoa_don_do']!='0') && ($hoadondo->hdd_chuathu($aRow['madon']))) {
            if ($aRow['giatrihoadondo']>$aRow['thanhtien']) {
                $row[] = number_2_string($aRow['giatrihoadondo']*0.1 + ($aRow['giatrihoadondo']-$aRow['thanhtien'])*0.2,'');
            } else if (($aRow['giatrihoadondo']<$aRow['thanhtien']) && ($aRow['giatrihoadondo']>0)) {
                $row[] = number_2_string($aRow['giatrihoadondo']*0.1,'');
            } else {
                $row[] = number_2_string($aRow['thanhtien']*0.1,'');
            }
        } else {
            $row[] = '0';
        }
        $output['aaData'][] = $row;

        //debug($row);
        
        $temp = $date;
    }
    
    echo json_encode( $output );
?>
