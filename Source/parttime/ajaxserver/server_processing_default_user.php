<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
     require_once '../models/tranh.php';
     require_once '../models/default_users_stores.php';

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'tranh.masotranh', 'tranh.tentranh', 'loaitranh.tenloai', 'tranh.giaban', 'khohang.tenkho', 'tonkho.soluong', 'tranh.hinhanh', 'tonkho.makho' );
	
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
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
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
	
    $tranh = new tranh();
    $check_value = '';
    $total_row = 0;
    $account = '';
    if (isset($_REQUEST['account'])) {
        $account = $_REQUEST['account'];
    }
    $stores_model = new default_users_stores();
    $stores = $stores_model->list_stores_by_account($account);
    
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
	    if (in_array($aRow['makho'], $stores['store_id']) === TRUE) {
    	    if ($check_value != $aRow['masotranh']) {
    	        // Add old row
    	        if (!empty($check_value)) {
        	        $row = array();
        	        $row[] = $tmp['masotranh'];
        	        $row[] = $tmp['tentranh'];
        	        $row[] = $tmp['tenloai'];
        	        $row[] = $tmp['giaban'];
        	        $row[] = $tmp['tenkho'];
        	        $row[] = ($tmp['soluong'] > $tmp['soluong_ban']) ? $tmp['soluong'] - $tmp['soluong_ban'] : 0;
        	        $row[] = $tmp['hinhanh'];
        	        $row[] = $tmp['makho'];
        	        
        	        $output['aaData'][] = $row;
        	        $total_row++;
    	        }
    	        // Get checking value
    	        $check_value = $aRow['masotranh'];
    	        // Create new row
    	        $arr = array();
    	        $tranh->statistic_number($aRow['masotranh'], $arr);
    	        $tmp = array(
    	           'masotranh' => $aRow['masotranh'], 
    	           'tentranh' => $aRow['tentranh'], 
    	           'tenloai' => $aRow['tenloai'], 
    	           'giaban' => str_replace(',', '.', number_format($aRow['giaban'])),
    	           'tenkho' => sprintf("&bull; <span class='blue'>%s, tồn kho: </span> <span class='red'>%s </span><br />", $aRow['tenkho'], $aRow['soluong']), 
    	           //'soluong' => $arr['remaind'],
    	           'soluong' => $aRow['soluong'],
    	           'hinhanh' => $aRow['hinhanh'], 
    	           'makho' => $aRow['makho'],
    	           'soluong_ban' => $arr['selled'],
    	        );
    	    } else {
    	        $tmp['tenkho'] = $tmp['tenkho'] . sprintf("&bull; <span class='blue'>%s, tồn kho: </span><span class='red'>%s </span><br />", $aRow['tenkho'],$aRow['soluong']);
    	        $tmp['soluong'] += $aRow['soluong'];
    	    }
	    }
	}
	if ($total_row == 0 && isset($tmp)) {
	    $row = array();
        $row[] = $tmp['masotranh'];
        $row[] = $tmp['tentranh'];
        $row[] = $tmp['tenloai'];
        $row[] = $tmp['giaban'];
        $row[] = $tmp['tenkho'];
        $row[] = ($tmp['soluong'] > $tmp['soluong_ban']) ? $tmp['soluong'] - $tmp['soluong_ban'] : 0;
        $row[] = $tmp['hinhanh'];
        $row[] = $tmp['makho'];
        	        
	    $output['aaData'][] = $row;
	    $total_row++;
	}
	// Update items count
	$output['iTotalRecords'] = $total_row;
	$output['iTotalDisplayRecords'] = $total_row;
	
	echo json_encode( $output );
?>
