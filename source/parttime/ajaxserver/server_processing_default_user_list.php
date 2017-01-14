<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
     require_once '../models/tranh.php';
     require_once '../models/default_users_stores.php';
     
     $account = '';
     if (isset($_REQUEST['account'])) {
         $account = $_REQUEST['account'];
     }
     $stores_model = new default_users_stores();
     $stores = $stores_model->list_stores_by_account($account);

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'tranh.masotranh', 'tranh.tentranh', 'loaitranh.tenloai', 'tranh.giaban', 'khohang.tenkho', 'tonkho.soluong', 'tranh.hinhanh' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "tranh.masotranh";
	
	/* DB table to use */
	$sTable = "tonkho
        INNER JOIN tranh ON tonkho.masotranh = tranh.masotranh
        INNER JOIN khohang ON tonkho.makho = khohang.makho
        INNER JOIN loaitranh ON tranh.maloai = loaitranh.maloai";
	
	/* Database connection information */
    require_once '../models/database.php';
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
				$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
				 	mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
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
			$sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
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
			$sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$tmp = "'" . str_replace ( ", ", "', '", implode ( ", ", $stores['store_id'] ) ) . "'";
	$additional = " tonkho.makho IN ({$tmp}) ";
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
		WHERE  $additional
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
	
    $tranh = new tranh();
    
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
	    $z = 0;
        $thongke_soluong = $tranh->statistic_number_by_stores($aRow['masotranh'], $stores['store_id']);
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
            //++BinhLV_N
            $column_name = get_column_name($aColumns[$i]);
            //--BinhLV_N
			if ( $column_name == "version" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
            else if ( $column_name == "giaban" )
			{
				/* Special output formatting for 'giaban' column */
				$row[] = str_replace(',', '.', number_format($aRow[ $column_name ]));
			}
			else if ( $column_name != ' ' )
			{
				/* General output */
				// $row[] = $aRow[ $aColumns[$i] ];
                if ( $column_name == "soluong" )
                {
                    $row[] = $aRow[ $column_name ];
                    $row[] = $thongke_soluong;
                }
                else
                {
                    $row[] = $aRow[ $column_name ];
                }
			}
		}
        
        //debug($row);
        
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>