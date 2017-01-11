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
do_authenticate ( G_ORDERS, F_ORDERS_CASHED_LIST, TRUE );

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

    // Danh sach don hang da thu tien
    function cashed_list($from, $to, $cashier = '', $export = FALSE)
    {
        $str = '';
        if (!empty($cashier))
        {
            $str = " AND (o.cashed_by = '{$cashier}') ";
        }

        // Get data from database
        $sql = "SELECT d.madon, k.hoten AS khachhang, nk.tennhom AS nhomkhach, d.thanhtien, o.money_amount, d.conlai, 
                       n.hoten AS tennhanvien, o.cashed_date, o.content
                FROM orders_cashing_history o INNER JOIN donhang d ON o.order_id = d.madon
                                              INNER JOIN khach k ON d.makhach = k.makhach
                                              INNER JOIN nhomkhach nk ON k.manhom = nk.manhom
                                              INNER JOIN nhanvien n ON o.cashed_by = n.manv
                WHERE (o.cashed_date BETWEEN '{$from}' AND '{$to}')
                      {$str}
                ORDER BY o.cashed_date ASC";
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
                    $item['loaisp']         = product_type_by_order($tmp['madon']);
                    $item['khachhang']      = $tmp['khachhang'];
                    $item['nhomkhach']      = $tmp['nhomkhach'];
                    $item['tongtien']       = number_2_string($tmp['thanhtien'], '');
                    $item['sotiendathu']    = number_2_string($tmp['money_amount'], '');
                    $item['sotienconlai']   = number_2_string($tmp['thanhtien'] - $tmp['money_amount'], '');
                    $item['nguoithu']       = $tmp['tennhanvien'];
                    $item['ngaythu']        = dbtime_2_systime($tmp['cashed_date'], 'd/m/Y');
                    $item['noidung']        = $tmp['content'];
                }
                else
                {
                    $item = array();
                    $item['madon']          = $tmp['madon'];
                    $item['khachhang']      = $tmp['khachhang'];
                    $item['nhomkhach']      = $tmp['nhomkhach'];
                    $item['tongtien']       = number_2_string($tmp['thanhtien'], '.');
                    $item['sotiendathu']    = number_2_string($tmp['money_amount'], '.');
                    $item['cashed_money']   = $tmp['money_amount'];
                    $item['sotienconlai']   = number_2_string($tmp['thanhtien'] - $tmp['money_amount'], '.');
                    $item['nguoithu']       = $tmp['tennhanvien'];
                    $item['ngaythu']        = dbtime_2_systime($tmp['cashed_date'], 'd/m/Y');
                    $item['noidung']        = $tmp['content'];
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
            'I'
    );
    $header = array (
            'Mã hóa đơn',
            'Loại sản phẩm',
            'Khách hàng',
            'Nhóm khách',
            'Tổng số tiền hóa đơn',
            'Số tiền đã thu',
            'Nhân viên thu',
            'Ngày thu',
            'Nội dung' 
    );
    
    $file_name = "Thong-ke-don-hang-da-thu-tien";
    
    // Add header data
    for($i = 0; $i < count ( $header ); $i ++) {
        $objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( "{$columns[$i]}1", $header [$i] );
    }
    $tmp = count ( $columns ) - 1;
    $objPHPExcel->getActiveSheet ()->getStyle ( "{$columns[0]}1:{$columns[$tmp]}1" )->getFont ()->setBold ( true );
    
    // Get data from database
    $arr = cashed_list($from, $to, $cashier, TRUE);
    // debug($arr); exit();
    if (is_array ( $arr ) && count ( $arr ) > 0) {
        // Starting row index
        $index = 2;
        
        foreach ( $arr as $row ) {
            // Add row data
            $objPHPExcel->setActiveSheetIndex ( 0 )
                        //->setCellValue ( "{$columns[0]}{$index}", $row ['madon'] )
                        ->setCellValueExplicit("{$columns[0]}{$index}", $row ['madon'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue ( "{$columns[1]}{$index}", $row ['loaisp'] )
                        ->setCellValue ( "{$columns[2]}{$index}", $row ['khachhang'] )
                        ->setCellValue ( "{$columns[3]}{$index}", $row ['nhomkhach'] )
                        ->setCellValueExplicit("{$columns[4]}{$index}", $row ['tongtien'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
                        ->setCellValueExplicit("{$columns[5]}{$index}", $row ['sotiendathu'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
                        ->setCellValueExplicit("{$columns[6]}{$index}", $row ['nguoithu'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit("{$columns[7]}{$index}", $row ['ngaythu'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValue ( "{$columns[8]}{$index}", $row ['noidung'] )
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