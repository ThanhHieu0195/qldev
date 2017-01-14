<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

     require_once '../models/database.php';
     require_once '../models/helper.php';

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'khach.makhach', 'khach.hoten', 'nhomkhach.tennhom',
		       'khach.diachi',
                       'khach.tiemnang',
                       'nhanvien.hoten AS tennv',
                       'marketing.ghichu',
                       'khach.makhach', 
                       'khach.makhach'
                     );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "khach.makhach";
	
	/* DB table to use */
	$sTable = "khach INNER JOIN marketing ON khach.makhach = marketing.makhach
                         LEFT JOIN nhomkhach ON khach.manhom = nhomkhach.manhom
                         LEFT JOIN nhanvien ON nhanvien.manv = marketing.manv";
    $sGroupBy = "GROUP BY khach.makhach";
	
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
                $column = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
                $column = get_column_name($column);
                if($column !== 'doanhso')
                    $column = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
                  
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
	$nhomkhach = (isset($_GET['nhomkhach'])) ? $_GET['nhomkhach'] : -1;
	$tmpQuery = "";
    if ($nhomkhach == -1)
    {
        $tmpQuery = "";
    }
    else
    {
        $tmpQuery = sprintf(" (marketing.chiendich = '%s') ", $nhomkhach);
    }
	$sWhere = "WHERE (marketing.lienhe=0) ";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
                $sWhere .= " AND (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{   
                    if ($aColumns[$i] == 'nhanvien.hoten AS tennv') { 
                        $column = "nhanvien.hoten";
                        
                    } else {
                        $column = $aColumns[$i];
                    }
                    $sWhere .= " (" . $column . " LIKE '%".mysql_real_escape_string($_GET['sSearch'])."%' ) ";
                    if ($i<count($aColumns)-1) {
                        $sWhere .= "OR";
                    }
		}
		$sWhere .= " )";
	}
        //error_log ($sWhere, 3, '/var/log/phpdebug.log');
	
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
		}
	}

	if ($tmpQuery != "") {
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE " . $tmpQuery;
			}
			else
			{
				$sWhere .= " AND {$tmpQuery} ";
			}
		}
	
	
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
    //echo $sQuery;
        //error_log ($sQuery, 3, '/var/log/phpdebug.log');
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
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
            $column_name = get_column_name($aColumns[$i]);   
                 
            switch($column_name)
            {
                case 'doanhso':
                    if( ! $aRow[ $column_name ])
                        $row[] = 0;
                    else
                        $row[] = number_2_string($aRow[ $column_name ], '.');
                    break;
                    
                case 'tiemnang':
                    $row[] = ($aRow[ $column_name ] == '1') ? 'Có' : 'Không';
                    break;
                default:
                    if ( $column_name != ' ' )
                        $row[] = $aRow[ $column_name ];
            }
		}
		$output['aaData'][] = $row;
	}
        //error_log (json_encode( $output ), 3, '/var/log/phpdebug.log');	
	echo json_encode( $output );
?>
