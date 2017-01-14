<?php
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );

/**
 * Error reporting
 */
error_reporting ( E_ALL );
ini_set ( 'display_errors', TRUE );
ini_set ( 'display_startup_errors', TRUE );

// Get input data
$from = (isset ( $_GET ['from'] )) ? $_GET ['from'] : "";
$to = (isset ( $_GET ['to'] )) ? $_GET ['to'] : "";
$cashier = (isset ( $_GET ['cashier'] )) ? $_GET ['cashier'] : "";

// Authenticate
do_authenticate ( G_ORDERS, F_ORDERS_DETAIL_LIST, TRUE );

/**
 * Include PHPExcel
 */
require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';

    // Lay danh sach cac loai san pham cua mot hoa don
    function product_type_by_order($order_id)
    {
        $sql = "SELECT loaitranh.tenloai 
                FROM chitietdonhang
                    inner join tranh on chitietdonhang.masotranh = tranh.masotranh
                    inner join loaitranh on tranh.maloai = loaitranh.maloai
                WHERE madon = '{$order_id}' limit 1";
        $db = new database();
        $db->setQuery($sql);
        $result = $db->query ();
        $row = mysql_fetch_array ( $result );
        $db->disconnect ();
        
        if (is_array ( $row )) {
            return $row ['tenloai'];
        }

        return "";
    }

  function order_list($from, $to, $cashier = '', $export = FALSE)
    {
        $str = '';
        if (!empty($cashier))
        {
            $str = " AND (n.manv = '{$cashier}') ";
        }

        // Get data from database
        $sql = "SELECT d.`trangthai`, d.`madon`, k.`hoten` AS khachhang, nk.`tennhom` AS nhomkhach, d.`tongtien`, d.`tiengiam`,d.`thanhtien`, 
                      n.`manv`, n.`hoten` AS tennhanvien, d.`giamtheo`,d.`ngaydat`,d.`cashed_money`,(select count(makhach) FROM `donhang` where `makhach` = d.`makhach`) AS khachmualan,(select count(employee_id) FROM `employee_of_order` where `order_id` = d.`madon`) AS soluongnv
                FROM `donhang` d              INNER JOIN `khach` k ON d.`makhach` = k.`makhach`
                                              INNER JOIN `nhomkhach` nk ON k.`manhom` = nk.`manhom`
											  INNER JOIN `employee_of_order` e ON d.`madon` = e.`order_id`
                                              INNER JOIN `nhanvien` n ON e.`employee_id` = n.`manv`
                WHERE (d.ngaydat BETWEEN '{$from}' AND '{$to}')
                      {$str}
                ORDER BY d.`madon` ASC";
        $db = new database();
        $db->setQuery($sql);
        $array = $db->loadAllRow();
        $db->disconnect();
        
        //debug($sql);
        //debug($array);
    
        if(is_array($array))
        {
            $result = array();
        
            // Create output data
            for($i=0; $i<count($array); $i++)
            {
                $tmp = $array[$i];
            
                if ($export)
                {
                    $item = array();
                    $item['madon']          = $tmp['madon'];
                  $item['khachhang']      = $tmp['khachhang'];
                    $item['nhomkhach']      = $tmp['nhomkhach'];
                    $item['tongtien']       = number_2_string($tmp['tongtien'], '');
                    $item['tiengiam']    = number_2_string($tmp['tongtien']-$tmp['thanhtien'], '');
					$item['giamtheo']    = number_2_string($tmp['giamtheo'], '');
					
                    if ($tmp['tongtien']>0) {
                        $item['phamtramgiam']   =  ((round((($tmp['tongtien']-$tmp['thanhtien'])/($tmp['tongtien'])),2))*100)."%";
                    } else {
                        $item['phamtramgiam'] = "0%";
                    }
					$item['doanhso']   = number_2_string(($tmp['thanhtien'])/($tmp['soluongnv']), '');
                    $item['ds'] = $tmp['thanhtien']/$tmp['soluongnv'];
                    $item['khachmualan']       = $tmp['khachmualan'];
					$item['tennhanvien']       = $tmp['tennhanvien'];
                    $item['ngaydat']        = dbtime_2_systime($tmp['ngaydat'], 'd/m/Y');
					$item['trangthai']       = ($tmp['trangthai']==1)? "Đã giao":"Chờ giao";
                    
                }
                else
                {
                    $item = array();
                   $item['madon']          = $tmp['madon'];
                    $item['khachhang']      = $tmp['khachhang'];
                    $item['nhomkhach']      = $tmp['nhomkhach'];
                    $item['tongtien']       = number_2_string($tmp['tongtien'], '');
                    $item['tiengiam']    = number_2_string($tmp['tongtien']-$tmp['thanhtien'], '');
					$item['giamtheo']    = number_2_string($tmp['giamtheo'], '');
					
                    if ($tmp['tongtien']>0) {
                        $item['phamtramgiam']   =  ((round((($tmp['tongtien']-$tmp['thanhtien'])/($tmp['tongtien'])),2))*100)."%";
                    } else {
                        $item['phamtramgiam'] = "0%";
                    }
					$item['doanhso']   = number_2_string(($tmp['thanhtien'])/($tmp['soluongnv']), '');
                    $item['ds'] = $tmp['thanhtien']/$tmp['soluongnv'];
                    $item['khachmualan']       = $tmp['khachmualan'];
					$item['tennhanvien']       = $tmp['tennhanvien'];
                    $item['ngaydat']        = dbtime_2_systime($tmp['ngaydat'], 'd/m/Y');
					$item['trangthai']       = ($tmp['trangthai']==1)? "Đã giao":"Chờ giao";
                  
                }

                $result[] = $item;
            }
        
            return $result;
        }
    
        return NULL;
    }
		
    function sales_list($from, $to, $cashier = '', $export = FALSE)
    {
        $str = '';
        if (!empty($cashier))
        {
            $str = " AND (n.manv = '{$cashier}') ";
        }

        // Get data from database
        $sql = "SELECT d.`madon`,n.`hoten`, d.`thanhtien`,(select count(employee_id) FROM `employee_of_order` where `order_id` = d.`madon`) AS soluongnv,sum((d.`thanhtien`/(select count(employee_id) FROM `employee_of_order` where `order_id` = d.`madon`)))  AS doanhso,
sum(((select `thanhtien` FROM `donhang` where `madon` = d.`madon` AND ((select count(makhach) FROM `donhang` where `makhach` = d.`makhach`)>1))/(select count(employee_id) FROM `employee_of_order` where `order_id` = d.`madon`)))  AS doanhthulansau,
sum(((select `thanhtien` FROM `donhang` where `madon` = d.`madon` AND ((select count(makhach) FROM `donhang` where `makhach` = d.`makhach`)=1))/(select count(employee_id) FROM `employee_of_order` where `order_id` = d.`madon`)))  AS doanhthulandau
               
                FROM `donhang` d              INNER JOIN `khach` k ON d.`makhach` = k.`makhach`
                                              INNER JOIN `nhomkhach` nk ON k.`manhom` = nk.`manhom`
											  INNER JOIN `employee_of_order` e ON d.`madon` = e.`order_id`
                                              INNER JOIN `nhanvien` n ON e.`employee_id` = n.`manv`
               
			    WHERE (d.ngaydat BETWEEN '{$from}' AND '{$to}') 
                      {$str}
                 GROUP BY n.`manv`
				 ORDER BY d.ngaydat ASC ";
        $db = new database();
        $db->setQuery($sql);
        $array = $db->loadAllRow();
        $db->disconnect();
        
        //debug($sql);
        //debug($array);
    
        if(is_array($array))
        {
            $result = array();
        
            // Create output data
            for($i=0; $i<count($array); $i++)
            {
                $tmp = $array[$i];
            
                if ($export)
                {
                    $item = array();
                  $item['hoten']      = $tmp['hoten'];
					 $item['doanhthulansau']      = round($tmp['doanhthulansau']);
					    $item['doanhthulandau']      = round($tmp['doanhthulandau']);
						  $item['doanhso']      = round($tmp['doanhso']);
                }
                else
                {
                    $item = array();
                   $item['hoten']      = $tmp['hoten'];
					 $item['doanhthulansau']      = round($tmp['doanhthulansau']);
					    $item['doanhthulandau']      = round($tmp['doanhthulandau']);
						  $item['doanhso']      = round($tmp['doanhso']);
                  
                }

                $result[] = $item;
            }
        
            return $result;
        }
    
        return NULL;
    }

try {
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel ();
    
    // Set document properties
    $objPHPExcel->getProperties ()->setCreator ( "Nhi Long" )->setLastModifiedBy ( "Nhi Long" )->setTitle ( "Office 2003 Exported Document" )->setSubject ( "Office 2003 Exported Document" )->setDescription ( "Office 2003 document generated from system." )->setKeywords ( "office 2003 openxml php" )->setCategory ( "Result file" );
    
    // Set the file name
    $file_name = "Export";
    
    /* Processing */
    $columns = array (
            'A',
            'B',
            'C',
            'D',
			'E',
			'F',
			'G',
			'H',
			'I',
			'J',
          
			
    );
	 
    $header = array (
           'Mã hóa đơn' ,                                       
            'Nhóm khách hàng',
            'Tổng tiền',
            'Tiền giảm',
			'Phần trăm giảm',
			'Doanh số',
			'Nhân viên bán',
			'Khách mua lần',
			'Ngày đặt',
			'Trạng thái',
            
    );
	
    
    $file_name = "Thong-ke-doanh-so";	 	
    // Add header data
    for($i = 0; $i < count ( $header ); $i ++) {
        $objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( "{$columns[$i]}1", $header [$i] );
    }	 
    $tmp = count ( $columns ) - 1;
    $objPHPExcel->getActiveSheet ()->getStyle ( "{$columns[0]}1:{$columns[$tmp]}1" )->getFont ()->setBold ( true );	  
    // Get data from database
   
	
	 $arr = order_list($from, $to, $cashier, TRUE);
    // debug($arr); exit();
    if (is_array ( $arr ) && count ( $arr ) > 0) {
        // Starting row index
        $index = 2;
        
        foreach ( $arr as $row ) {
            // Add row data
            $objPHPExcel->setActiveSheetIndex ( 0 )
                        ->setCellValueExplicit("{$columns[0]}{$index}", $row ['madon'], PHPExcel_Cell_DataType::TYPE_STRING)
					   ->setCellValueExplicit("{$columns[1]}{$index}", $row ['nhomkhach'], PHPExcel_Cell_DataType::TYPE_STRING)
                       ->setCellValueExplicit("{$columns[2]}{$index}", $row ['tongtien'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
						->setCellValueExplicit("{$columns[3]}{$index}", $row ['tiengiam'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
						 ->setCellValueExplicit("{$columns[4]}{$index}", $row ['phamtramgiam'], PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit("{$columns[5]}{$index}", $row ['doanhso'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
						 ->setCellValueExplicit("{$columns[6]}{$index}", $row ['tennhanvien'], PHPExcel_Cell_DataType::TYPE_STRING)
						 ->setCellValueExplicit("{$columns[7]}{$index}", $row ['khachmualan'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
                     ->setCellValueExplicit("{$columns[8]}{$index}", $row ['ngaydat'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit("{$columns[9]}{$index}", $row ['trangthai'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ;;

            ;
            
            ;
            
            $index ++;
        }
    }
    // Auto adjust column's width
    foreach ( $columns as $columnID ) {
        $objPHPExcel->getActiveSheet ()->getColumnDimension ( $columnID )->setAutoSize ( true );
    }
    
    // Rename worksheet
    $objPHPExcel->getActiveSheet ()->setTitle ( 'Export' );
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex ( 0 );
    
    // Redirect output to a client's web browser (Excel5)
    header ( 'Content-Type: application/vnd.ms-excel' );
    header ( "Content-Disposition: attachment;filename='{$file_name}.xls'" );
    header ( 'Cache-Control: max-age=0' );
    // If you're serving to IE 9, then the following may be needed
    header ( 'Cache-Control: max-age=1' );
    
    // If you're serving to IE over SSL, then the following may be needed
    header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
    header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
    header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
    header ( 'Pragma: public' ); // HTTP/1.0
    
    $objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
    $objWriter->save ( 'php://output' );
    exit ();
} catch ( Exception $e ) {
    debug ( $e->getMessage () );
}
