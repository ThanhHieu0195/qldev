<?php
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );

// Authenticate
do_authenticate ( G_STORES, F_STORES_SWAP, TRUE );

// require_once '../models/khohang.php';
require_once '../models/items_swapping.php';
require_once '../models/items_swapping_detail.php';

/**
 * Include PHPExcel
 */
require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';
function get_store_name($store_id) {
    $db = new database ();
    $db->setQuery ( "SELECT tenkho FROM khohang WHERE makho = '{$store_id}'" );
    
    $row = mysql_fetch_array ( $db->query () );
    $db->disconnect ();
    
    if (is_array ( $row ) && count ( $row ) > 0) {
        return $row ['tenkho'];
    }
    
    return 'Unknown';
}

try {
    // Read the template file
    $inputFileType = 'Excel5';
    $inputFileName = "../uploads/templates/Template_Phieu_Chuyen_Kho.xls";
    $objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
    $objPHPExcel = $objReader->load ( $inputFileName );
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex ( 0 );
    
    // Get input data
    $swap_uid = (isset ( $_GET ['i'] )) ? $_GET ['i'] : '';
    
    // Get swapping data
    $swapping_model = new items_swapping ();
    $swap = $swapping_model->detail ( $swap_uid );
    
    if ($swap != NULL) {
        
        // debug($arr);
        // exit();
        
        /* General information */
        $generalCol = "F";
        
        // Ma phieu giao
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}1", " {$swap->swap_uid}" );
        // Kho giao
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}2", get_store_name ( $swap->from_store ) );
        // Kho nhan
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}3", get_store_name ( $swap->to_store ) );
        // Ngay giao
        $objPHPExcel->getActiveSheet ()->setCellValue ( "{$generalCol}4", dbtime_2_systime ( $swap->created_date, 'd/m/Y' ) );
        
        /* Constants in template */
        $startIndx = 7; // Starting row index
        $spacingNum = 1; // Spacing to total (the number of rows which above the total row)
        
        /* Detail information */
        $swapping_detail_model = new items_swapping_detail ();
        $detail = $swapping_detail_model->array_by_swapping ( $swap_uid );
        $count = 0;
        $rowIndx = $startIndx;
        
        foreach ( $detail as $d ) {
            // Add row data to file
            $objPHPExcel->getActiveSheet ()->setCellValue ( "A{$rowIndx}", ++ $count );
            $objPHPExcel->getActiveSheet ()->setCellValue ( "B{$rowIndx}", $d ['product_id'] ); // Ma hang
            $objPHPExcel->getActiveSheet ()->setCellValue ( "C{$rowIndx}", $d ['size'] ); // Kich thuoc
            $objPHPExcel->getActiveSheet ()->setCellValue ( "D{$rowIndx}", $d ['name'] ); // Ten hang
            $objPHPExcel->getActiveSheet ()->setCellValue ( "E{$rowIndx}", $d ['unit'] ); // DVT
            $objPHPExcel->getActiveSheet ()->setCellValue ( "F{$rowIndx}", $d ['amount'] ); // So luong
            $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$rowIndx}", number_format ( $d ['price'], 0, ",", "" ) ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "H{$rowIndx}", "=F{$rowIndx} * G{$rowIndx}" );
            
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
        $objPHPExcel->getActiveSheet ()->getStyle ( "G{$startIndx}:H{$rowIndx}" )->applyFromArray ( $styleArray );
        
        /* Fill additional general information */
        $indx = $rowIndx + $spacingNum;
        
        $t = $indx - 1;
        $objPHPExcel->getActiveSheet ()->setCellValue ( "F{$indx}", "=SUM(F{$startIndx}:F{$t})" ); // Tong cong (so luong)
        $objPHPExcel->getActiveSheet ()->setCellValue ( "H{$indx}", "=SUM(H{$startIndx}:H{$t})" ); // Tong cong (thanh tien)
    }
    
    // Redirect output to a client's web browser (Excel5)
    header ( 'Content-Type: application/vnd.ms-excel' );
    header ( "Content-Disposition: attachment;filename='Phieu chuyen kho {$swap_uid}.xls'" );
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