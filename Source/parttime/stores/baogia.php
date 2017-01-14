<?php
set_time_limit(0);
require_once '../part/common_start_page.php';
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );

// Authenticate
//do_authenticate ( G_ORDERS, F_ORDERS_ORDER_LIST, TRUE );

require_once '../models/database.php';
require_once '../models/tranh.php';

/**
 * Include PHPExcel
 */
require_once '../libs/PHPExcel/1.8.0/Classes/PHPExcel.php';

// Get data to import
function get_data() {
    // Get general information
    $products_model = new tranh();
    $products = $products_model->danh_sach_san_pham_export_excel();
    $detail = array();

    if (is_array ( $products )) {
        foreach ( $products as $z ) {
          if (! in_array ( $z ['masotranh'], $detail )) {
           $detail [$z ['masotranh']] = array (
                   'masotranh' => $z ['masotranh'],
                   'tentranh' => $z ['tentranh'],
                   'maloai' => $z ['maloai'],
                   'dai' => $z ['dai'],
                   'rong' => $z ['rong'],
                   'giaban' => $z ['giaban'],
                   'matho' => $z ['matho'],
                   'ghichu' => $z ['ghichu'],
                   'hinhanh' => $z ['hinhanh']
           );
          } else {
            $detail [$z ['masotranh']] ['amount'] += $z ['soluong'];
          }
        };
    };

    return $products;
}

try {
    // Read the template file
    $inputFileType = 'Excel5';
    $inputFileName = "../uploads/templates/Template_baogia.xls";
    $objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
    $objPHPExcel = $objReader->load ( $inputFileName );

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex ( 0 );
    
    // Get input data
    $detail = get_data (  );
    
    if (is_array ( $detail )) {
        
        /* General information */
        $generalCol = "E";
        
        /* Constants in template */
        $startIndx = 7; // Starting row index
        $spacingNum = 1; // Spacing to total (the number of rows which above the total row)
        
        /* Detail information */
        $count = 0;
        $rowIndx = $startIndx;
        
        foreach ( $detail as $d ) {
            // Add row data to file
            error_log ('HUANA' . $d['tentranh'] . $d ['hinhanh'] . $d ['giaban'] . $rowIndx, 3, '/var/log/phpdebug.log');
            $objPHPExcel->getActiveSheet ()->setCellValue ( "A{$rowIndx}", ++ $count );
            $objPHPExcel->getActiveSheet ()->setCellValue ( "B{$rowIndx}", $d ['masotranh'] ); // Ma hang
            $objPHPExcel->getActiveSheet ()->setCellValue ( "C{$rowIndx}", $d ['tentranh'] ); // Kich thuoc
            //$objPHPExcel->getActiveSheet ()->setCellValue ( "D{$rowIndx}", $d ['hinhanh'] ); // Ten hang
            // Add picture
            if (file_exists('/var/www/html/hethong/' . $d ['hinhanh'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('My Image');
            $objDrawing->setDescription('The Image that I am inserting');
            $objDrawing->setPath('/var/www/html/hethong/' . $d ['hinhanh']);
            $objDrawing->setCoordinates("D{$rowIndx}");
            $objDrawing->setResizeProportional(true);
            $objDrawing->setHeight(160);
            $offsetX =320 - $objDrawing->getWidth();
            $objDrawing->setOffsetX($offsetX);
            //$objDrawing->setWidtht(160, 160);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            } else {
            $objPHPExcel->getActiveSheet ()->setCellValue ( "D{$rowIndx}", 'Hinh khong ton tai' . $d ['hinhanh'] ); // Ten hang
            }
            $objPHPExcel->getActiveSheet ()->setCellValue ( "E{$rowIndx}", $d ['dai'] ); // So luong
            $objPHPExcel->getActiveSheet ()->setCellValue ( "F{$rowIndx}", $d ['rong'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "G{$rowIndx}", $d ['dai'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "H{$rowIndx}", $d ['rong'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "I{$rowIndx}", $d ['giaban'] ); // Don gia
            $objPHPExcel->getActiveSheet ()->setCellValue ( "J{$rowIndx}", $d ['maloai'] ); // Don gia
            
            if ($count < count ( $detail )) {
                $rowIndx ++;
                // Insert a new row after '$rowIndx' index
                $objPHPExcel->getActiveSheet ()->insertNewRowBefore ( $rowIndx, 1 );
            }
        }
        
        /* Set cells style */
        $styleArray = array (
                'alignment' => array (
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER 
                ) 
        );
        $objPHPExcel->getActiveSheet ()->getStyle ( "B{$startIndx}:D{$rowIndx}" )->applyFromArray ( $styleArray );
        
        $styleArray = array (
                'alignment' => array (
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ) 
        );
        $objPHPExcel->getActiveSheet ()->getStyle ( "B{$startIndx}:H{$rowIndx}" )->applyFromArray ( $styleArray );
        
    }
    
    // Redirect output to a client's web browser (Excel5)
    ob_clean();
    header ( 'Content-Type: application/vnd.ms-excel' );
    header ( "Content-Disposition: attachment;filename='Bang bao gia.xls'" );
    header ( 'Cache-Control: max-age=0' );
    // If you're serving to IE 9, then the following may be needed
    header ( 'Cache-Control: max-age=1' );
    header('Content-Type: text/html; charset=UTF-8');
    header("Content-type: application/octetstream");
    
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
