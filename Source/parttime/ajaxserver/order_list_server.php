<?php
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
                       'donhang.ngaydat', 'donhang.ngaygiao', 'donhang.giogiao', 'donhang.thanhtien', 'khach.dienthoai1', 
                       'donhang.madon AS sanpham' 
                      );
    
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "donhang.madon";
    
    /* DB table to use */
    $sTable = "donhang INNER JOIN khach ON donhang.makhach = khach.makhach 
                       INNER JOIN nhomkhach ON khach.manhom = nhomkhach.manhom
                       LEFT JOIN giaohang ON giaohang.madon = donhang.madon
                       LEFT JOIN chitietdonhang ON chitietdonhang.madon=donhang.madon";
    
    /* Database connection information */
    $gaSql['user']       = database::$USERNAME;
    $gaSql['password']   = database::$PASSWORD;
    $gaSql['db']         = database::$db;
    $gaSql['server']     = database::$SERVER;
    
    /* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
    //include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
    
    // Xoa cac don hang khong hop le
    $don_hang = new donhang();
    $don_hang->fix_delivery_return();
    
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
    $sOrder = "ORDER BY donhang.ngaygiao, case when (donhang.giogiao = '00:00:00') or ISNULL(donhang.giogiao) then 1 else 0 end, donhang.giogiao ASC";
    
    
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
            if($column != 'sanpham') {
                if ($column == 'ngaygiao') {$column = 'donhang.ngaygiao';}
                if ($column != 'madon') {
                    $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
                } else {
                    $sWhere .= "" . "donhang.madon" . " LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
                }
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
        $sWhere .= sprintf(" AND (donhang.trangthai = '%s') AND (approved = '%s')", donhang::$CHO_GIAO, donhang::$APPROVED);
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
                if ($column == 'ngaygiao') {$column = 'donhang.ngaygiao';}
                if ($column != 'madon') {
                    $sWhere .= "" . $column . " LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
                } else {
                    $sWhere .= "" . "donhang.madon" . " LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
                }
            }
        }
    }
    if ( $sWhere == "" )
        $sWhere = sprintf("WHERE (donhang.trangthai = '%s') AND (approved = '%s')", donhang::$CHO_GIAO, donhang::$APPROVED);
    $sWhere .= " GROUP BY donhang.madon HAVING SUM(chitietdonhang.soluong)>0";
    
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns)).", 
        CONCAT(khach.diachi,' ',khach.quan,' ',khach.tp) as diachi, GROUP_CONCAT(distinct(giaohang.manv)) as nhanvien 
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
        ";

    // update
      $sQuery = "(SELECT SQL_CALC_FOUND_ROWS donhang.madon, khach.hoten, nhomkhach.tennhom, donhang.ngaydat, donhang.ngaygiao, donhang.giogiao, donhang.thanhtien, khach.dienthoai1, donhang.madon AS sanpham, CONCAT(khach.diachi,' ',khach.quan,' ',khach.tp) as diachi, GROUP_CONCAT(distinct(giaohang.manv)) as nhanvien , 'order' AS loai
        FROM donhang INNER JOIN khach ON donhang.makhach = khach.makhach INNER JOIN nhomkhach ON khach.manhom = nhomkhach.manhom LEFT JOIN giaohang ON giaohang.madon = donhang.madon LEFT JOIN chitietdonhang ON chitietdonhang.madon=donhang.madon 
        WHERE (donhang.trangthai = '0') AND (approved = '1') 
        GROUP BY donhang.madon HAVING SUM(chitietdonhang.soluong)>0)
        UNION
        (SELECT gct.maphieu AS madon, k.hoten, nk.tennhom, gct.ngaygiao AS ngaydat, gct.ngaygiao, gct.giogiao, '0' AS thanhtien, k.dienthoai1, '---' AS sanpham, k.diachi, GROUP_CONCAT(distinct(gh.manv)) nhanvien, 'vouchers' AS loai
        FROM giaochungtu AS gct INNER JOIN khach k on k.makhach = gct.makhach INNER JOIN nhomkhach nk on nk.manhom  = k.manhom LEFT JOIN giaohang gh on gh.madon = gct.maphieu
        WHERE gct.trangthai = '0' GROUP BY maphieu)
        ORDER BY ngaygiao, case when (giogiao = '00:00:00') or ISNULL(giogiao) then 1 else 0 end, giogiao ASC
        ";

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
    
    $temp = NULL;
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    //$format = "d/m/Y";
    $format = "d/m/Y";
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $date = dbtime_2_systime($aRow[ 'ngaygiao' ], $format);
    
        if($temp == NULL || $temp != $date)
        {
            // 0-Mã hóa đơn; 1-Khách hàng; 2-Nhóm khách; 3-Ngày đặt; 4-Ngày giao; 5-Thành tiền; 6-Danh sách sản phẩm; 
            $row = array('', '', '', $date, '', '', '', '');
            $output['aaData'][] = $row;
        }
        
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $column_name = get_column_name($aColumns[$i]);
            switch($column_name)
            {
                case 'sanpham':
                    $row[] = $don_hang->danh_sach_ma_so_tranh_dat_mua($aRow[ $column_name ]);
                    break; 
                case 'ngaydat':
                case 'ngaygiao':
                    $row[] = dbtime_2_systime($aRow[ $column_name ], $format);
                    break;
                case 'thanhtien':
                    $row[] = number_2_string($aRow[ $column_name ], '.');
                    break;                   
                default:
                    if ( $column_name != ' ' )
                        $row[] = $aRow[ $column_name ];
            }
        }
        $row[] =  $aRow[ 'diachi' ];
        $row[] =  $aRow[ 'nhanvien' ];
        $row[] =  $aRow[ 'loai' ];
        $output['aaData'][] = $row;
        
        $temp = $date;
    }
    
    echo json_encode( $output );
?>
