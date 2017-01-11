<?php
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );

// Authenticate
do_authenticate ( G_ORDERS, F_ORDERS_ORDER_LIST, TRUE );

require_once '../models/database.php';
require_once '../models/chitietdonhang.php';

/**
 * Include PHPExcel
 */
require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';

// Get data to import
function get_data($order_id) {
    // Get general information
    $sql = "SELECT donhang.giamtheo, donhang.ngaygiao, donhang.tongtien, donhang.tiengiam, donhang.thanhtien, 
                   donhang.duatruoc, donhang.conlai, 
                   khach.hoten AS khachhang, khach.diachi, khach.quan, khach.tp, khach.dienthoai1, khach.dienthoai2, khach.dienthoai3 
            FROM donhang INNER JOIN khach ON donhang.makhach = khach.makhach 
            WHERE donhang.madon = '{$order_id}'";
    
    $db = new database ();
    $db->setQuery ( $sql );
    $order = mysql_fetch_assoc ( $db->query () );
    $db->disconnect ();
    
    // Get detail information
    $ctdh = new chitietdonhang ();
    $arr = $ctdh->danh_sach_san_pham ( $order_id );
    $detail = array ();
    if (is_array ( $arr )) {
        foreach ( $arr as $z ) {
            if (! in_array ( $z ['masotranh'], $detail )) {
                $detail [$z ['masotranh']] = array (
                        'product_id' => $z ['masotranh'],
                        'size' => "{$z ['dai']}x{$z ['rong']}",
                        'name' => $z ['tentranh'],
                        'amount' => $z ['soluong'],
                        'price' => number_format ( $z ['giaban'], 0, ",", "" ) 
                );
            } else {
                $detail [$z ['masotranh']] ['amount'] += $z ['soluong'];
            }
        }
    }
    
    $output = array (
            'order' => $order,
            'detail' => $detail 
    );
    
    return $output;
}

try {
    // Read the template file
    $inputFileType = 'Excel5';
    $inputFileName = "../uploads/templates/Template_Phieu_Giao_Hang.xls";
    $objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
    $objPHPExcel = $objReader->load ( $inputFileName );
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex ( 0 );
    
    // Get input data
    $madon = (isset ( $_GET ['i'] )) ? $_GET ['i'] : '';
    $arr = get_data ( $madon );
    
    if (is_array ( $arr ['order'] ) && is_array ( $arr ['detail'] )) {
        
        // debug($arr);
        // exit();
        
        /* General information */
        $order = $arr ['order'];
        $generalCol = "E";
        
        // Ma don hang
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}1", " {$madon}" );
        // Khach hang
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}2", $order ['khachhang'] );
        // Dien thoai
        $dienthoai = "";
        if ($order ['dienthoai1'] != "") {
            $dienthoai .= " {$order ['dienthoai1']}";
        }
        if ($order ['dienthoai2'] != "") {
            $dienthoai .= "\n{$order ['dienthoai2']}";
        }
        if ($order ['dienthoai3'] != "") {
            $dienthoai .= "\n{$order ['dienthoai3']}";
        }
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}3", $dienthoai );
        // Dia chi
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}4", $order ['diachi'] . ", " . $order ['quan'] . ", " . $order ['tp'] );
        // Ngay giao
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}6", dbtime_2_systime ( $order ['ngaygiao'], 'd/m/Y' ) );
        
        /* Constants in template */
        $startIndx = 9; // Starting row index
        $spacingNum = 1; // Spacing to total (the number of rows which above the total row)
        
        /* Detail information */
        $detail = $arr ['detail'];
        $count = 0;
        $rowIndx = $startIndx;
        
        foreach ( $detail as $d ) {
            // Add row data to file
            $objPHPExcel->getActiveSheet ()->setCellValue ( "A{$rowIndx}", ++ $count );
            $objPHPExcel->getActiveSheet ()->setCellValue ( "B{$rowIndx}", $d ['product_id'] ); // Ma hang
            $objPHPExcel->getActiveSheet ()->setCellValue ( "C{$rowIndx}", $d ['size'] ); // Kich thuoc
            $objPHPExcel->getActiveSheet ()->setCellValue ( "D{$rowIndx}", $d ['name'] ); // Ten hang
            $objPHPExcel->getActiveSheet ()->setCellValue ( "E{$rowIndx}", $d ['amount'] ); // So luong
            $objPHPExcel->getActiveSheet ()->setCellValue ( "F{$rowIndx}", $d ['price'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$rowIndx}", "=E{$rowIndx} * F{$rowIndx}" );
            
            if ($count < count ( $detail )) {
                $rowIndx ++;
                // Insert a new row after '$rowIndx' index
                $objPHPExcel->getActiveSheet ()->insertNewRowBefore ( $rowIndx, 1 );
            }
        }
        
        /* Set cells style */
        $styleArray = array (
                'alignment' => array (
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT 
                ) 
        );
        $objPHPExcel->getActiveSheet ()->getStyle ( "B{$startIndx}:D{$rowIndx}" )->applyFromArray ( $styleArray );
        
        $styleArray = array (
                'alignment' => array (
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT 
                ) 
        );
        $objPHPExcel->getActiveSheet ()->getStyle ( "F{$startIndx}:G{$rowIndx}" )->applyFromArray ( $styleArray );
        
        /* Fill additional general information */
        $indx = $rowIndx + $spacingNum;
        
        $t = $indx - 1;
        $objPHPExcel->getActiveSheet ()->setCellValue ( "E{$indx}", "=SUM(E{$startIndx}:E{$t})"); // Tong cong
        $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$indx}", "=SUM(G{$startIndx}:G{$t})"); // Tong cong
        
        ++ $indx;
        $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$indx}", ($order ['giamtheo'] == BIT_TRUE) ? "{$order ['tiengiam']}%" : number_format ( $order ['tiengiam'], 0, ",", "" ) );
        
        ++ $indx;
        $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$indx}", number_format ( $order ['duatruoc'], 0, ",", "" ) );
        
        ++ $indx;
        $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$indx}", number_format ( $order ['conlai'], 0, ",", "" ) );
    }
    
    // Redirect output to a client's web browser (Excel5)
    header ( 'Content-Type: application/vnd.ms-excel' );
    header ( "Content-Disposition: attachment;filename='Phieu giao don hang {$madon}.xls'" );
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