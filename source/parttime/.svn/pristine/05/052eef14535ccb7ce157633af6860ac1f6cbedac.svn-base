<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */

     require_once '../models/database.php';
     require_once '../models/helper.php';

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( "list_building.id", "list_building.tencongtrinh", "list_building.ngaykhoicong", "list_building.ngaydukienhoanthanh", "status_building.mota AS trangthai", "list_building.giatridutoan", "list_building.giatrithucte", "list_building.giatriphatsinh","(select ifnull(group_concat(h.tenhangmuc separator ', '),'') from chitiethangmuccongtrinh c inner join hangmucthicong h on c.idhangmuc=h.id inner join trangthaihangmuc t on t.id=c.trangthai where c.idcongtrinh=list_building.id and t.id=10) as trangthaihangmuc");

	$aColumns_search = array( "list_building.id", "list_building.tencongtrinh", "list_building.ngaykhoicong", "list_building.ngaydukienhoanthanh", "status_building.mota", "list_building.giatridutoan", "list_building.giatrithucte", "list_building.giatriphatsinh");

	$bcolumn = array("id", "tencongtrinh", "ngaykhoicong", "ngaydukienhoanthanh", "trangthai", "giatridutoan", "giatrithucte", "giatriphatsinh", "trangthaihangmuc");
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "list_building.id";
	
	/* DB table to use */
	$sTable = "danhsachcongtrinh list_building 
				left join trangthaicongtrinh status_building on status_building.id = list_building.trangthai";
	
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
                $sOrder .= "" . $column . " ".
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
		for ( $i=0 ; $i<count($aColumns_search) ; $i++ )
		{
            $column = $aColumns_search[$i];
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
            $column = get_column_name($aColumns[$i]);

            $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}

    if ( $sWhere == "" ):
        $sWhere = "where list_building.trangthai=0";
    else:
        $sWhere .= " AND list_building.trangthai=0";
    endif;  
	
	
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
       //error_log ("Add new " . $sQuery, 3, '/var/log/phpdebug.log');
    // echo $sQuery;
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
	
	$output['id_building'] = array();
	while ( $row = mysql_fetch_array( $rResult ) )
	{
		$nrow = array();
		if (in_array($row['id'], $output['id_building'])) {
			$index = array_search($row['id'], $output['id_building']);
			$obj = $output['aaData'][$index];
			// echo $row['id']." - ".$index. ";";
			$obj[count($bcolumn)-1][] = array($row['tenhangmuc'], $row['trangthaihangmuc']);
			 $output['aaData'][$index] = $obj;
		} else {
			for ($i=0; $i < count($bcolumn); $i++) { 
				$name = $bcolumn[$i];
				switch ($name) {
					default:
						$nrow[] = $row[$name];
						break;
				}
			}
			$output['id_building'][] = $row['id'];
			$output['aaData'][] = $nrow;
		}
	}
	
	echo json_encode( $output );
?>
